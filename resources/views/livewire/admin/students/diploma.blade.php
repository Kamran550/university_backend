<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diploma - {{ $student->name }} {{ $student->surname }}</title>
    <style>
        @page {
            margin: 0;
            size: A4 landscape;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Serif', 'Times New Roman', serif;
            color: #1a1a2e;
            margin: 0;
            padding: 0;
            background: #fff;
            width: 297mm;
            height: 210mm;
            position: relative;
            overflow: hidden;
        }

        .diploma-container {
            width: 100%;
            height: 100%;
            position: relative;
            background: linear-gradient(135deg, #fefefe 0%, #f8f6f0 50%, #fefefe 100%);
        }

        /* Decorative Border */
        .outer-border {
            position: absolute;
            top: 8mm;
            left: 8mm;
            right: 8mm;
            bottom: 8mm;
            border: 3px solid #8B0000;
        }

        .inner-border {
            position: absolute;
            top: 12mm;
            left: 12mm;
            right: 12mm;
            bottom: 12mm;
            border: 1px solid #8B0000;
        }

        /* Corner Decorations */
        .corner {
            position: absolute;
            width: 25mm;
            height: 25mm;
            border: 2px solid #C4A35A;
        }

        .corner-tl {
            top: 15mm;
            left: 15mm;
            border-right: none;
            border-bottom: none;
        }

        .corner-tr {
            top: 15mm;
            right: 15mm;
            border-left: none;
            border-bottom: none;
        }

        .corner-bl {
            bottom: 15mm;
            left: 15mm;
            border-right: none;
            border-top: none;
        }

        .corner-br {
            bottom: 15mm;
            right: 15mm;
            border-left: none;
            border-top: none;
        }

        /* Content Area */
        .content {
            position: absolute;
            top: 20mm;
            left: 25mm;
            right: 25mm;
            bottom: 20mm;
            text-align: center;
        }

        /* Header Section */
        .header {
            text-align: center;
            margin-bottom: 5mm;
        }

        .header-content {
            width: 100%;
        }

        .logo {
            width: 20mm;
            height: auto;
            vertical-align: middle;
            margin-right: 3mm;
        }

        .university-info {
            display: inline-block;
            vertical-align: middle;
            text-align: left;
        }

        .university-name {
            font-size: 18pt;
            font-weight: bold;
            color: #8B0000;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 1mm;
        }

        .university-subtitle {
            text-align: center;
            font-size: 9pt;
            color: #1a365d;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .countries-text {
            text-align: center;
            font-size: 8pt;
            color: #1a365d;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-top: 1mm;
        }

        /* Main Content */
        .main-content {
            position: relative;
            width: 100%;
            padding: 2mm 0;
            text-align: center;
        }

        .certify-text {
            font-size: 11pt;
            color: #333;
            margin-bottom: 4mm;
            font-style: italic;
        }

        .student-name {
            font-size: 24pt;
            font-weight: bold;
            color: #1a1a2e;
            font-family: 'Brush Script MT', 'Edwardian Script ITC', cursive;
            margin: 3mm 0;
            letter-spacing: 2px;
        }

        .completion-text {
            font-size: 11pt;
            color: #333;
            margin-bottom: 3mm;
            line-height: 1.6;
        }

        .degree-name {
            font-size: 18pt;
            font-weight: bold;
            color: #8B0000;
            margin: 3mm 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .program-name {
            font-size: 14pt;
            font-weight: bold;
            color: #1a365d;
            margin: 2mm 0;
        }

        .faculty-name {
            font-size: 11pt;
            color: #444;
            font-style: italic;
            margin-bottom: 4mm;
        }

        .rights-text {
            font-size: 9pt;
            color: #555;
            font-style: italic;
            line-height: 1.4;
            margin: 3mm 0;
        }

        /* Student Info Section */
        .student-info {
            width: 90%;
            margin: 5mm auto;
            text-align: center;
            border-top: 1px solid #ddd;
            border-bottom: 1px solid #ddd;
            padding: 3mm 0;
        }

        .info-item {
            display: inline-block;
            margin: 0 4mm;
            font-size: 9pt;
            color: #333;
        }

        .info-item strong {
            font-weight: bold;
            color: #8B0000;
        }

        /* Diploma Text Section */
        .diploma-text-section {
            width: 90%;
            margin: 3mm auto;
            border: 2px solid #8B0000;
            background: linear-gradient(to bottom, #fafafa 0%, #ffffff 100%);
            box-shadow: 0 1mm 3mm rgba(0, 0, 0, 0.1);
        }

        .diploma-text-table {
            width: 100%;
            border-collapse: collapse;
        }

        .diploma-text-table td {
            width: 50%;
            padding: 4mm;
            font-size: 9.5pt;
            color: #1a1a2e;
            text-align: justify;
            line-height: 1.6;
            border-right: 1px solid #C4A35A;
            vertical-align: top;
        }

        .diploma-text-table td:last-child {
            border-right: none;
        }

        .diploma-text-content {
            min-height: 25mm;
        }

        .e-signature {
            margin-top: 3mm;
            padding-top: 2mm;
            border-top: 1px solid #ddd;
            font-size: 7.5pt;
            color: #8B0000;
            font-style: italic;
            text-align: center;
            font-weight: bold;
        }

        /* Location & Date */
        .location-date {
            margin: 2mm 0;
            text-align: center;
        }

        .location {
            font-size: 9pt;
            color: #333;
            font-style: italic;
        }

        .location-row {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8mm;
            flex-wrap: wrap;
        }

        .location-item {
            font-size: 9pt;
            color: #333;
            font-style: italic;
            text-align: center;
        }


        .date {
            font-size: 9pt;
            color: #333;
            text-decoration: underline;
            margin-top: 1mm;
        }

        /* Partner Logos Section */
        .partner-logos {
            width: 100%;
            margin-top: 2mm;
            padding: 2mm 0;
        }

        .partner-logos-title {
            font-size: 8pt;
            color: #555;
            text-align: center;
            margin-bottom: 2mm;
            font-style: italic;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .partner-logos-grid {
            display: table;
            width: 100%;
            table-layout: auto;
            border-collapse: separate;
            border-spacing: 2mm 0;
            padding: 0;
            margin: 0 auto;
        }

        .partner-logos-row {
            display: table-row;
        }

        .partner-logo-item {
            display: table-cell;
            text-align: center;
            vertical-align: middle;
            width: auto;
            height: 10mm;
            padding: 0 1mm;
        }

        .partner-logo-image {
            max-width: 20mm;
            max-height: 14mm;
            width: auto;
            height: auto;
            vertical-align: middle;
        }

        /* Verification Footer */
        .verification-footer {
            position: absolute;
            bottom: 18mm;
            right: 20mm;
            font-size: 7pt;
            color: #666;
        }

        .qr-section {
            text-align: right;
        }

        .qr-code {
            width: 14mm;
            height: 14mm;
        }

        .verification-text {
            font-size: 6.5pt;
            color: #666;
            max-width: 60mm;
            line-height: 1.3;
        }

        .diploma-number {
            font-size: 7pt;
            color: #666;
        }

        @media print {
            body {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }
    </style>
</head>

<body>
    <div class="diploma-container">
        <!-- Decorative Borders -->
        <div class="outer-border"></div>
        <div class="inner-border"></div>

        <!-- Corner Decorations -->
        <div class="corner corner-tl"></div>
        <div class="corner corner-tr"></div>
        <div class="corner corner-bl"></div>
        <div class="corner corner-br"></div>

        <!-- Main Content -->
        <div class="content">
            <!-- Header -->
            <div class="header">
                @php
                    $logoPath = public_path('images/EIPU-simvol.png');
                    $logoData = file_exists($logoPath) ? base64_encode(file_get_contents($logoPath)) : '';
                    $logoMime = 'image/png';
                @endphp
                <div class="header-content">
                    @if ($logoData)
                        <img src="data:{{ $logoMime }};base64,{{ $logoData }}" alt="EIPU Logo" class="logo">
                    @endif
                    <div class="university-info">
                        <div class="university-name">European International Peace University</div>
                        <div class="university-subtitle">Business Eurasia Education Alliance</div>
                        <div class="countries-text">POLAND | LUXEMBOURG | TÜRKİYE</div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="main-content">
                <div class="student-name">
                    {{ $studentApplication->first_name ?? $student->name }}
                    {{ $studentApplication->last_name ?? $student->surname }}
                </div>

                <!-- Student Information -->
                <div class="student-info">
                    <div class="info-item">
                        <strong>Passport Number:</strong> {{ $studentApplication->passport_number ?? 'N/A' }}
                    </div>
                    <div class="info-item">
                        <strong>Diploma Number:</strong> {{ $studentApplication->diploma_number ?? 'N/A' }}
                    </div>
                    <div class="info-item">
                        <strong>Date of Birth:</strong>
                        {{ $studentApplication->date_of_birth ? $studentApplication->date_of_birth->format('F d, Y') : 'N/A' }}
                    </div>
                    <div class="info-item">
                        <strong>Place of Birth:</strong> {{ $studentApplication->place_of_birth ?? 'N/A' }}
                    </div>
                </div>

                <!-- Diploma Text (English and Turkish) -->
                @if ($studentApplication && $studentApplication->diploma_text)
                    <div class="diploma-text-section">
                        <table class="diploma-text-table">
                            <tr>
                                <td>
                                    <div class="diploma-text-content">
                                        {{ $studentApplication->diploma_text['en'] ?? '' }}
                                    </div>
                                    <div class="e-signature">✓ e-signed / e-imzalıdır</div>
                                    <div class="location-item">Secretary General / Genel Sekreter: Martin Dravoski</div>
                                </td>
                                <td>
                                    <div class="diploma-text-content">
                                        {{ $studentApplication->diploma_text['tr'] ?? '' }}
                                    </div>
                                    <div class="e-signature">✓ e-signed / e-imzalıdır</div>
                                    <div class="location-item">Rektor / Rectör: Prof. Dr. Serdar Koral</div>
                                </td>
                            </tr>
                        </table>
                    </div>
                @endif

                <!-- Location & Date -->
                <div class="location-date">
                    {{-- <div class="location-row">
                        <div class="location-item">Rector: Prof. Dr. Serdar Koral</div>
                        <div class="location-item">Secretary General: Martin Dravoski</div>
                    </div> --}}
                    <div class="date">{{ $graduationDate ?? now()->format('F d, Y') }}</div>
                </div>
            </div>

            <!-- Partner Logos -->
            <div class="partner-logos">
                <div class="partner-logos-grid">
                    <div class="partner-logos-row">
                        @php
                            $partnerLogos = [
                                ['path' => 'images/aacsb.png', 'alt' => 'AACSB', 'mime' => 'image/png'],
                                ['path' => 'images/amba.png', 'alt' => 'AMBA', 'mime' => 'image/png'],
                                ['path' => 'images/asic-logo-white.png', 'alt' => 'ASIC', 'mime' => 'image/png'],
                                ['path' => 'images/ECBE.jpg', 'alt' => 'ECBE', 'mime' => 'image/jpeg'],
                                ['path' => 'images/enqa.png', 'alt' => 'ENQA', 'mime' => 'image/png'],
                                [
                                    'path' => 'images/IACBE_logo_notag_2color.png',
                                    'alt' => 'IACBE',
                                    'mime' => 'image/png',
                                ],
                                ['path' => 'images/qahe.png', 'alt' => 'QAHE', 'mime' => 'image/png'],
                                [
                                    'path' => 'images/QS_World_University_Rankings_Logo.jpg',
                                    'alt' => 'QS World University Rankings',
                                    'mime' => 'image/jpeg',
                                ],
                                [
                                    'path' => 'images/THEWUR.png',
                                    'alt' => 'THE World University Rankings',
                                    'mime' => 'image/png',
                                ],
                                ['path' => 'images/unesco.png', 'alt' => 'UNESCO', 'mime' => 'image/png'],
                                [
                                    'path' => 'images/WCI.png',
                                    'alt' => 'World Certification Institute',
                                    'mime' => 'image/png',
                                ],
                            ];
                        @endphp
                        @foreach ($partnerLogos as $logo)
                            @php
                                $logoPath = public_path($logo['path']);
                                $logoData = file_exists($logoPath) ? base64_encode(file_get_contents($logoPath)) : '';
                            @endphp
                            @if ($logoData)
                                <div class="partner-logo-item">
                                    <img src="data:{{ $logo['mime'] }};base64,{{ $logoData }}"
                                        alt="{{ $logo['alt'] }}" class="partner-logo-image">
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Verification Footer -->
        <div class="verification-footer">
            <div class="qr-section">
                @php
                    $verificationCodeForUrl = $verificationCode ?? null;
                    $qrCodeBase64 = null;
                    try {
                        $qrCode = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')
                            ->size(50)
                            ->generate($studentApplication->getVerificationUrl($verificationCodeForUrl));
                        $qrCodeBase64 = base64_encode($qrCode);
                    } catch (\Exception $e) {
                        // QR code generation failed, skip it
                    }
                @endphp
                @if ($qrCodeBase64)
                    <img src="data:image/svg+xml;base64,{{ $qrCodeBase64 }}" class="qr-code" alt="QR Code">
                @endif
            </div>
        </div>
    </div>
</body>

</html>
