<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-50 via-white to-purple-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <!-- Logo and Title -->
        <div class="text-center">
            <div class="flex justify-center mb-6">
                <div class="bg-indigo-600 p-4 rounded-2xl shadow-lg">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.040A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
            </div>
            <h2 class="text-3xl font-extrabold text-gray-900">
                Two-Factor Authentication
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                @if($setupMode)
                    Set up Google Authenticator to protect your account
                @else
                    Enter the 6-digit code from Google Authenticator
                @endif
            </p>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-8 space-y-6">
            @if($error)
                <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded">
                    <div class="flex">
                        <div class="shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700">{{ $error }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if($setupMode && $qrCodeSvg)
                <!-- First-time setup -->
                <ol class="text-sm text-gray-700 space-y-2 list-decimal list-inside">
                    <li>Install <span class="font-medium">Google Authenticator</span> on your phone.</li>
                    <li>Tap <span class="font-medium">+</span> → <span class="font-medium">Scan a QR code</span> and scan the code below.</li>
                    <li>Enter the 6-digit code shown in the app to finish setup.</li>
                </ol>

                <div class="flex justify-center">
                    <div class="p-3 bg-white border border-gray-200 rounded-xl">
                        {!! $qrCodeSvg !!}
                    </div>
                </div>

                <p class="text-xs text-gray-500 text-center">
                    Do not share or take screenshots of this QR code.
                </p>
            @endif

            <form wire:submit="verify" class="space-y-6">
                <div>
                    <label for="code" class="block text-sm font-medium text-gray-700 mb-2">
                        Verification Code
                    </label>
                    <input
                        id="code"
                        name="code"
                        type="text"
                        wire:model="code"
                        inputmode="numeric"
                        pattern="[0-9 ]*"
                        maxlength="7"
                        autocomplete="one-time-code"
                        autofocus
                        required
                        class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-lg text-center text-2xl tracking-[0.5em] placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-150 @error('code') border-red-300 @enderror"
                        placeholder="000000"
                    >
                    @error('code')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <button
                        type="submit"
                        wire:loading.attr="disabled"
                        wire:target="verify"
                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 disabled:opacity-50 disabled:cursor-not-allowed shadow-lg hover:shadow-xl"
                    >
                        <span wire:loading.remove wire:target="verify">
                            {{ $setupMode ? 'Confirm & Login' : 'Verify' }}
                        </span>
                        <span wire:loading wire:target="verify" class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </span>
                    </button>
                </div>
            </form>

            <div class="text-center">
                <button type="button" wire:click="cancel" class="text-sm text-gray-500 hover:text-indigo-600">
                    ← Back to login
                </button>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center">
            <p class="text-xs text-gray-500">
                © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </p>
        </div>
    </div>
</div>
