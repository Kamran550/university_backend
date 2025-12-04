<aside 
    x-cloak
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed lg:static inset-y-0 left-0 z-50 w-64 bg-gray-800 text-white transform transition-transform duration-300 ease-in-out lg:translate-x-0 shrink-0"
    >

    <div class="h-full flex flex-col">

        <!-- Logo -->
        <div class="px-4 py-4 border-b border-gray-700 flex items-center justify-between">
            <div class="flex items-center">
                <img 
                    src="{{ asset('images/EIPU-logo-dark.png') }}" 
                    alt="EIPU Logo" 
                    class="h-17 w-auto object-contain"
                >
            </div>

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
                href="{{ route('student.dashboard') }}"
                class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition"
                @click="sidebarOpen = false">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>

        </nav>

        <!-- Profile Section -->
        @auth
        <div class="border-t border-gray-700 p-4">
            <div x-data="{ profileOpen: false }" class="relative">
                <!-- Profile Button -->
                <button 
                    @click="profileOpen = !profileOpen"
                    @click.away="profileOpen = false"
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
                    <svg class="w-4 h-4 transition-transform shrink-0"
                         :class="profileOpen ? 'rotate-180' : ''"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <!-- Dropdown Menu -->
                <div 
                    x-show="profileOpen"
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95"
                    style="display: none;"
                    class="absolute bottom-full left-0 right-0 mb-2 bg-gray-700 rounded-lg shadow-lg overflow-hidden z-50">
                    
                    <!-- Profile Settings -->
                    <a 
                        href="{{ route('student.profile') }}"
                        @click="profileOpen = false"
                        class="w-full flex items-center gap-3 px-4 py-3 text-gray-300 hover:bg-gray-600 hover:text-white transition text-left">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span>Profil ayarları</span>
                    </a>

                    <!-- Divider -->
                    <div class="border-t border-gray-600"></div>

                    <!-- Logout -->
                    @livewire('student.auth.logout')
                </div>
            </div>
        </div>
        @endauth

    </div>
</aside>
