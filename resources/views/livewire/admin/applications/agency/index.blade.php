<div class="p-4 sm:p-6 lg:p-8">
    <div class="max-w-7xl mx-auto">
        
        <!-- Header -->
        <div class="mb-6 sm:mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Agentlik Müraciətləri</h1>
                <p class="mt-1 text-sm text-gray-600">Bütün agentlik müraciətlərini idarə edin</p>
            </div>
            <div class="flex items-center gap-3">
                <select class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option>Hamısı</option>
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
                                Agentlik
                            </th>
                            <th scope="col" class="hidden md:table-cell px-4 sm:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Əlaqə Şəxsi
                            </th>
                            <th scope="col" class="hidden lg:table-cell px-4 sm:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Ünvan
                            </th>
                            <th scope="col" class="px-4 sm:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-4 sm:px-6 py-3 sm:py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider w-24 sm:w-32">
                                Əməliyyatlar
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
                                
                                <!-- Agency Info -->
                                <td class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="shrink-0 h-8 w-8 sm:h-10 sm:w-10 bg-purple-100 rounded-full flex items-center justify-center">
                                            <svg class="h-4 w-4 sm:h-5 sm:w-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                            </svg>
                                        </div>
                                        <div class="ml-3 sm:ml-4">
                                            <div class="text-sm font-semibold text-gray-900">
                                                {{ $app->agency_name }}
                                            </div>
                                            <div class="text-xs text-gray-500">{{ $app->country }}</div>
                                        </div>
                                    </div>
                                </td>
                                
                                <!-- Contact Person (Hidden on mobile) -->
                                <td class="hidden md:table-cell px-4 sm:px-6 py-3 sm:py-4">
                                    <div class="text-sm text-gray-900">{{ $app->contact_name }}</div>
                                    <div class="text-xs text-gray-500">{{ $app->contact_email }}</div>
                                </td>
                                
                                <!-- Address (Hidden on tablet) -->
                                <td class="hidden lg:table-cell px-4 sm:px-6 py-3 sm:py-4">
                                    <div class="text-sm text-gray-900">{{ $app->city }}</div>
                                    <div class="text-xs text-gray-500">{{ $app->country }}</div>
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
                                        <a href="#" class="inline-flex items-center px-2 sm:px-3 py-1 sm:py-1.5 bg-indigo-100 hover:bg-indigo-200 text-indigo-700 text-xs font-medium rounded-md transition duration-150 ease-in-out">
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
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">Müraciət tapılmadı</h3>
                                    <p class="mt-1 text-sm text-gray-500">Hələ heç bir agentlik müraciəti yoxdur.</p>
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
