<div class="p-6 max-w-7xl mx-auto">
    
    <!-- Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Tələbələr</h1>
            <p class="mt-1 text-sm text-gray-600">Bütün tələbələri görüntüləyin və idarə edin</p>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="mb-6">
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <input 
                type="text" 
                wire:model.live.debounce.300ms="search"
                placeholder="Ad, Soyad, Email, İstifadəçi adı və ya Telefon ilə axtarın..."
                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            >
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white shadow-lg rounded-xl border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                
                <!-- Table Header -->
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            ID
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Tələbə
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Email
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            İstifadəçi adı
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Telefon
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Qeydiyyat tarixi
                        </th>
                    </tr>
                </thead>

                <!-- Table Body -->
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($students as $student)
                        <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                            
                            <!-- ID -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-medium text-gray-900">{{ $student->id }}</span>
                            </td>
                            
                            <!-- Student Name -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="shrink-0 h-10 w-10 bg-indigo-100 rounded-full flex items-center justify-center">
                                        @if($student->profile_photo)
                                            <img src="{{ asset('storage/' . $student->profile_photo) }}" alt="{{ $student->name }}" class="h-10 w-10 rounded-full object-cover">
                                        @else
                                            <span class="text-indigo-600 font-semibold text-sm">
                                                {{ strtoupper(substr($student->name, 0, 1)) }}{{ strtoupper(substr($student->surname ?? '', 0, 1)) }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-semibold text-gray-900">
                                            {{ $student->name }} {{ $student->surname }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Email -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $student->email }}</div>
                            </td>

                            <!-- Username -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $student->username ?? '-' }}</div>
                            </td>

                            <!-- Phone -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $student->phone ?? '-' }}</div>
                            </td>

                            <!-- Created At -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ $student->created_at->format('d.m.Y') }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ $student->created_at->format('H:i') }}
                                </div>
                            </td>
                            
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">Tələbə tapılmadı</h3>
                                <p class="mt-1 text-sm text-gray-500">
                                    @if($search)
                                        "{{ $search }}" üçün heç bir nəticə tapılmadı.
                                    @else
                                        Hələ heç bir tələbə qeydiyyatdan keçməyib.
                                    @endif
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if ($students->hasPages())
    <div class="mt-6">
        {{ $students->links() }}
    </div>
    @endif

</div>
