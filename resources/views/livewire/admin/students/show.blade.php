<div class="p-4 sm:p-6 lg:p-8">
    <div class="max-w-7xl mx-auto">

        <!-- Flash Messages -->
        @if (session()->has('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <!-- Back Button & Header -->
        <div class="mb-6 sm:mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <a href="{{ route('admin.students.index') }}"
                        class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-800 transition duration-150 ease-in-out mb-4">
                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Back
                    </a>
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Student Information</h1>
                    <p class="text-base sm:text-lg text-gray-600">{{ $student->name }} {{ $student->surname }} about
                        more information</p>
                </div>

                <!-- Action Buttons -->
                @if ($application)
                    <div class="flex items-center gap-3">
                        <button type="button" wire:click="sendDiploma" wire:loading.attr="disabled"
                            wire:target="sendDiploma"
                            class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-medium text-white bg-linear-to-r from-amber-600 to-amber-700 hover:from-amber-700 hover:to-amber-800 rounded-lg shadow-md hover:shadow-lg transition duration-150 ease-in-out disabled:opacity-50 disabled:cursor-not-allowed"
                            title="Send Diploma">
                            <svg wire:loading.remove wire:target="sendDiploma" class="w-5 h-5 mr-2" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                            </svg>
                            <svg wire:loading wire:target="sendDiploma" class="animate-spin w-5 h-5 mr-2" fill="none"
                                viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            <span wire:loading.remove wire:target="sendDiploma">🎓 Send Diploma</span>
                            <span wire:loading wire:target="sendDiploma">Sending...</span>
                        </button>
                    </div>
                @endif
            </div>
        </div>

        <!-- Student Basic Info Card -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 sm:p-8 mb-6">
            <div class="flex items-start gap-6">
                <!-- Profile Photo -->
                <div class="shrink-0">
                    @if ($student->profile_photo)
                        <img src="{{ Storage::url($student->profile_photo) }}" alt="{{ $student->name }}"
                            class="h-24 w-24 rounded-full object-cover border-4 border-indigo-100">
                    @else
                        <div
                            class="h-24 w-24 bg-indigo-100 rounded-full flex items-center justify-center border-4 border-indigo-50">
                            <span class="text-indigo-600 font-bold text-2xl">
                                {{ strtoupper(substr($student->name, 0, 1)) }}{{ strtoupper(substr($student->surname ?? '', 0, 1)) }}
                            </span>
                        </div>
                    @endif
                </div>

                <!-- Basic Info -->
                <div class="flex-1">
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-4">Basic Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Name Surname</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $student->name }} {{ $student->surname }}
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Email</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $student->email }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Username</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $student->username ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Passport/ID Number</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $application->studentApplication->passport_number ?? 'N/A' }}</p>
                        </div>


                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Phone Number</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $student->phone ?? 'N/A' }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Registration Date</label>
                            <p class="text-lg font-semibold text-gray-900">
                                {{ $student->created_at->format('d.m.Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if ($application)
            <!-- Application Information Card -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 sm:p-8 mb-6">
                <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-6">Application Information</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Program Information -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Program</label>
                            <p class="text-lg font-semibold text-gray-900">
                                {{ $application->program->name ?? 'N/A' }}
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Degree</label>
                            <p class="text-lg font-semibold text-gray-900">
                                {{ $application->program->degree->name ?? 'N/A' }}
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Faculty</label>
                            <p class="text-lg font-semibold text-gray-900">
                                {{ $application->program->faculty->name ?? ($application->faculty_name ?? 'N/A') }}
                            </p>
                        </div>

                        @if ($application->studentApplication && $application->studentApplication->study_language)
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Study Language</label>
                                <div class="mt-1">
                                    @php
                                        $studyLang = strtoupper($application->studentApplication->study_language);
                                        $langColor =
                                            strtolower($application->studentApplication->study_language) === 'en'
                                                ? 'bg-blue-100 text-blue-800'
                                                : 'bg-green-100 text-green-800';
                                    @endphp
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $langColor }}">
                                        {{ $studyLang }}
                                    </span>
                                </div>
                            </div>
                        @endif

                    </div>

                    <!-- Application Status -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Application Status</label>
                            <div class="mt-1">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'under_review' => 'bg-blue-100 text-blue-800',
                                        'approved' => 'bg-green-100 text-green-800',
                                        'rejected' => 'bg-red-100 text-red-800',
                                    ];
                                    $statusLabels = [
                                        'pending' => 'Pending',
                                        'under_review' => 'Under Review',
                                        'approved' => 'Approved',
                                        'rejected' => 'Rejected',
                                    ];
                                    $status = $application->status->value ?? 'pending';
                                    $color = $statusColors[$status] ?? 'bg-gray-100 text-gray-800';
                                    $label = $statusLabels[$status] ?? ucfirst($status);
                                @endphp
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $color }}">
                                    {{ $label }}
                                </span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Application Date</label>
                            <p class="text-lg font-semibold text-gray-900">
                                {{ $application->submitted_at ? $application->submitted_at->format('d.m.Y H:i') : 'N/A' }}
                            </p>
                        </div>

                        @if ($application->reviewed_at)
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Review Date</label>
                                <p class="text-lg font-semibold text-gray-900">
                                    {{ $application->reviewed_at->format('d.m.Y H:i') }}
                                </p>
                            </div>
                        @endif

                        @if ($application->program->price_per_year)
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Yearly Payment</label>
                                <p class="text-lg font-semibold text-gray-900">
                                    {{ number_format($application->program->price_per_year, 2) }} EUR
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Student Personal Information from Application -->
            @if ($application->studentApplication)
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 sm:p-8">
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-6">Personal Information in Application
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Name</label>
                            <p class="text-lg font-semibold text-gray-900">
                                {{ $application->studentApplication->first_name ?? 'N/A' }}
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Surname</label>
                            <p class="text-lg font-semibold text-gray-900">
                                {{ $application->studentApplication->last_name ?? 'N/A' }}
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Father Name</label>
                            <p class="text-lg font-semibold text-gray-900">
                                {{ $application->studentApplication->father_name ?? 'N/A' }}
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Gender</label>
                            <p class="text-lg font-semibold text-gray-900">
                                {{ $application->studentApplication->gender ?? 'N/A' }}
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Date of Birth</label>
                            <p class="text-lg font-semibold text-gray-900">
                                {{ $application->studentApplication->date_of_birth ? $application->studentApplication->date_of_birth->format('d.m.Y') : 'N/A' }}
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Phone Number</label>
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
                            <label class="block text-sm font-medium text-gray-500 mb-1">Nationality</label>
                            <p class="text-lg font-semibold text-gray-900">
                                {{ $application->studentApplication->nationality ?? 'N/A' }}
                            </p>
                        </div>

                        @if ($application->studentApplication->student_number)
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Student Number</label>
                                <p class="text-lg font-semibold text-gray-900">
                                    {{ $application->studentApplication->student_number }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        @else
            <!-- No Application -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">Application not found</h3>
                <p class="mt-2 text-sm text-gray-500">
                    This student has no application.
                </p>
            </div>
        @endif

    </div>
</div>
