<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yatay Geçiş Kabul Mektubu - {{ $student->first_name }} {{ $student->last_name }}</title>
    <style>
        @page {
            margin: 15mm 20mm;
            size: A4;
        }

        body {
            font-family: 'DejaVu Serif', 'Times New Roman', serif;
            font-size: 10pt;
            line-height: 1.4;
            color: #000;
            margin: 0;
            padding: 0;
            background: white;
            position: relative;
            min-height: 297mm;
        }

        /* Background Watermark */
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 450px;
            height: 450px;
            opacity: 0.12;
            z-index: -1;
            pointer-events: none;
        }

        .watermark img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .header {
            margin-bottom: 30px;
        }

        .logo {
            max-width: 180px;
            height: auto;
            margin-bottom: 8px;
        }

        .contact-info {
            font-size: 8.5pt;
            line-height: 1.3;
            margin-bottom: 15px;
            font-style: italic;
        }

        .document-title {
            font-size: 13pt;
            font-weight: bold;
            text-align: center;
            margin: 25px 0 10px 0;
            /* text-transform: uppercase; */
            letter-spacing: 0.5px;
        }

        .department {
            font-size: 9pt;
            text-align: center;
            margin-bottom: 20px;
            font-style: italic;
        }

        .reference-line {
            font-size: 9pt;
            margin: 8px 0;
            font-style: italic;
        }

        .greeting {
            text-align: center;
            font-size: 10pt;
            font-weight: bold;
            margin: 15px 0 12px 0;
        }

        .content {
            text-align: justify;
            line-height: 1.6;
            margin: 12px 0;
            font-style: italic;
        }

        .content p {
            margin: 10px 0;
        }

        .signature-section {
            margin-top: 30px;
            margin-bottom: 20px;
            font-style: italic;
        }

        .signature-line {
            margin: 4px 0;
        }

        .verification-footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            margin-top: 10px;
            padding: 0;
            padding-bottom: 20px;
        }

        .verification-table {
            width: 100%;
            margin-bottom: 10px;
        }

        .verification-box {
            background: #f0f0f0;
            padding: 12px 15px;
            border-radius: 8px;
            font-size: 9pt;
            line-height: 1.2;
        }

        .qr-code {
            width: 70px;
            height: 70px;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }
        }
    </style>
</head>

