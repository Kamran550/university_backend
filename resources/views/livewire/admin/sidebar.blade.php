<aside 
    x-cloak
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed lg:static inset-y-0 left-0 z-50 w-64 bg-gray-800 text-white transform transition-transform duration-300 ease-in-out lg:translate-x-0 shrink-0"
    wire:poll.5s="refreshCounts">

    <div class="h-full flex flex-col">

        <!-- Logo -->
        <div class="px-4 py-4 border-b border-gray-700 flex items-center justify-between">
            <h1 class="text-xl font-bold">{{ config('app.name', 'Admin') }}</h1>

            <!-- Close (mobile only) -->
            <button 
                @click="sidebarOpen = false" 
                class="lg:hidden text-gray-400 hover:text-white focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">

            <!-- Dashboard -->
            <a 
                href="{{ route('admin.dashboard') }}"
                class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition"
                @click="sidebarOpen = false">
                Dashboard
            </a>

            <!-- Faculties -->
            <a 
                href="{{ route('admin.faculties.index') }}"
                class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition"
                @click="sidebarOpen = false">
                Fakültələr
            </a>

            <!-- Degrees -->
            <a 
                href="{{ route('admin.degrees.index') }}"
                class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition"
                @click="sidebarOpen = false">
                Dərəcələr
            </a>

            <!-- Applications Dropdown -->
            <div x-data="{ open: false }">

                <!-- Dropdown Button -->
                <button 
                    @click="open = !open"
                    class="w-full flex items-center justify-between px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition">

                    <div class="flex items-center space-x-2">
                        <span>Müraciətlər</span>

                        <!-- If you want a badge -->
                        @if($studentCount + $agencyCount > 0)
                            <span class="bg-red-600 text-white text-xs px-2 py-0.5 rounded-full">
                                {{ $studentCount + $agencyCount }}
                            </span>
                        @endif
                    </div>

                    <svg class="w-4 h-4 transition-transform"
                         :class="open ? 'rotate-180' : ''"
                         fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <!-- Dropdown Items -->
                <div x-show="open" x-collapse class="ml-6 mt-1 space-y-1">

                    <!-- Student Applications -->
                    <a 
                        href="{{ route('admin.applications.student.index') }}"
                        class="block px-4 py-2 text-gray-400 hover:text-white hover:bg-gray-700 rounded-lg transition"
                        @click="sidebarOpen = false">
                        Tələbə
                        @if($studentCount > 0)
                            <span class="bg-red-600 text-white text-xs px-2 py-0.5 rounded-full ml-2">
                                {{ $studentCount }}
                            </span>
                        @endif
                    </a>

                    <!-- Agency Applications -->
                    <a 
                        href="{{ route('admin.applications.agency.index') }}"
                        class="block px-4 py-2 text-gray-400 hover:text-white hover:bg-gray-700 rounded-lg transition"
                        @click="sidebarOpen = false">
                        Agentlik
                        @if($agencyCount > 0)
                            <span class="bg-red-600 text-white text-xs px-2 py-0.5 rounded-full ml-2">
                                {{ $agencyCount }}
                            </span>
                        @endif
                    </a>

                </div>
            </div>

        </nav>

    </div>
</aside>
