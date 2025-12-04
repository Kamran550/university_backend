<div class="p-4 sm:p-6 lg:p-8">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Admin Panel-ə Xoş Gəlmisiniz</h1>
        <p class="text-base sm:text-lg text-gray-600 mb-6 sm:mb-8">Bu admin idarəetmə səhifəsidir.</p>
        
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8">
            
            <!-- Students Card -->
            <div class="bg-white rounded-lg sm:rounded-xl shadow-lg border border-gray-200 p-4 sm:p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs sm:text-sm font-medium text-gray-600">Tələbələr</p>
                        <p class="text-2xl sm:text-3xl font-bold text-gray-900 mt-1 sm:mt-2">{{ number_format($studentsCount) }}</p>
                    </div>
                    <div class="p-2 sm:p-3 bg-blue-100 rounded-full">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
            
            <!-- Teachers Card -->
            <div class="bg-white rounded-lg sm:rounded-xl shadow-lg border border-gray-200 p-4 sm:p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs sm:text-sm font-medium text-gray-600">Müəllimlər</p>
                        <p class="text-2xl sm:text-3xl font-bold text-gray-900 mt-1 sm:mt-2">{{ number_format($teachersCount) }}</p>
                    </div>
                    <div class="p-2 sm:p-3 bg-purple-100 rounded-full">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
            
            <!-- Programs Card -->
            <div class="bg-white rounded-lg sm:rounded-xl shadow-lg border border-gray-200 p-4 sm:p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs sm:text-sm font-medium text-gray-600">Proqramlar</p>
                        <p class="text-2xl sm:text-3xl font-bold text-gray-900 mt-1 sm:mt-2">{{ number_format($programsCount) }}</p>
                    </div>
                    <div class="p-2 sm:p-3 bg-indigo-100 rounded-full">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                </div>
            </div>
            
            <!-- Applications Card -->
            <div class="bg-white rounded-lg sm:rounded-xl shadow-lg border border-gray-200 p-4 sm:p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs sm:text-sm font-medium text-gray-600">Müraciətlər</p>
                        <p class="text-2xl sm:text-3xl font-bold text-gray-900 mt-1 sm:mt-2">{{ number_format($applicationsCount) }}</p>
                    </div>
                    <div class="p-2 sm:p-3 bg-yellow-100 rounded-full">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                </div>
                @if($pendingApplicationsCount > 0)
                    <p class="text-xs sm:text-sm text-yellow-600 mt-3 sm:mt-4">{{ $pendingApplicationsCount }} gözləyən</p>
                @endif
            </div>
            
        </div>
        
        
    </div>
</div>
