<div class="p-4 sm:p-6 lg:p-8">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Tələbə Panelinə Xoş Gəlmisiniz</h1>
        <p class="text-base sm:text-lg text-gray-600 mb-6 sm:mb-8">Müraciət məlumatlarınızı buradan görüntüləyə bilərsiniz.</p>
        
        @if($application)
            <!-- Application Information Card -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 sm:p-8 mb-6">
                <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-6">Müraciət Məlumatları</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Program Information -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Proqram</label>
                            <p class="text-lg font-semibold text-gray-900">
                                {{ $application->program->name ?? 'N/A' }}
                            </p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Dərəcə</label>
                            <p class="text-lg font-semibold text-gray-900">
                                {{ $application->program->degree->name ?? 'N/A' }}
                            </p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Fakültə</label>
                            <p class="text-lg font-semibold text-gray-900">
                                {{ $application->program->faculty->name ?? ($application->faculty_name ?? 'N/A') }}
                            </p>
                        </div>
                    </div>
                    
                    <!-- Application Status -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Müraciət Statusu</label>
                            <div class="mt-1">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'under_review' => 'bg-blue-100 text-blue-800',
                                        'approved' => 'bg-green-100 text-green-800',
                                        'rejected' => 'bg-red-100 text-red-800',
                                    ];
                                    $statusLabels = [
                                        'pending' => 'Gözləyir',
                                        'under_review' => 'Nəzərdən keçirilir',
                                        'approved' => 'Təsdiqləndi',
                                        'rejected' => 'Rədd edildi',
                                    ];
                                    $status = $application->status->value ?? 'pending';
                                    $color = $statusColors[$status] ?? 'bg-gray-100 text-gray-800';
                                    $label = $statusLabels[$status] ?? ucfirst($status);
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $color }}">
                                    {{ $label }}
                                </span>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Müraciət Tarixi</label>
                            <p class="text-lg font-semibold text-gray-900">
                                {{ $application->submitted_at ? $application->submitted_at->format('d.m.Y H:i') : 'N/A' }}
                            </p>
                        </div>
                        
                        @if($application->reviewed_at)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Nəzərdən Keçirilmə Tarixi</label>
                            <p class="text-lg font-semibold text-gray-900">
                                {{ $application->reviewed_at->format('d.m.Y H:i') }}
                            </p>
                        </div>
                        @endif
                        
                        @if($application->program->price_per_year)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">İllik Ödəniş</label>
                            <p class="text-lg font-semibold text-gray-900">
                                {{ number_format($application->program->price_per_year, 2) }} AZN
                            </p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Student Personal Information -->
            @if($application->studentApplication)
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 sm:p-8">
                <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-6">Şəxsi Məlumatlar</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Ad</label>
                        <p class="text-lg font-semibold text-gray-900">
                            {{ $application->studentApplication->first_name ?? 'N/A' }}
                        </p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Soyad</label>
                        <p class="text-lg font-semibold text-gray-900">
                            {{ $application->studentApplication->last_name ?? 'N/A' }}
                        </p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Ata Adı</label>
                        <p class="text-lg font-semibold text-gray-900">
                            {{ $application->studentApplication->father_name ?? 'N/A' }}
                        </p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Cins</label>
                        <p class="text-lg font-semibold text-gray-900">
                            {{ $application->studentApplication->gender ?? 'N/A' }}
                        </p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Doğum Tarixi</label>
                        <p class="text-lg font-semibold text-gray-900">
                            {{ $application->studentApplication->date_of_birth ? $application->studentApplication->date_of_birth->format('d.m.Y') : 'N/A' }}
                        </p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Telefon</label>
                        <p class="text-lg font-semibold text-gray-900">
                            {{ $application->studentApplication->phone ?? 'N/A' }}
                        </p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Email</label>
                        <p class="text-lg font-semibold text-gray-900">
                            {{ $application->studentApplication->email ?? 'N/A' }}
                        </p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Vətəndaşlıq</label>
                        <p class="text-lg font-semibold text-gray-900">
                            {{ $application->studentApplication->nationality ?? 'N/A' }}
                        </p>
                    </div>
                </div>
            </div>
            @endif
            
        @else
            <!-- No Application -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">Müraciət tapılmadı</h3>
                <p class="mt-2 text-sm text-gray-500">
                    Hələ heç bir müraciət göndərməmisiniz.
                </p>
            </div>
        @endif
        
    </div>
</div>
