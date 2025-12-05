<div class="p-4 sm:p-6 lg:p-8">
    <div class="max-w-7xl mx-auto">
        
        <!-- Header -->
        <div class="mb-6 sm:mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Student Applications</h1>
                <p class="mt-1 text-sm text-gray-600">All student applications</p>
            </div>
            <div class="flex items-center gap-3">
                <select class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option>All</option>
                    <option>Pending</option>
                    <option>Under Review</option>
                    <option>Approved</option>
                    <option>Rejected</option>
                </select>
            </div>
        </div>

        <!-- Table Card -->
        <div class="bg-white shadow-lg rounded-lg sm:rounded-xl border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    
                    <!-- Table Header -->
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-4 sm:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                ID
                            </th>
                            <th scope="col" class="px-4 sm:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Student
                            </th>
                            <th scope="col" class="hidden md:table-cell px-4 sm:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Contact
                            </th>
                            <th scope="col" class="hidden lg:table-cell px-4 sm:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Program
                            </th>
                            <th scope="col" class="px-4 sm:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-4 sm:px-6 py-3 sm:py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider w-24 sm:w-32">
                                Actions
                            </th>
                        </tr>
                    </thead>

                    <!-- Table Body -->
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($applications as $app)
                            <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                
                                <!-- ID -->
                                <td class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                    <span class="text-sm font-medium text-gray-900">#{{ $app->id }}</span>
                                </td>
                                
                                <!-- Student Info -->
                                <td class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="shrink-0 h-8 w-8 sm:h-10 sm:w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                            <svg class="h-4 w-4 sm:h-5 sm:w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                        </div>
                                        <div class="ml-3 sm:ml-4">
                                            <div class="text-sm font-semibold text-gray-900">
                                                {{ $app->first_name }} {{ $app->last_name }}
                                            </div>
                                            <div class="text-xs text-gray-500">{{ $app->nationality }}</div>
                                        </div>
                                    </div>
                                </td>
                                
                                <!-- Contact (Hidden on mobile) -->
                                <td class="hidden md:table-cell px-4 sm:px-6 py-3 sm:py-4">
                                    <div class="text-sm text-gray-900">{{ $app->email }}</div>
                                    <div class="text-xs text-gray-500">{{ $app->phone }}</div>
                                </td>
                                
                                <!-- Program (Hidden on tablet) -->
                                <td class="hidden lg:table-cell px-4 sm:px-6 py-3 sm:py-4">
                                    <div class="text-sm text-gray-900">{{ $app->application?->program?->name ?? 'N/A' }}</div>
                                </td>
                                
                                <!-- Status -->
                                <td class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                    @if($app->application)
                                        @php
                                            $statusColors = [
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'under_review' => 'bg-blue-100 text-blue-800',
                                                'approved' => 'bg-green-100 text-green-800',
                                                'rejected' => 'bg-red-100 text-red-800',
                                            ];
                                            $statusColor = $statusColors[$app->application->status->value] ?? 'bg-gray-100 text-gray-800';
                                        @endphp
                                        <span class="inline-flex items-center px-2 sm:px-3 py-1 rounded-full text-xs font-medium {{ $statusColor }}">
                                            {{ ucfirst($app->application->status->value) }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 sm:px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            N/A
                                        </span>
                                    @endif
                                </td>
                                
                                <!-- Actions -->
                                <td class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center gap-1 sm:gap-2">
                                        <a href="{{ route('admin.applications.student.show', ['student' => $app->id]) }}" class="inline-flex items-center px-2 sm:px-3 py-1 sm:py-1.5 bg-indigo-100 hover:bg-indigo-200 text-indigo-700 text-xs font-medium rounded-md transition duration-150 ease-in-out">
                                           <svg class="w-3 h-3 sm:w-4 sm:h-4 sm:mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                           </svg>
                                           <span class="hidden sm:inline">Bax</span>
                                       </a>
                                   </div>
                               </td>
                                
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">Application not found</h3>
                                    <p class="mt-1 text-sm text-gray-500">There is no application yet.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($applications->hasPages())
            <div class="mt-6">
                {{ $applications->links() }}
            </div>
        @endif

    </div>
</div>
