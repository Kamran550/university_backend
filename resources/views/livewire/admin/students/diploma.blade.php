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
            font-family: 'Times New Roman', 'Georgia', serif;
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
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            text-align: center;
        }
        
        /* Header Section */
        .header {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 5mm;
        }

        .logo {
            width: 25mm;
            height: auto;
            margin-bottom: 3mm;
        }
        
        .university-name {
            font-size: 22pt;
            font-weight: bold;
            color: #8B0000;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-bottom: 2mm;
        }
        
        .university-subtitle {
            font-size: 10pt;
            color: #1a365d;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        
        /* Main Content */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 5mm 0;
        }
        
        .certify-text {
            font-size: 11pt;
            color: #333;
            margin-bottom: 4mm;
            font-style: italic;
        }
        
        .student-name {
            font-size: 28pt;
            font-weight: bold;
            color: #1a1a2e;
            font-family: 'Brush Script MT', 'Edwardian Script ITC', cursive;
            margin-bottom: 4mm;
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
            margin-bottom: 3mm;
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
            max-width: 180mm;
            line-height: 1.4;
        }
        
        /* Location & Date */
        .location-date {
            margin: 4mm 0;
            text-align: center;
        }
        
        .location {
            font-size: 10pt;
            color: #333;
            font-style: italic;
        }
        
        .date {
            font-size: 10pt;
            color: #333;
            text-decoration: underline;
            margin-top: 1mm;
        }
        
        /* Signatures Section */
        .signatures {
            width: 100%;
            display: table;
            margin-top: 5mm;
        }
        
        .signatures-row {
            display: table-row;
        }
        
        .signature-box {
            display: table-cell;
            text-align: center;
            vertical-align: bottom;
            padding: 0 10mm;
            width: 33.33%;
        }
        
        .signature-image {
            height: 18mm;
            width: auto;
            max-width: 50mm;
            margin-bottom: 2mm;
        }
        
        .signature-line {
            width: 50mm;
            height: 0;
            border-bottom: 1px solid #333;
            margin: 0 auto 2mm auto;
        }
        
        .signature-name {
            font-size: 9pt;
            font-weight: bold;
            color: #1a1a2e;
        }
        
        .signature-title {
            font-size: 8pt;
            color: #555;
            margin-top: 1mm;
        }
        
        /* Seal */
        .seal-container {
            position: absolute;
            bottom: 30mm;
            left: 50%;
            transform: translateX(-50%);
            opacity: 0.15;
        }
        
        .seal {
            width: 40mm;
            height: 40mm;
        }
        
        /* Verification Footer */
        .verification-footer {
            position: absolute;
            bottom: 18mm;
            left: 25mm;
            right: 25mm;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            font-size: 7pt;
            color: #666;
        }
        
        .qr-section {
            display: flex;
            align-items: center;
            gap: 3mm;
        }
        
        .qr-code {
            width: 15mm;
            height: 15mm;
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
                    $logoPath = public_path('images/EIPU-logo.png');
                    $logoData = file_exists($logoPath) ? base64_encode(file_get_contents($logoPath)) : '';
                    $logoMime = 'image/png';
                @endphp
                @if($logoData)
                    <img src="data:{{ $logoMime }};base64,{{ $logoData }}" alt="EIPU Logo" class="logo">
                @endif
            </div>
            
            <!-- Main Content -->
            <div class="main-content">
                <div class="certify-text">
                    By the authority of the Board of Trustees, European International Peace University confers upon
                </div>
                
                <div class="student-name">
                    {{ $studentApplication->first_name ?? $student->name }} {{ $studentApplication->last_name ?? $student->surname }}
                </div>
                
                <div class="completion-text">
                    who has satisfactorily completed the studies prescribed,<br>
                    the degree of
                </div>
                
                <div class="degree-name">
                    {{ $application->program->degree->name ?? 'Bachelor of Science' }}
                </div>
                
                <div class="program-name">
                    {{ $application->program->name ?? 'Program Name' }}
                </div>
                
                <div class="faculty-name">
                    {{ $application->program->faculty->name ?? 'Faculty' }}
                </div>
                
                <div class="rights-text">
                    with all the rights, privileges and responsibilities pertaining thereto.
                </div>
                
                <!-- Location & Date -->
                <div class="location-date">
                    <div class="location">Warsaw, Poland</div>
                    <div class="date">{{ $graduationDate ?? now()->format('F d, Y') }}</div>
                </div>
            </div>
            
            <!-- Signatures -->
            <div class="signatures">
                <div class="signatures-row">
                    <!-- Signature 1 - Chairperson -->
                    <div class="signature-box">
                        @php
                            $signature1Path = public_path('images/İmza1.png');
                            $signature1Data = file_exists($signature1Path) ? base64_encode(file_get_contents($signature1Path)) : '';
                        @endphp
                        @if($signature1Data)
                            <img src="data:image/png;base64,{{ $signature1Data }}" alt="Signature" class="signature-image">
                        @endif
                        <div class="signature-line"></div>
                        <div class="signature-name">Dr. Ahmad ALIYEV</div>
                        <div class="signature-title">Chairperson of the Board of Trustees</div>
                    </div>
                    
                    <!-- Signature 2 - President -->
                    <div class="signature-box">
                        @php
                            $signature2Path = public_path('images/Imza2.png');
                            $signature2Data = file_exists($signature2Path) ? base64_encode(file_get_contents($signature2Path)) : '';
                        @endphp
                        @if($signature2Data)
                            <img src="data:image/png;base64,{{ $signature2Data }}" alt="Signature" class="signature-image">
                        @endif
                        <div class="signature-line"></div>
                        <div class="signature-name">Prof. Dr. Tural AYSAL</div>
                        <div class="signature-title">President</div>
                    </div>
                    
                    <!-- Signature 3 - Director -->
                    <div class="signature-box">
                        @php
                            $signature3Path = public_path('images/imza3.png');
                            $signature3Data = file_exists($signature3Path) ? base64_encode(file_get_contents($signature3Path)) : '';
                        @endphp
                        @if($signature3Data)
                            <img src="data:image/png;base64,{{ $signature3Data }}" alt="Signature" class="signature-image">
                        @endif
                        <div class="signature-line"></div>
                        <div class="signature-name">Prof. Dr. Eldar MAMMADOV</div>
                        <div class="signature-title">Director of the Graduate School</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Seal Watermark -->
        <div class="seal-container">
            @if($logoData)
                <img src="data:{{ $logoMime }};base64,{{ $logoData }}" alt="Seal" class="seal">
            @endif
        </div>
        
        <!-- Verification Footer -->
        <div class="verification-footer">
            <div class="qr-section">
                @php
                    $verificationUrl = 'https://verify.eipu.edu.pl';
                    $qrCodeBase64 = null;
                    try {
                        $qrCode = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(50)->generate($verificationUrl);
                        $qrCodeBase64 = base64_encode($qrCode);
                    } catch (\Exception $e) {
                        // QR code generation failed, skip it
                    }
                @endphp
                @if($qrCodeBase64)
                    <img src="data:image/svg+xml;base64,{{ $qrCodeBase64 }}" class="qr-code" alt="QR Code">
                @endif
                {{-- <div class="verification-text">
                    Verify this diploma at<br>
                    <strong>{{ $verificationUrl }}</strong><br>
                    Code: <strong>{{ $verificationCode ?? strtoupper(\Illuminate\Support\Str::random(12)) }}</strong>
                </div> --}}
            </div>
        </div>
    </div>
</body>
</html>

