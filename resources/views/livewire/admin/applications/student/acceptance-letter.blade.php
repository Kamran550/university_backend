<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conditional Acceptance Letter - {{ $student->first_name }} {{ $student->last_name }}</title>
    <style>
        @page {
            margin: 12mm;
            size: A4;
        }
        
        body {
            font-family: 'Arial', 'Helvetica', sans-serif;
            font-size: 7.5pt;
            line-height: 1.3;
            color: #000;
            margin: 0;
            padding: 0;
            padding-bottom: 180px;
            background: white;
            position: relative;
            min-height: 100vh;
        }
        
        /* Background Watermark */
        body::before {
            content: '';
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 600px;
            height: 600px;
            background-image: url('{{ public_path("images/EIPU-logo-dark.png") }}');
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            opacity: 0.08;
            z-index: -1;
            pointer-events: none;
        }
        
        .header {
            border-bottom: 1.5px solid #000;
            padding: 5px 0;
            margin-bottom: 8px;
        }
        
        .logo-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0;
            position: relative;
        }
        
        .logo {
            max-width: 25mm;
            height: auto;
            flex-shrink: 0;
        }
        
        .university-name-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        
        .header-right-info {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            justify-content: center;
            font-size: 7.5pt;
            text-align: right;
            min-width: 80mm;
        }
        
        .university-name {
            font-size: 14pt;
            font-weight: bold;
            color: #000;
            text-align: center;
            margin: 0;
            padding: 0;
        }
        
        .directorate-name {
            font-size: 9pt;
            font-weight: normal;
            color: #000;
            text-align: center;
            margin: 2px 0 0 0;
            padding: 0;
        }
        
        .subject-info {
            margin: 8px 0 4px 0;
            font-size: 7.5pt;
        }
        
        .subject-info-row {
            margin: 2px 0;
        }
        
        .document-title {
            font-size: 11pt;
            font-weight: bold;
            text-align: center;
            margin: 10px 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .greeting {
            margin: 8px 0;
            font-size: 7.5pt;
        }
        
        .content {
            margin: 6px 0;
            text-align: justify;
            line-height: 1.3;
        }
        
        .content p {
            margin: 4px 0;
        }
        
        .section-header {
            font-size: 8pt;
            font-weight: bold;
            margin: 8px 0 5px 0;
            padding: 4px 6px;
            background-color: #f0f0f0;
            border-left: 3px solid #000;
        }
        
        .info-grid {
            display: table;
            width: 100%;
            margin: 8px 0;
            border-collapse: collapse;
            font-size: 7pt;
        }
        
        .info-row {
            display: table-row;
        }
        
        .info-label {
            display: table-cell;
            padding: 4px 6px;
            font-weight: bold;
            width: 40%;
            border: 1px solid #000;
            background-color: #f9f9f9;
        }
        
        .info-value {
            display: table-cell;
            padding: 4px 6px;
            border: 1px solid #000;
        }
        
        .subsection-title {
            font-size: 7.5pt;
            font-weight: bold;
            margin: 8px 0 4px 0;
        }
        
        .payment-table {
            width: 100%;
            border-collapse: collapse;
            margin: 8px 0;
            font-size: 6.5pt;
            
        }
        
        .payment-table th,
        .payment-table td {
            padding: 3px 5px;
            border: 1px solid #000;
            text-align: left;
        }
        
        .payment-table th {
            background-color: #f0f0f0;
            color: #000;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 6pt;
        }
        
        .dates-grid {
            display: table;
            width: 100%;
            border-collapse: collapse;
            font-size: 7pt;
        }
        
        .dates-row {
            display: table-row;
        }
        
        .dates-label {
            display: table-cell;
            padding: 3px 6px;
            border: 1px solid #000;
            width: 50%;
            font-weight: 600;
        }
        
        .dates-value {
            display: table-cell;
            padding: 3px 6px;
            border: 1px solid #000;
        }
        
        .important-box {
            margin: 8px 0;
            padding: 6px;
            border: 1.5px solid #000;
            background-color: #fafafa;
        }
        
        .important-title {
            font-size: 8pt;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .important-box ol {
            margin: 5px 0;
            padding-left: 15px;
            font-size: 6pt;
        }
        
        .important-box li {
            margin: 3px 0;
            line-height: 1.2;
        }
        
        .end-line {
            text-align: center;
            font-weight: bold;
            margin: 10px 0;
            font-size: 7pt;
        }
        
        .verification-footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            margin-top: 20px;
            padding: 0;
        }

        .verification-box-2 {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 10px;
        }
        
        .verification-box {
            background-color: #f0f0f0;
            border-radius: 8px;
            padding: 12px 15px;
            flex: 1;
        }
        
        .verification-text-box {
            font-size: 10pt;
            line-height: 1.5;
            color: #000;
        }
        
        .doc-number {
            font-weight: bold;
            font-family: 'Courier New', monospace;
            letter-spacing: 0.5px;
        }
        
        .qr-code {
            width: 70px;
            height: 70px;
            flex-shrink: 0;
        }
        
        .footer-divider {
            height: 1px;
            background-color: #666;
            margin: 10px 0;
        }
        
                        
        .website-row {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 5px;
            margin: 5px 0;
            font-size: 7pt;
        }
        
        .social-row {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 6px;
            margin-top: 5px;
        }
        
        .social-handle {
            font-size: 7pt;
            color: #000;
            margin-left: 2px;
        }
        
        .social-icon {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background-color: #333;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 10pt;
            font-weight: bold;
            line-height: 1;
        }
        
        .social-icon.instagram {
            font-size: 12pt;
        }
        
        .social-icon.twitter {
            font-size: 11pt;
        }
        
        .date-line {
            font-weight: bold;
            font-size: 7pt;
            margin-bottom: 10px;
        }
        
        @media print {
            body {
                margin: 0;
                padding: 0;
            }
            
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="logo-container">
            @php
                $logoPath = public_path('images/EIPU-simvol.png');
                $logoData = file_exists($logoPath) ? base64_encode(file_get_contents($logoPath)) : '';
                $logoMime = 'image/jpeg';
            @endphp
            @if($logoData)
                <img src="data:{{ $logoMime }};base64,{{ $logoData }}" alt="EIPU Logo" class="logo">
            @endif
            <div class="university-name-container">
                <div class="university-name">
                    European International Peace University
                </div>
                <div class="directorate-name">
                    Directorate of International Relations
                </div>
            </div>
            <div class="header-right-info">
                <div>Date: {{ now()->format('d.m.Y') }}</div>
            </div>
        </div>
        
        <!-- Subject and Application Code -->
        <div class="subject-info">
            <div class="subject-info-row">
                Subject: {{ $student->application->program?->degree?->name ?? 'N/A' }} degree
            </div>
            <div class="subject-info-row">
                Application Code: EIPU{{ $student->application_id ?? $student->id }}
            </div>
            <div class="subject-info-row">
                Dear {{ strtoupper($student->first_name . ' ' . $student->last_name) }}, Date: {{ now()->format('d.m.Y') }}
            </div>
        
        </div>
    </div>

    <!-- Document Title -->
    <div class="document-title">
        CONDITIONAL ACCEPTANCE LETTER
    </div>

    <!-- Greeting -->

    <!-- Introduction Content -->
    <div class="content">
        <p>
            We are pleased to inform you that the Admission Committee of European International Peace University has carefully reviewed your application for admission to
            <strong>{{ $student->application->program?->name ?? 'Program' }}</strong> ({{ $student->application->program?->degree?->name ?? 'Degree' }}) for the 2025-2026 – Fall. It is our pleasure to inform you that you have been granted conditional acceptance to the program. We extend our warm congratulations on this achievement.
        </p>
    </div>

    <!-- Applicant and Program Details -->
    <div class="section-header">Applicant and Program Details</div>
    
    <div class="info-grid">
        <div class="info-row">
            <div class="info-label">Application Number</div>
            <div class="info-value"><strong>{{ $student->application_id ?? $student->id }}</strong></div>
        </div>
        <div class="info-row">
            <div class="info-label">Full Name</div>
            <div class="info-value"><strong>{{ strtoupper($student->first_name . ' ' . $student->last_name) }}</strong></div>
        </div>
        <div class="info-row">
            <div class="info-label">Passport No</div>
            <div class="info-value">{{ $student->passport_number ?? 'N/A' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Date of Birth / Citizenship</div>
            <div class="info-value">{{ $student->date_of_birth ? $student->date_of_birth->format('d/m/Y') : 'N/A' }} – {{ $student->nationality ?? 'N/A' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Program</div>
            <div class="info-value">{{ $student->application->program?->name ?? 'N/A' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Degree and Duration</div>
            <div class="info-value">{{ $student->application->program?->degree?->name ?? 'N/A' }} - 4 Academic Years</div>
        </div>
        <div class="info-row">
            <div class="info-label">Faculty</div>
            <div class="info-value">{{ $student->application->program?->faculty?->name ?? 'N/A' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Education Language</div>
            <div class="info-value">{{ $student->native_language ?? 'English' }}</div>
        </div>
    </div>

    <!-- Tuition Fee -->
    <div class="section-header">Tuition Fee</div>
    
    <div class="info-grid">
        <div class="info-row">
            <div class="info-label">Annual Tuition Fee (%90)</div>
            <div class="info-value"><strong>{{ $student->application->program?->price_per_year ?? 'N/A' }}</strong></div>
        </div>
        <div class="info-row">
            <div class="info-label">Amount of Deposit Payment</div>
            <div class="info-value"><strong>1300 USD</strong></div>
        </div>
    </div>
    <!-- Section 1 -->
    {{-- <div class="section-header">1. Condition for Issuing the Acceptance Letter</div> --}}
    <br>
    <br>

    <div class="subsection-title">1.1. Deposit Payment</div>
    <div class="content">
        <p>
            The official Acceptance Letter will be issued upon payment of a non-refundable deposit of 1300 USD, either by credit card via the EIPU Application
            Platform or by bank transfer to the University's bank account. For all bank transfers; name, surname and application number must be provided. The
            bank account details are provided below. To proceed to the next stage of your application, you are required to upload a copy of the bank receipt or payment confirmation to the EIPU Application Platform after completing the transfer.
        </p>
    </div>
    <br>
    <!-- Payment Table -->
    <table class="payment-table">
        <thead>
            <tr>
                <th>Payment Information</th>
                <th>U.S. Dollar Account</th>
                <th>Euro Account</th>
                <th>Turkish Lira Account</th>
            </tr>
        </thead>
        <tbody>
            {{-- <tr>
                <td><strong>Bank Name</strong></td>
                <td>Türkiye İş Bankası</td>
                <td>Türkiye İş Bankası</td>
                <td>Türkiye İş Bankası</td>
            </tr> --}}
            <tr>
                <td><strong>Account Name</strong></td>
                <td>European International Peace University Ltd.</td>
                <td>European International Peace University Ltd.</td>
                <td>European International Peace University Ltd.</td>
            </tr>
            <tr>
                <td><strong>Account No</strong></td>
                <td>6813-63633</td>
                <td>6813-63647</td>
                <td>6813-48527</td>
            </tr>
            <tr>
                <td><strong>Swift Code</strong></td>
                <td>ISBKTRIS</td>
                <td>ISBKTRIS</td>
                <td>ISBKTRIS</td>
            </tr>
            <tr>
                <td><strong>IBAN</strong></td>
                <td>TR89 0006 4000 0026 8130 0636 33</td>
                <td>TR02 0006 4000 0026 8130 0636 47</td>
                <td>TR07 0006 4000 0016 8130 0485 27</td>
            </tr>
        </tbody>
    </table>

    <br>
    <br>
    <!-- Section 2 -->
    <div class="section-header">2. Conditions of Registration Upon Arrival at EIPU</div>
    <div class="content">
        <p>
            You can download your official Acceptance Letter from the EIPU Application platform after completing the procedures listed there. Please carefully
            review the conditions and instructions below before registering to ensure a smooth registration process. We eagerly anticipate the completion of your admission process and look forward to welcoming you as a student in the upcoming Fall Semester of the 2025-2026 Academic Year.
        </p>
    </div>

    <div class="subsection-title">2.1. English Language Requirement</div>
    <div class="content">
        <p>
            Students who are unable to provide valid proof of English proficiency (TOEFL iBT – 78, IELTS – 6.0, or PTE – 55) will be required to take the English
            Proficiency Test upon arrival at the University. Those who pass the assessment conducted by the English Preparatory School will be allowed to proceed to
            their undergraduate program.
        </p>
    </div>
    <br>
    <!-- Important Dates -->
    <div class="section-header">Important Dates</div>
    
    <div class="dates-grid">
        <div class="dates-row">
            <div class="dates-label">Course registration period</div>
            <div class="dates-value">15/09/2025 – 19/09/2025</div>
        </div>
        <div class="dates-row">
            <div class="dates-label">First day for arrivals</div>
            <div class="dates-value">01/09/2025</div>
        </div>
        <div class="dates-row">
            <div class="dates-label">Classes commence</div>
            <div class="dates-value">22/09/2025</div>
        </div>
        <div class="dates-row">
            <div class="dates-label">Last day for arrivals</div>
            <div class="dates-value">31/10/2025</div>
        </div>
        <div class="dates-row">
            <div class="dates-label">English proficiency test period</div>
            <div class="dates-value">22/09/2025 – 30/09/2025</div>
        </div>
        <div class="dates-row">
            <div class="dates-label">Late registration date</div>
            <div class="dates-value">31/10/2025</div>
        </div>
    </div>
    <br>
    
    <!-- Important Information -->
    <div class="important-box">
        <div class="important-title">Important Informations</div>
        <ol>
            <li>Please note that the Airport Immigration Office will not permit entry into North Cyprus with a Conditional Acceptance Letter.</li>
            <li>It is the responsibility of each student to ensure that all required documents for enrollment are complete and submitted. Failure to provide the necessary documents may result in delays in class registration or an inability to register.</li>
            <li>All documents submitted to our University from your high school, college, or university are assumed to be original and issued by institutions accredited by the Ministry of Education in the country of graduation.</li>
            <li>If your language proficiency is insufficient to begin the graduate program (Turkish and/or English), you must complete at least one year of language courses. The annual tuition fee for the language course is not included in the program fee, and the tuition fee for the language course (prep school) will be added for each program.</li>
            <li>The deposit payment is non-refundable and will be credited toward the total fees for the first semester.</li>
            <li>Starting from 20 September 2025, students who register will be charged a late registration fee of EUR 15 per day.</li>
        </ol>
    </div>

    <!-- End Line -->
    <div class="end-line">
        ***THIS IS THE LAST LINE. NO INFORMATION WAS PRINTED AFTER THIS LINE. ***
    </div>

    <!-- Footer Section -->
    <div class="verification-footer">
        <!-- Date -->
        <div class="date-line">
            Date: {{ now()->format('d/m/Y') }}
        </div>
        
        <!-- Verification Box with QR Code -->
     {{-- <div class="verification-box-2">
        <div style="flex-shrink: 0;">
            @php
                $qrCode = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(70)->generate($student->getVerificationUrl());
                $qrCodeBase64 = base64_encode($qrCode);
            @endphp
            <img src="data:image/svg+xml;base64,{{ $qrCodeBase64 }}" alt="QR Code" class="qr-code">
        </div>

        <div class="verification-box">
            <div class="verification-text-box ">
                This document was e-signed for <strong>{{ strtoupper($student->first_name . ' ' . $student->last_name) }}</strong> on {{ now()->format('d/m/Y') }} with document number <strong class="doc-number">{{ $student->application->verification_code ?? 'N/A' }}</strong>. The validity of the document can be confirmed by scanning the QR code or by document number at <strong>{{ $student->getVerificationUrl() }}</strong>
            </div>
        </div>
     </div> --}}
     <table style="width: 100%; margin-bottom: 15px;">
        <tr>
            <!-- QR Code -->
            <td style="width: 80px; vertical-align: top;">
                @php
                    $qrCode = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(70)->generate($student->getVerificationUrl());
                    $qrCodeBase64 = base64_encode($qrCode);
                @endphp
    
                <img src="data:image/svg+xml;base64,{{ $qrCodeBase64 }}" 
                     style="width: 70px; height: 70px;" />
            </td>
    
            <!-- Text Box -->
            <td style="padding-left: 10px;">
                <div style="background: #f0f0f0; padding: 12px 15px; border-radius: 8px; font-size: 11px; line-height: 1.4;">
                    This document was e-signed for 
                    <strong>{{ strtoupper($student->first_name . ' ' . $student->last_name) }}</strong>
                    on {{ now()->format('d/m/Y') }} with document number 
                    <strong>{{ $student->application->documentVerification->verification_code ?? strtoupper(\Illuminate\Support\Str::random(12)) }}</strong>.
                    The validity of the document can be confirmed by scanning the QR code or by document number at 
                    <strong>{{ $student->getVerificationUrl() }}</strong>.
                </div>
            </td>
        </tr>
    </table>
    
        
        <!-- Divider Line -->
        <div class="footer-divider"></div>
        
        <!-- Footer Bottom Section -->
        <table style="width: 100%; margin-top: 20px;">
            <tr>
                <!-- LEFT SIDE -->
                <td style="width: 60%; font-size: 11px; line-height: 1.1;">
                    <p><strong>Tel:</strong>+994 50 497 52 52</p>
                    <p><strong>Email:</strong> international@eipu.edu.pl</p>
                    <p><strong>Address:</strong> Nizami, Qafqaz Center, Baku, Azerbaijan</p>
                    <p><strong>Website:</strong> www.eipu.edu.pl</p>
                </td>
        
                <!-- RIGHT SIDE -->
            </tr>
        </table>
        
    </div>

</body>
</html>