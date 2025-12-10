<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Student Panel</title>
    
    <link rel="icon" type="image/png" href="{{ asset('images/EIPU-simvol.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="min-h-screen bg-gray-100 antialiased" x-data="{ sidebarOpen: false }" @keydown.escape="sidebarOpen = false">
    
    <!-- Sidebar -->
    <div class="flex h-screen overflow-hidden">
        <livewire:student.sidebar />
        <!-- Mobile Overlay -->
        <div 
            x-show="sidebarOpen" 
            @click="sidebarOpen = false"
            x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-900 bg-opacity-50 z-40 lg:hidden"
            style="display: none;"
        ></div>
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden lg:ml-0">
            
            <!-- Top Bar -->
            <header class="bg-white shadow-sm sticky top-0 z-30">
                <div class="px-4 sm:px-6 py-3 sm:py-4 flex items-center justify-between">
                    <div class="flex items-center gap-3 sm:gap-4">
                        <!-- Hamburger Menu (mobile only) -->
                        <button 
                            @click="sidebarOpen = true" 
                            class="lg:hidden text-gray-600 hover:text-gray-900 focus:outline-none"
                        >
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                        <h2 class="text-lg sm:text-xl font-semibold text-gray-800">Student Panel</h2>
                    </div>
                    <div class="flex items-center space-x-2 sm:space-x-4">
                    </div>
                </div>
            </header>
            
            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-gray-100">
                {{ $slot }}
            </main>
            
        </div>
    </div>

    @livewireScripts
</body>
</html>
