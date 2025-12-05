<div class="min-h-screen bg-white">
    <!-- Header -->
    <header class="w-full px-6 sm:px-8 py-4 sm:py-6 border-b border-gray-200">
        <div class="max-w-7xl mx-auto flex items-center">
            <div class="flex items-center gap-3">
                <img 
                        src="{{ asset('images/EIPU-logo-dark.png') }}" 
                    alt="EIPU Logo" 
                    class="h-16 sm:h-15 md:h-24 w-auto object-contain"
                >
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="min-h-[calc(100vh-120px)] px-4 py-8 sm:py-12">
        @if(!$application || $messageType !== 'success')
            <!-- Verification Form (only show if not verified) -->
            <div class="flex items-center justify-center">
                <div class="w-full max-w-lg">
                    <!-- Verification Icon -->
                    <div class="flex justify-center mb-6">
                        <div class="w-20 h-20 sm:w-24 sm:h-24 bg-purple-100 rounded-full flex items-center justify-center">
                            <svg class="w-10 h-10 sm:w-12 sm:h-12 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>

                    <!-- Title -->
                    <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 text-center mb-4">
                        Sənəd Təsdiqi
                    </h2>

                    <!-- Instructions -->
                    <p class="text-base sm:text-lg text-gray-600 text-center mb-8 max-w-md mx-auto">
                        Sənədini burada təsdiq edə bilərsən. Zəhmə olmasa aşağıdakı təsdiqlənmə kodunu daxil et.
                    </p>

                    <!-- Verification Form -->
                    <form wire:submit.prevent="verify" class="space-y-6">
                        <!-- Verification ID Input -->
                        <div>
                            <label for="verificationCode" class="block text-sm font-medium text-gray-700 mb-2">
                                Təsdiqlənmə Kodunu Daxil Et
                            </label>
                            <input 
                                type="text" 
                                id="verificationCode"
                                wire:model="verificationCode"
                                placeholder="Təsdiqlənmə kodunu daxil et"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition-all text-base"
                                autocomplete="off"
                                autofocus
                            >
                        </div>

                        <!-- Continue Button -->
                        <button 
                            type="submit"
                            wire:loading.attr="disabled"
                            class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
                        >
                            <span wire:loading.remove wire:target="verify">Davam Et</span>
                            <span wire:loading wire:target="verify">Təsdiq edilir...</span>
                            <svg wire:loading.remove wire:target="verify" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    </form>

                    <!-- Message Display -->
                    @if($message && $messageType !== 'success')
                        <div class="mt-6 p-4 rounded-lg bg-red-50 border border-red-200">
                            <p class="text-sm text-red-800 text-center font-medium">
                                {{ $message }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <!-- Success Message and PDF Display -->
        @if($application && $messageType === 'success')
            <div class="max-w-7xl mx-auto">
                <!-- Success Message -->
                <div class="mb-6 p-4 rounded-lg bg-green-50 border border-green-200">
                    <p class="text-base text-green-800 text-center font-semibold">
                        Təsdiqlənmə uğurlu oldu!
                    </p>
                </div>

                <!-- PDF Display -->
                @php
                    $pdfUrl = $this->getPdfUrl();
                @endphp
                @if($pdfUrl)
                    <div class="bg-white rounded-lg border border-gray-200 shadow-lg overflow-hidden">
                        <div class="p-4 bg-gray-50 border-b border-gray-200">
                            <h3 class="text-xl font-semibold text-gray-800">
                                @if($application->document_type === \App\Enums\DocumentTypeEnum::ACCEPTANCE)
                                    Acceptance Letter
                                @elseif($application->document_type === \App\Enums\DocumentTypeEnum::CERTIFICATE)
                                    Certificate
                                @else
                                    Document
                                @endif
                            </h3>
                        </div>
                        <div class="w-full" style="height: calc(100vh - 250px); min-height: 900px;">
                            <iframe 
                                src="{{ $pdfUrl }}" 
                                class="w-full h-full border-0"
                                title="{{ $application->document_type === \App\Enums\DocumentTypeEnum::ACCEPTANCE ? 'Acceptance Letter' : 'Certificate' }}"
                            ></iframe>
                        </div>
                    </div>
                @else
                    <div class="p-4 rounded-lg bg-yellow-50 border border-yellow-200">
                        <p class="text-sm text-yellow-800 text-center font-medium">
                            PDF not found.
                        </p>
                    </div>
                @endif
            </div>
        @endif
    </main>
</div>