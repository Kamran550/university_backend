@php
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Str;
    use App\Enums\ApplicationStatusEnum;

    $application = $student->application;
    $formatStatus = static fn(?string $status) => $status ? str($status)->replace('_', ' ')->title()->value() : '—';

    $getStatusBadgeClass = static function (?string $status): string {
        if (!$status) {
            return 'bg-gray-100 text-gray-800';
        }

        return match ($status) {
            ApplicationStatusEnum::PENDING->value => 'bg-yellow-100 text-yellow-800',
            ApplicationStatusEnum::UNDER_REVIEW->value => 'bg-blue-100 text-blue-800',
            ApplicationStatusEnum::APPROVED->value => 'bg-green-100 text-green-800',
            ApplicationStatusEnum::REJECTED->value => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    };

    $currentStatus = $application?->status?->value ?? $application?->status;
    $allStatuses = ApplicationStatusEnum::cases();

    $generalInfo = [
        'First Name' => $student->first_name,
        'Last Name' => $student->last_name,
        'Father Name' => $student->father_name,
        'Gender' => $student->gender ? Str::ucfirst($student->gender) : '—',
        'Date of Birth' => $student->date_of_birth?->format('d.m.Y') ?? '—',
        'Place of Birth' => $student->place_of_birth ?? '—',
        'Nationality' => $student->nationality ?? '—',
        'Native Language' => $student->native_language ?? '—',
    ];

    $contactInfo = [
        'Phone' => $student->phone ?? '—',
        'Email' => $student->email ?? '—',
        'Country' => $student->country ?? '—',
        'City' => $student->city ?? '—',
        'Address' => $student->address_line ?? '—',
    ];

    $programInfo = [
        'Application Type' => $application?->applicant_type ?? '—',
        'Program' => $application?->program?->name ?? '—',
        'Degree' => $application?->program?->degree?->name ?? '—',
        'Faculty' => $application?->program?->faculty?->name ?? '—',
        'Study Language' => $student->study_language ?? '—',
        'Application Number' => $student->application_number ?? '—',
        'Diploma Number' => $student->diploma_number ?? '—',
        'Status' => $formatStatus($application?->status?->value ?? $application?->status),
        'Submitted At' => $application?->submitted_at?->format('d.m.Y H:i') ?? '—',
        'Reviewed At' => $application?->reviewed_at?->format('d.m.Y H:i') ?? '—',
    ];

    // Determine which diploma and transcript to show based on degree level
    $degreeName = $application?->program?->degree?->name ?? '';
    $diplomaLabel = 'Diploma';
    $transcriptLabel = 'Transcript';
    $diplomaPath = null;
    $transcriptPath = null;

    if ($degreeName === "Bachelor's") {
        // Bachelor applicants provide high school documents
        $diplomaLabel = 'High School Diploma';
        $transcriptLabel = 'High School Transcript';
        $diplomaPath = $student->high_school_diploma_path;
        $transcriptPath = $student->high_school_transcript_path;
    } elseif ($degreeName === "Master's") {
        // Master applicants provide bachelor documents
        $diplomaLabel = "Bachelor's Diploma";
        $transcriptLabel = "Bachelor's Transcript";
        $diplomaPath = $student->bachelor_diploma_path;
        $transcriptPath = $student->bachelor_transcript_path;
    } elseif ($degreeName === 'PhD') {
        // PhD applicants provide master documents
        $diplomaLabel = "Master's Diploma";
        $transcriptLabel = "Master's Transcript";
        $diplomaPath = $student->master_diploma_path;
        $transcriptPath = $student->master_transcript_path;
    }

    $documents = [
        [
            'label' => 'Identity Card / Passport',
            'path' => $student->photo_id_path,
        ],
        [
            'label' => 'Profile Picture',
            'path' => $student->profile_photo_path,
        ],
        [
            'label' => $diplomaLabel,
            'path' => $diplomaPath,
        ],
        [
            'label' => $transcriptLabel,
            'path' => $transcriptPath,
        ],
    ];

    $previewType = static function (?string $path): string {
        if (!$path) {
            return 'none';
        }

        $extension = Str::of($path)->afterLast('.')->lower();

        return match (true) {
            $extension->is(['jpg', 'jpeg', 'png', 'gif', 'webp']) => 'image',
            $extension->value() === 'pdf' => 'pdf',
            default => 'file',
        };
    };
@endphp

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">
    <!-- Flash Messages -->
    {{-- @if (session()->has('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif --}}

    @if (session()->has('error'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <header class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex-1">
            <p class="text-sm text-gray-500">Application ID: {{ $application?->id ?? '—' }}</p>
            <div class="flex items-center gap-3 mt-1">
                <h1 class="text-2xl font-semibold text-gray-900">Student Application</h1>
                @if ($application)
                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                        <div class="flex items-center gap-2">
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $getStatusBadgeClass($currentStatus) }}">
                                {{ $formatStatus($currentStatus) }}
                            </span>
                            <button type="button" @click="open = !open"
                                class="inline-flex items-center justify-center p-1.5 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-md transition"
                                title="Change Status">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                </svg>
                            </button>
                        </div>

                        <div x-show="open" x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95" style="display: none;"
                            class="absolute left-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                            <div class="py-1" role="menu">
                                <div
                                    class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase border-b border-gray-100">
                                    Change Status
                                </div>
                                @foreach ($allStatuses as $status)
                                    @php
                                        $statusValue = $status->value;
                                        $statusLabel = $formatStatus($statusValue);
                                        $isCurrent = $currentStatus === $statusValue;
                                    @endphp
                                    <button type="button" wire:click="updateStatus('{{ $statusValue }}')"
                                        wire:loading.attr="disabled" @click="open = false"
                                        class="w-full text-left px-4 py-2 text-sm {{ $isCurrent ? 'bg-gray-50 font-semibold' : 'hover:bg-gray-50' }} transition flex items-center justify-between {{ $isCurrent ? 'text-gray-900' : 'text-gray-700' }}"
                                        role="menuitem" @if ($isCurrent) disabled @endif>
                                        <span class="flex items-center gap-2">
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $getStatusBadgeClass($statusValue) }}">
                                                {{ $statusLabel }}
                                            </span>
                                        </span>
                                        @if ($isCurrent)
                                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                        @endif
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="flex items-center gap-3">
            <button type="button" wire:click="sendAcceptanceLetter" wire:loading.attr="disabled"
                wire:target="sendAcceptanceLetter"
                class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-md transition duration-150 ease-in-out disabled:opacity-50 disabled:cursor-not-allowed"
                title="Send Acceptance Letter">
                <svg wire:loading.remove wire:target="sendAcceptanceLetter" class="w-4 h-4 mr-2" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <svg wire:loading wire:target="sendAcceptanceLetter" class="animate-spin w-4 h-4 mr-2" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                <span wire:loading.remove wire:target="sendAcceptanceLetter">Send Cont Acceptance Letter</span>
                <span wire:loading wire:target="sendAcceptanceLetter">Sending...</span>
            </button>
            @if ($application && $currentStatus === ApplicationStatusEnum::APPROVED->value)
                <button type="button" wire:click="sendFinalAcceptanceLetter" wire:loading.attr="disabled"
                    wire:target="sendFinalAcceptanceLetter"
                    class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-md transition duration-150 ease-in-out disabled:opacity-50 disabled:cursor-not-allowed"
                    title="Send Final Acceptance Letter">
                    <svg wire:loading.remove wire:target="sendFinalAcceptanceLetter" class="w-4 h-4 mr-2" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <svg wire:loading wire:target="sendFinalAcceptanceLetter" class="animate-spin w-4 h-4 mr-2"
                        fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    <span wire:loading.remove wire:target="sendFinalAcceptanceLetter">Send Certificate</span>
                    <span wire:loading wire:target="sendFinalAcceptanceLetter">Sending...</span>
                </button>
            @endif
            <a href="{{ route('admin.applications.student.index') }}"
                class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-indigo-700 bg-indigo-100 hover:bg-indigo-200 rounded-md transition">
                ← Back to List
            </a>
        </div>
    </header>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <article class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="border-b border-gray-100 px-6 py-4 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900">Personal Information</h2>
            </div>
            <dl class="divide-y divide-gray-100">
                @foreach ($generalInfo as $label => $value)
                    <div class="px-6 py-4 flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
                        <dt class="text-sm font-medium text-gray-500">{{ $label }}</dt>
                        <dd class="text-sm text-gray-900 font-semibold sm:text-right">{{ $value }}</dd>
                    </div>
                @endforeach
            </dl>
        </article>

        <article class="bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="border-b border-gray-100 px-6 py-4 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900">Contact Information</h2>
            </div>
            <dl class="divide-y divide-gray-100">
                @foreach ($contactInfo as $label => $value)
                    <div class="px-6 py-4 flex flex-col gap-1">
                        <dt class="text-sm font-medium text-gray-500">{{ $label }}</dt>
                        <dd class="text-sm text-gray-900 font-semibold">{{ $value }}</dd>
                    </div>
                @endforeach
            </dl>
        </article>
    </div>

    <article class="bg-white rounded-2xl shadow-sm border border-gray-100">
        <div class="border-b border-gray-100 px-6 py-4 flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-900">Program Information</h2>
        </div>
        <dl class="grid grid-cols-1 sm:grid-cols-2 divide-y sm:divide-y-0 sm:divide-x divide-gray-100">
            @foreach ($programInfo as $label => $value)
                <div class="px-6 py-4 space-y-1">
                    <dt class="text-sm font-medium text-gray-500">{{ $label }}</dt>
                    <dd class="text-sm text-gray-900 font-semibold">{{ $value }}</dd>
                </div>
            @endforeach
        </dl>
    </article>

    <article class="bg-white rounded-2xl shadow-sm border border-gray-100">
        <div class="border-b border-gray-100 px-6 py-4 flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-900">Uploaded Documents</h2>
            <p class="text-xs text-gray-500">Images and PDFs will be previewed on the same page</p>
        </div>
        <div class="grid grid-cols-1 gap-6 p-6 sm:grid-cols-2">
            @forelse($documents as $document)
                @php
                    $url = $document['path'] ? Storage::url($document['path']) : null;
                    $type = $previewType($document['path']);
                @endphp

                <div class="flex flex-col gap-3 rounded-xl border border-gray-100 shadow-sm bg-gray-50 p-4">
                    <div class="flex items-center justify-between gap-2">
                        <h3 class="text-sm font-semibold text-gray-900">{{ $document['label'] }}</h3>
                        @if ($url)
                            <a href="{{ $url }}" target="_blank"
                                class="text-xs font-medium text-indigo-600 hover:text-indigo-800">
                                Upload / Open
                            </a>
                        @endif
                    </div>

                    @if (!$url)
                        <p class="text-xs text-gray-500">File not added.</p>
                    @elseif($type === 'image')
                        <img src="{{ $url }}" alt="{{ $document['label'] }}"
                            class="w-full rounded-lg object-cover border border-gray-200 max-h-64">
                    @elseif($type === 'pdf')
                        <iframe src="{{ $url }}" class="w-full h-64 rounded-lg border border-gray-200"
                            title="{{ $document['label'] }}"></iframe>
                    @else
                        <div class="text-xs text-gray-500">
                            No preview available for this file type, but can be opened via link.
                        </div>
                    @endif
                </div>
            @empty
                <p class="text-sm text-gray-500">Document not found.</p>
            @endforelse
        </div>
    </article>
</section>