<body>
    <!-- Background Watermark -->
    <div class="watermark">
        @php
            $watermarkPath = public_path('images/EIPU-simvol.png');
            $watermarkData = file_exists($watermarkPath) ? base64_encode(file_get_contents($watermarkPath)) : '';
            $watermarkMime = 'image/png';
        @endphp
        @if ($watermarkData)
            <img src="data:{{ $watermarkMime }};base64,{{ $watermarkData }}" alt="Watermark">
        @endif
    </div>

    <!-- Header with Logo and Address -->
    <div class="header">
        @php
            $logoPath = public_path('images/EIPU-logo-dark.png');
            $logoData = file_exists($logoPath) ? base64_encode(file_get_contents($logoPath)) : '';
            $logoMime = 'image/png';
        @endphp
        @if ($logoData)
            <img src="data:{{ $logoMime }};base64,{{ $logoData }}" alt="EIPU Logo" class="logo">
        @endif

        <div class="contact-info">
            <strong>Email:</strong> international@eipu.edu.pl<br>
            <strong>Phone:</strong> +48 579 369 968<br>
            <strong>Date:</strong> {{ now()->format('d/m/Y') }}
        </div>
    </div>

    <!-- Document Title -->
    <div class="document-title">
        EUROPEAN INTERNATIONAL PEACE UNIVERSITY<br>
        TRANSFER ACCEPTANCE LETTER
    </div>

    <div class="department">
        International Student Affairs Department
    </div>

    <!-- Reference Information -->
    <div class="reference-line">
        <strong>Student Number:</strong> {{ $student->student_number ?? 'N/A' }}
    </div>
    <div class="reference-line">
        <strong>Passport Number:</strong> {{ $student->passport_number ?? 'N/A' }}
    </div>


    <div class="reference-line">
        <strong>Subject:</strong> Transfer Acceptance – {{ tr_upper(text: $student->first_name) }}
        {{ tr_upper(text: $student->last_name) }}
    </div>

    <!-- Greeting -->
    <div class="greeting">
        To Whom It May Concern
    </div>

    <!-- Content -->
    <div class="content">
        <p>
            This letter is issued to confirm that
            <strong>{{ strtoupper($student->first_name . ' ' . $student->last_name) }}</strong>,
            previously enrolled at <strong>{{ $student->current_university ?: 'N/A' }}</strong>,
            has been formally accepted as a
            {{ course_to_word_english($student->current_course) }} year student
            in the
            {{ $student->application->program?->degree?->getName('EN') ?? ($student->application->program?->degree?->name ?? 'N/A') }}
            {{ $student->application->program?->getName('EN') ?? ($student->application->program?->name ?? 'N/A') }}
            program at European International Peace University for the
            @php
                $applicationDate = $student->application->submitted_at ?? ($student->application->created_at ?? now());
                $startYear = $applicationDate->format('Y');
                $endYear = $startYear + 1;
            @endphp
            {{ $startYear }}–{{ $endYear }} academic year.
        </p>

        <p>
            The student's academic records have been carefully reviewed, and it has been decided to place them
            directly in the {{ course_to_word_english($student->current_course) }} year of the program in accordance with
            their qualifications.
        </p>
    </div>

    <!-- Signature Section -->
    <div class="signature-section">
        <div class="signature-line">
            Best regards,
        </div>
        <div class="signature-line" style="margin-top: 15px;">
            International Student Affairs Department
        </div>
        <br>
        <div class="signature-line">
            EUROPEAN INTERNATIONAL PEACE UNIVERSITY
        </div>
    </div>

    <!-- Verification Footer Section -->
    {{-- <div class="verification-footer">
        <!-- Verification Box with QR Code -->
        <table class="verification-table">
            <tr>
                <!-- Text Box -->
                <td style="padding-left: 10px;">
                    <div class="verification-box">
                        Bu belge,
                        {{ now()->format('d/m/Y') }} tarihinde
                        <strong>{{ strtoupper($student->first_name . ' ' . $student->last_name) }}</strong> adına
                        <strong>{{ $verificationCode ?? tr_upper(\Illuminate\Support\Str::random(12)) }}</strong>
                        belge numarasıyla elektronik olarak imzalanmıştır. Belgenin geçerliliği, QR kodunu tarayarak
                        veya belge numarasını kullanarak
                        <strong>{{ $student->getVerificationUrl() }}</strong> adresinden doğrulanabilir.
                    </div>
                </td>
                <td style="width: 80px; vertical-align: top;">
                    @php
                        $verificationCodeForUrl = $verificationCode ?? null;
                        $qrCode = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')
                            ->size(70)
                            ->generate($student->getVerificationUrl($verificationCodeForUrl));
                        $qrCodeBase64 = base64_encode($qrCode);
                    @endphp
                    <img src="data:image/svg+xml;base64,{{ $qrCodeBase64 }}" class="qr-code" />
                </td>
            </tr>
        </table>
    </div> --}}

    <div class="verification-footer">
        <!-- Verification Box with QR Code -->
        <table style="width: 100%; margin-bottom: 10px;">
            <tr>
                <!-- QR Code -->

                <!-- Text Box -->
                <td style="padding-left: 10px; padding-right: 15px;">
                    <div
                        style="background: #f0f0f0; padding: 12px 15px; border-radius: 8px; font-size: 11px; line-height: 1.2;">
                        This document was electronically signed on {{ now()->format('d/m/Y') }} on behalf of
                        <strong>{{ strtoupper($student->first_name . ' ' . $student->last_name) }}</strong>
                        with document number <strong>{{ $verificationCode ?? strtoupper(Str::random(12)) }}</strong>.
                        The validity of the document can be verified by scanning the QR code or using the document
                        number at <strong>{{ $student->getVerificationUrl() }}</strong>.
                    </div>

                </td>
                <td style="width: 80px; vertical-align: top; padding-left: 10px;">
                    @php
                        $verificationCodeForUrl = $verificationCode ?? null;
                        $qrCode = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')
                            ->size(70)
                            ->generate($student->getVerificationUrl($verificationCodeForUrl));
                        $qrCodeBase64 = base64_encode($qrCode);
                    @endphp

                    <img src="data:image/svg+xml;base64,{{ $qrCodeBase64 }}" style="width: 70px; height: 70px;" />
                </td>

            </tr>
        </table>


    </div>
</body>

</html>
