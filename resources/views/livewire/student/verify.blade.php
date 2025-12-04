<div class="min-h-screen flex items-center justify-center px-4 py-8">
    <div class="w-full max-w-md">
        <!-- Logo -->
        <div class="flex justify-center mb-8">
            <img 
                src="{{ asset('images/EIPU-logo-dark.png') }}" 
                alt="EIPU Logo" 
                class="max-w-full h-auto"
                style="max-width: 300px; height: auto;"
            >
        </div>

        <!-- Verification Form -->
        <div class="bg-white rounded-lg shadow-lg p-6 md:p-8">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 text-center mb-6">
                Document Verification
            </h1>

            <form wire:submit.prevent="verify" class="space-y-6">
                <!-- Verification Code Input -->
                <div>
                    <label for="verificationCode" class="block text-sm font-medium text-gray-700 mb-2">
                        Verification Code
                    </label>
                    <input 
                        type="text" 
                        id="verificationCode"
                        wire:model="verificationCode"
                        placeholder="Enter verification code"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all text-center text-lg font-mono tracking-wider uppercase"
                        autocomplete="off"
                        autofocus
                    >
                </div>

                <!-- Verify Button -->
                <button 
                    type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                >
                    Verify
                </button>
            </form>

            <!-- Message Display -->
            @if($message)
                <div class="mt-6 p-4 rounded-lg {{ $messageType === 'success' ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200' }}">
                    <p class="text-sm {{ $messageType === 'success' ? 'text-green-800' : 'text-red-800' }} text-center font-medium">
                        {{ $message }}
                    </p>
                </div>
            @endif

            <!-- Verification Details (if successful) -->
            @if($studentApplication && $messageType === 'success')
                <div class="mt-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Document Information</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Name:</span>
                            <span class="font-medium text-gray-800">
                                {{ $studentApplication->first_name }} {{ $studentApplication->last_name }}
                            </span>
                        </div>
                        @if($studentApplication->application)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Application ID:</span>
                                <span class="font-medium text-gray-800">
                                    #{{ $studentApplication->application->id }}
                                </span>
                            </div>
                        @endif
                        <div class="flex justify-between">
                            <span class="text-gray-600">Verification Code:</span>
                            <span class="font-mono font-medium text-gray-800">
                                {{ $studentApplication->documentVerification->verification_code }}
                            </span>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center text-sm text-gray-500">
            <p>European International Peace University</p>
            <p class="mt-1">Document Verification System</p>
        </div>
    </div>
</div>
