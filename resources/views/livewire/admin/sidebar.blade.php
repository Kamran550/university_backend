<aside x-cloak :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed lg:static inset-y-0 left-0 z-50 w-64 bg-gray-800 text-white transform transition-transform duration-300 ease-in-out lg:translate-x-0 shrink-0">

    <div wire:poll.5s="refreshCounts" class="h-full flex flex-col">

        <!-- Logo -->
        <div class="px-4 py-4 border-b border-gray-700 flex items-center justify-between">
            <div class="flex items-center">
                <img src="{{ asset('images/EIPU-logo-dark.png') }}" alt="EIPU Logo" class="h-17 w-auto object-contain">
            </div>

            <!-- Close (mobile only) -->
            <button @click="sidebarOpen = false" class="lg:hidden text-gray-400 hover:text-white focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">

            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition"
                @click="sidebarOpen = false">
                Dashboard
            </a>

            <!-- Students -->
            <a href="{{ route('admin.students.index') }}"
                class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition"
                @click="sidebarOpen = false">
                Students
            </a>

            <!-- Teachers -->
            <a href="{{ route('admin.teachers.index') }}"
                class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition"
                @click="sidebarOpen = false">
                Teachers
            </a>

            <!-- Payments -->
            <a href="{{ route('admin.payments.index') }}"
                class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition"
                @click="sidebarOpen = false">
                Payments
            </a>

            <!-- Academics Dropdown -->
            <div x-data="{ open: false }">
                <!-- Dropdown Button -->
                <button @click="open = !open"
                    class="w-full flex items-center justify-between px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition">
                    <span>Akademik</span>
                    <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <!-- Dropdown Items -->
                <div x-show="open" x-collapse class="ml-6 mt-1 space-y-1">
                    <a href="{{ route('admin.programs.index') }}"
                        class="block px-4 py-2 text-gray-400 hover:text-white hover:bg-gray-700 rounded-lg transition"
                        @click="sidebarOpen = false">
                        Programs
                    </a>

                    <a href="{{ route('admin.degrees.index') }}"
                        class="block px-4 py-2 text-gray-400 hover:text-white hover:bg-gray-700 rounded-lg transition"
                        @click="sidebarOpen = false">
                        Degrees
                    </a>
                    <a href="{{ route('admin.faculties.index') }}"
                        class="block px-4 py-2 text-gray-400 hover:text-white hover:bg-gray-700 rounded-lg transition"
                        @click="sidebarOpen = false">
                        Faculties
                    </a>

                </div>
            </div>

            <!-- Applications Dropdown -->
            <div x-data="{ open: false }">

                <!-- Dropdown Button -->
                <button @click="open = !open"
                    class="w-full flex items-center justify-between px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition">

                    <div class="flex items-center space-x-2">
                        <span>Applications</span>

                        <!-- If you want a badge -->
                        @if ($studentCount + $agencyCount > 0)
                            <span class="bg-red-600 text-white text-xs px-2 py-0.5 rounded-full">
                                {{ $studentCount + $agencyCount }}
                            </span>
                        @endif
                    </div>

                    <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <!-- Dropdown Items -->
                <div x-show="open" x-collapse class="ml-6 mt-1 space-y-1">

                    <!-- Student Applications -->
                    <a href="{{ route('admin.applications.student.index') }}"
                        class="block px-4 py-2 text-gray-400 hover:text-white hover:bg-gray-700 rounded-lg transition"
                        @click="sidebarOpen = false">
                        Students
                        @if ($studentCount > 0)
                            <span class="bg-red-600 text-white text-xs px-2 py-0.5 rounded-full ml-2">
                                {{ $studentCount }}
                            </span>
                        @endif
                    </a>

                    <!-- Agency Applications -->
                    <a href="{{ route('admin.applications.agency.index') }}"
                        class="block px-4 py-2 text-gray-400 hover:text-white hover:bg-gray-700 rounded-lg transition"
                        @click="sidebarOpen = false">
                        Agencies
                        @if ($agencyCount > 0)
                            <span class="bg-red-600 text-white text-xs px-2 py-0.5 rounded-full ml-2">
                                {{ $agencyCount }}
                            </span>
                        @endif
                    </a>

                </div>
            </div>

        </nav>

        <!-- Profile Section -->
        @auth
            <div class="border-t border-gray-700 p-4">
                <div x-data="{ profileOpen: false }" class="relative">
                    <!-- Profile Button -->
                    <button @click="profileOpen = !profileOpen" @click.away="profileOpen = false"
                        class="w-full flex items-center gap-3 px-3 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition">
                        <!-- Profile Icon -->
                        <div class="w-10 h-10 bg-indigo-600 rounded-full flex items-center justify-center shrink-0">
                            <span class="text-white font-semibold text-sm">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}{{ strtoupper(substr(Auth::user()->surname ?? '', 0, 1)) }}
                            </span>
                        </div>
                        <!-- User Info -->
                        <div class="flex-1 text-left min-w-0">
                            <p class="text-sm font-medium truncate">
                                {{ Auth::user()->name }} {{ Auth::user()->surname }}
                            </p>
                            <p class="text-xs text-gray-400 truncate">
                                {{ Auth::user()->email }}
                            </p>
                        </div>
                        <!-- Dropdown Arrow -->
                        <svg class="w-4 h-4 transition-transform shrink-0" :class="profileOpen ? 'rotate-180' : ''"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="profileOpen" x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95" style="display: none;"
                        class="absolute bottom-full left-0 right-0 mb-2 bg-gray-700 rounded-lg shadow-lg overflow-hidden z-50">

                        <!-- Change Password -->
                        <a href="{{ route('admin.change-password') }}" @click="profileOpen = false"
                            class="w-full flex items-center gap-3 px-4 py-3 text-gray-300 hover:bg-gray-600 hover:text-white transition text-left">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                            </svg>
                            <span>Change Password</span>
                        </a>

                        <!-- Divider -->
                        <div class="border-t border-gray-600"></div>

                        <!-- Logout -->
                        @livewire('admin.auth.logout')
                    </div>
                </div>
            </div>
        @endauth

    </div>
</aside>
