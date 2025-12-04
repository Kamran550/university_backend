@php
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Str;

    $application = $agency->application;
    $formatStatus = static fn (?string $status) => $status
        ? str($status)->replace('_', ' ')->title()->value()
        : '—';

    $agencyInfo = [
        'Agentlik adı' => $agency->agency_name ?? '—',
        'Ölkə' => $agency->country ?? '—',
        'Şəhər' => $agency->city ?? '—',
        'Ünvan' => $agency->address ?? '—',
        'Vebsayt' => $agency->website ? Str::of($agency->website)->start('https://') : '—',
    ];

    $contactInfo = [
        'Əlaqəli şəxs' => $agency->contact_name ?? '—',
        'Telefon' => $agency->contact_phone ?? '—',
        'E-poçt' => $agency->contact_email ?? '—',
    ];

    $programInfo = [
        'Müraciət tipi' => $application?->applicant_type ?? '—',
        'Dərəcə' => $application?->degree_name ?? $application?->degree?->name ?? '—',
        'Fakültə' => $application?->faculty_name ?? $application?->faculty?->name ?? '—',
        'Status' => $formatStatus($application?->status?->value ?? $application?->status),
        'Göndərilmə tarixi' => $application?->submitted_at?->format('d.m.Y H:i') ?? '—',
        'Yoxlanma tarixi' => $application?->reviewed_at?->format('d.m.Y H:i') ?? '—',
    ];

    $documents = [
        [
            'label' => 'Biznes lisenziyası',
            'path' => $agency->business_license_path,
        ],
        [
            'label' => 'Şirkət loqosu',
            'path' => $agency->company_logo_path,
        ],
    ];

    $previewType = static function (?string $path): string {
        if (! $path) {
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

<section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">
    <header class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="text-sm text-gray-500">Müraciət ID: {{ $application?->id ?? '—' }}</p>
            <h1 class="text-2xl font-semibold text-gray-900">Agentlik müraciəti</h1>
        </div>
        <a href="{{ route('admin.applications.agency.index') }}"
           class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-indigo-700 bg-indigo-100 hover:bg-indigo-200 rounded-md transition">
            ← Siyahıya qayıt
        </a>
    </header>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <article class="bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="border-b border-gray-100 px-6 py-4">
                <h2 class="text-lg font-semibold text-gray-900">Agentlik məlumatları</h2>
            </div>
            <dl class="divide-y divide-gray-100">
                @foreach($agencyInfo as $label => $value)
                    <div class="px-6 py-4 flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
                        <dt class="text-sm font-medium text-gray-500">{{ $label }}</dt>
                        <dd class="text-sm text-gray-900 font-semibold sm:text-right">
                            @if($label === 'Vebsayt' && $agency->website)
                                <a href="{{ Str::startsWith($agency->website, ['http://', 'https://']) ? $agency->website : 'https://' . $agency->website }}"
                                   target="_blank"
                                   class="text-indigo-600 hover:text-indigo-800 break-all">
                                    {{ $agency->website }}
                                </a>
                            @else
                                {{ $value }}
                            @endif
                        </dd>
                    </div>
                @endforeach
            </dl>
        </article>

        <article class="bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="border-b border-gray-100 px-6 py-4">
                <h2 class="text-lg font-semibold text-gray-900">Əlaqə məlumatları</h2>
            </div>
            <dl class="divide-y divide-gray-100">
                @foreach($contactInfo as $label => $value)
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
            <h2 class="text-lg font-semibold text-gray-900">Proqram / müraciət detalları</h2>
        </div>
        <dl class="grid grid-cols-1 sm:grid-cols-2 divide-y sm:divide-y-0 sm:divide-x divide-gray-100">
            @foreach($programInfo as $label => $value)
                <div class="px-6 py-4 space-y-1">
                    <dt class="text-sm font-medium text-gray-500">{{ $label }}</dt>
                    <dd class="text-sm text-gray-900 font-semibold">{{ $value }}</dd>
                </div>
            @endforeach
        </dl>
    </article>

    <article class="bg-white rounded-2xl shadow-sm border border-gray-100">
        <div class="border-b border-gray-100 px-6 py-4 flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-900">Yüklənmiş fayllar</h2>
            <p class="text-xs text-gray-500">PDF və şəkillər eyni səhifədə önbaxışdadır</p>
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
                        @if($url)
                            <a href="{{ $url }}" target="_blank" class="text-xs font-medium text-indigo-600 hover:text-indigo-800">
                                Yüklə / aç
                            </a>
                        @endif
                    </div>

                    @if(! $url)
                        <p class="text-xs text-gray-500">Fayl əlavə edilməyib.</p>
                    @elseif($type === 'image')
                        <img src="{{ $url }}" alt="{{ $document['label'] }}" class="w-full rounded-lg object-cover border border-gray-200 max-h-64 bg-white">
                    @elseif($type === 'pdf')
                        <iframe src="{{ $url }}" class="w-full h-64 rounded-lg border border-gray-200 bg-white" title="{{ $document['label'] }}"></iframe>
                    @else
                        <div class="text-xs text-gray-500">
                            Bu fayl növü üçün önbaxış mümkün deyil, lakin linkdən açıla bilər.
                        </div>
                    @endif
                </div>
            @empty
                <p class="text-sm text-gray-500">Sənəd tapılmadı.</p>
            @endforelse
        </div>
    </article>
</section>
