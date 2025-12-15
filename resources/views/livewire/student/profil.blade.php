<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
        <!-- Header -->
        <div class="border-b border-gray-100 px-6 py-4">
            <h1 class="text-2xl font-semibold text-gray-900">Profile Settings</h1>
            <p class="mt-1 text-sm text-gray-500">Update your personal information and password.</p>
        </div>

        <!-- Form -->
        <div class="p-6">
            @if ($error)
                <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded">
                    <div class="flex">
                        <div class="shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700">{{ $error }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if ($success)
                <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded">
                    <div class="flex">
                        <div class="shrink-0">
                            <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700">{{ $success }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <form wire:submit="updateProfile" class="space-y-6">
                <!-- Profile Photo Section -->
                <div class="border-b border-gray-200 pb-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Profile Photo</h2>
                    <div class="flex items-center gap-6">
                        <!-- Current Photo -->
                        <div class="shrink-0">
                            @if ($profile_photo_preview)
                                <img src="{{ $profile_photo_preview }}" alt="Profile Photo" id="photo-preview"
                                    class="h-24 w-24 rounded-full object-cover border-4 border-gray-200">
                            @else
                                <div class="h-24 w-24 rounded-full bg-indigo-100 flex items-center justify-center border-4 border-gray-200"
                                    id="photo-placeholder">
                                    <span class="text-indigo-600 font-semibold text-2xl">
                                        {{ strtoupper(substr($name, 0, 1)) }}{{ strtoupper(substr($surname ?? '', 0, 1)) }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        <!-- Upload Button -->
                        <div class="flex-1">
                            <label for="profile_photo" class="cursor-pointer">
                                <input id="profile_photo" type="file" wire:model="profile_photo"
                                    accept="image/jpeg,image/jpg,image/png" class="hidden"
                                    onchange="previewPhoto(this)">
                                <div
                                    class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Select Photo
                                </div>
                            </label>
                            @if ($profile_photo)
                                <p class="mt-2 text-sm text-gray-500">
                                    <span wire:loading.remove
                                        wire:target="profile_photo">{{ $profile_photo->getClientOriginalName() }}</span>
                                    <span wire:loading wire:target="profile_photo">Sending...</span>
                                </p>
                            @endif
                            @error('profile_photo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">JPG, PNG and GIF. Maximum 2MB.</p>
                        </div>
                    </div>
                </div>

                <script>
                    function previewPhoto(input) {
                        if (input.files && input.files[0]) {
                            const reader = new FileReader();

                            reader.onload = function(e) {
                                const preview = document.getElementById('photo-preview');
                                const placeholder = document.getElementById('photo-placeholder');

                                if (preview) {
                                    preview.src = e.target.result;
                                } else if (placeholder) {
                                    placeholder.innerHTML =
                                        `<img src="${e.target.result}" alt="Preview" class="h-24 w-24 rounded-full object-cover border-4 border-gray-200" id="photo-preview">`;
                                }
                            };

                            reader.readAsDataURL(input.files[0]);
                        }
                    }
                </script>

                <!-- Personal Information Section -->
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Personal Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                First Name <span class="text-red-500">*</span>
                            </label>
                            <input id="name" name="name" type="text" wire:model="name" required
                                class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-150 @error('name') border-red-300 @enderror"
                                placeholder="Enter your first name">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Surname -->
                        <div>
                            <label for="surname" class="block text-sm font-medium text-gray-700 mb-2">
                                Last Name <span class="text-red-500">*</span>
                            </label>
                            <input id="surname" name="surname" type="text" wire:model="surname" required
                                class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-150 @error('surname') border-red-300 @enderror"
                                placeholder="Enter your last name">
                            @error('surname')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input id="email" name="email" type="email" wire:model="email" required
                                class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-150 @error('email') border-red-300 @enderror"
                                placeholder="Enter your email">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Username -->
                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                                Username <span class="text-red-500">*</span>
                            </label>
                            <input id="username" name="username" type="text" wire:model="username" required
                                class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-150 @error('username') border-red-300 @enderror"
                                placeholder="Enter your username">
                            @error('username')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                Phone
                            </label>
                            <input id="phone" name="phone" type="text" wire:model="phone"
                                class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-150 @error('phone') border-red-300 @enderror"
                                placeholder="Enter your phone number">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Password Section -->
                <div class="border-t border-gray-200 pt-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Password Change</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Current Password -->
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                                Current Password
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <input id="current_password" name="current_password" type="password"
                                    wire:model="current_password"
                                    class="appearance-none block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-150 @error('current_password') border-red-300 @enderror"
                                    placeholder="Enter your current password">
                            </div>
                            @error('current_password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- New Password -->
                        <div>
                            <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">
                                New Password
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                    </svg>
                                </div>
                                <input id="new_password" name="new_password" type="password"
                                    wire:model="new_password"
                                    class="appearance-none block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-150 @error('new_password') border-red-300 @enderror"
                                    placeholder="Enter your new password">
                            </div>
                            @error('new_password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Password must be at least 6 characters long.</p>
                        </div>

                        <!-- Confirm New Password -->
                        <div class="md:col-span-2">
                            <label for="new_password_confirmation"
                                class="block text-sm font-medium text-gray-700 mb-2">
                                Confirm New Password
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <input id="new_password_confirmation" name="new_password_confirmation"
                                    type="password" wire:model="new_password_confirmation"
                                    class="appearance-none block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-150 @error('new_password_confirmation') border-red-300 @enderror"
                                    placeholder="Confirm your new password">
                            </div>
                            @error('new_password_confirmation')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('student.dashboard') }}"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                        Cancel
                    </a>
                    <button type="submit" wire:loading.attr="disabled" wire:target="updateProfile"
                        class="inline-flex items-center justify-center px-6 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition duration-150 disabled:opacity-50 disabled:cursor-not-allowed">
                        <span wire:loading.remove wire:target="updateProfile">
                            Save
                        </span>
                        <span wire:loading wire:target="updateProfile" class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none"
                                viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
