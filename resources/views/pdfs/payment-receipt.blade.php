<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt - {{ $user->name }} {{ $user->surname }}</title>
    <style>
        @page {
            margin: 15mm 20mm;
            size: A4;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Serif', 'Times New Roman', serif;
            font-size: 8.5pt;
            line-height: 1.3;
            color: #1f2937;
            margin: 0 auto;
            padding: 0 15mm;
            padding-bottom: 140px;
            background: #ffffff;
            position: relative;
            min-height: 100vh;
            max-width: 170mm;
        }

        .header {
            border-bottom: 3px solid #dc2626;
            padding: 8px 0;
            margin-bottom: 10px;
            background: linear-gradient(to bottom, #fef2f2 0%, #ffffff 100%);
        }

        .logo-container {
            text-align: center;
            padding: 5px 0;
            position: relative;
            margin-top: 0;
        }

        .logo {
            max-width: 25mm;
            height: auto;
        }

        .university-name-container {
            text-align: center;
        }

        .university-name {
            font-size: 13pt;
            font-weight: bold;
            color: #1f2937;
            text-align: center;
            margin: 5px 0;
            padding: 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .document-title {
            font-size: 11pt;
            font-weight: bold;
            text-align: center;
            margin: 8px 0 12px 0;
            text-transform: uppercase;
            letter-spacing: 1px;
            background-color: #dc2626;
            color: #ffffff;
            padding: 10px 20px;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .section-header {
            font-size: 7.5pt;
            font-weight: bold;
            margin: 10px 0 5px 0;
            padding: 6px 10px;
            border-left: 4px solid #dc2626;
            background-color: #fef2f2;
            color: #1f2937;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-grid {
            display: table;
            width: 100%;
            margin: 6px 0 10px 0;
            border-collapse: collapse;
            font-size: 7pt;
            border: 1px solid #e5e7eb;
            border-radius: 4px;
            overflow: hidden;
        }

        .info-row {
            display: table-row;
        }

        .info-row:nth-child(even) {
            background-color: #f9fafb;
        }

        .info-label {
            display: table-cell;
            padding: 5px 10px;
            font-weight: bold;
            width: 35%;
            border: 1px solid #e5e7eb;
            background-color: #f3f4f6;
            color: #1f2937;
        }

        .info-value {
            display: table-cell;
            padding: 5px 10px;
            border: 1px solid #e5e7eb;
            color: #374151;
        }

        .signature-section {
            margin-top: 12px;
            text-align: right;
            padding: 10px 15px;
        }

        .signature-name {
            font-weight: bold;
            font-size: 8pt;
            margin-bottom: 5px;
            color: #1f2937;
        }

        .signature-title {
            font-size: 7.5pt;
            color: #6b7280;
            padding-right: 108px;
        }

        .payment-table {
            width: 100%;
            border-collapse: collapse;
            margin: 6px 0 10px 0;
            font-size: 7pt;
            border: 1px solid #e5e7eb;
            border-radius: 4px;
            overflow: hidden;
        }

        .payment-table th,
        .payment-table td {
            padding: 6px 10px;
            border: 1px solid #e5e7eb;
            text-align: left;
        }

        .payment-table th {
            background-color: #dc2626;
            color: #ffffff;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 6.5pt;
            letter-spacing: 0.5px;
        }

        .payment-table tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }

        .payment-table tbody tr:hover {
            background-color: #f3f4f6;
        }

        .amount-cell {
            text-align: right;
            font-weight: bold;
            color: #059669;
            font-size: 7.5pt;
        }

        .verification-footer {
            position: absolute;
            bottom: 0;
            left: 15mm;
            right: 15mm;
            margin-top: 10px;
            padding: 0;
        }

        .date-line {
            font-weight: bold;
            font-size: 6.5pt;
            margin-bottom: 10px;
        }

        .footer-divider {
            height: 1px;
            background-color: #666;
            margin: 10px 0;
        }

        .verification-text {
            font-size: 7pt;
            line-height: 1.4;
        }

        .footer-info {
            font-size: 7pt;
            line-height: 1.1;
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
    <!-- Header -->
    <div class="header">
        <div class="logo-container">
            @php
                $logoPath = public_path(path: 'images/EIPU-simvol.png');
                $logoData = file_exists($logoPath) ? base64_encode(file_get_contents($logoPath)) : '';
                $logoMime = 'image/jpeg';
            @endphp
            @if ($logoData)
                <img src="data:{{ $logoMime }};base64,{{ $logoData }}" alt="EIPU Logo" class="logo">
            @endif
            <div class="university-name-container">
                <div class="university-name">
                    EUROPEAN INTERNATIONAL PEACE UNIVERSITY
                </div>
            </div>
        </div>
    </div>

    <!-- Document Title -->
    <div class="document-title">
        PAYMENT RECEIPT
    </div>

    <!-- Receipt Information -->
    <div class="section-header">Invoiced Person: {{ $invoicedNumber }}</div>
    <div class="info-grid">
        <div class="info-row">
            <div class="info-label">Name Surname</div>
            <div class="info-value">{{ strtoupper($user->name . ' ' . $user->surname) }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Passport</div>
            <div class="info-value">{{ $passportNumber }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Student Number</div>
            <div class="info-value">{{ $studentNumber }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Date</div>
            <div class="info-value">{{ $payment->created_at->format('d.m.Y') }}</div>
        </div>
    </div>

    <!-- Payment Details Table -->
    <div class="section-header">Payment Details</div>
    <table class="payment-table">
        <thead>
            <tr>
                <th style="width: 70%;">Service</th>
                <th style="width: 30%;">Service Fee</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    {{ $academicYearRange }} Academic Year,
                    {{ $payment->payment_type->value }} Fee,
                    {{ $payment->semester }} Semester
                </td>
                <td class="amount-cell"><strong>€ {{ number_format($payment->amount) }}</strong></td>
            </tr>
            <tr>
                <td><strong>Payment Status</strong></td>
                <td class="amount-cell"><strong>{{ strtoupper($payment->status->value) }}</strong></td>
            </tr>
            <tr>
                <td><strong>Payment Method</strong></td>
                <td class="amount-cell"><strong>
                        @if ($payment->payment_method->value === 'cash')
                            By Cash
                        @else
                            Online via Credit Card
                        @endif
                    </strong></td>
            </tr>
        </tbody>
    </table>

    <!-- Bank Information -->
    <div class="section-header">Bank Information for Payments</div>
    <table class="payment-table">
        <thead>
            <tr>
                <th>PAYMENT INFORMATION</th>
                <th>EURO ACCOUNT</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>BANK NAME</strong></td>
                <td>BANK MILLENNIUM S.A.</td>
            </tr>
            <tr>
                <td><strong>CITY / COUNTRY</strong></td>
                <td>WARSZAWA - POLAND</td>
            </tr>
            <tr>
                <td><strong>ACCOUNT NAME</strong></td>
                <td>EURO.INTE AND PEACE.UNIVE.SP.ZOO</td>
            </tr>
            <tr>
                <td><strong>SWIFT CODE</strong></td>
                <td>BIGBPLPW</td>
            </tr>
        </tbody>
    </table>

    <div class="signature-section">
        <div class="signature-name">
            Prof. Dr. Serdar KORAL
        </div>
        <div class="signature-title">
            Rektör
        </div>
    </div>

    <!-- Footer Section -->
    <div class="verification-footer">
        <!-- Date -->
        <div class="date-line">
            Date: {{ now()->format('d/m/Y') }}
        </div>

        <!-- Verification Box with QR Code -->
        <table style="width: 100%; margin-bottom: 15px;">
            <tr>
                <!-- Text Box -->
                <td style="padding-left: 10px;">
                    <div class="verification-text" style="background: #f0f0f0; padding: 10px 12px; border-radius: 8px;">
                        This document was e-signed for
                        <strong>{{ strtoupper($user->name . ' ' . $user->surname) }}</strong>
                        on {{ $payment->created_at->format('d/m/Y') }} with document number
                        <strong>{{ $verificationCode }}</strong>.
                        The validity of the document can be confirmed by scanning the QR code or by document number at
                        <strong> {{ 'https://' . config('app.verify_domain', 'verify.eipu.edu.pl') }} </strong>
                    </div>
                </td>
                <td style="width: 70px; vertical-align: top;">
                    @php
                        $verifyDomain = config('app.verify_domain', 'verify.eipu.edu.pl');
                        $verificationUrl = 'https://' . $verifyDomain . '?verificationcode=' . $verificationCode;
                        $qrCodeSvg = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')
                            ->size(120)
                            ->generate($verificationUrl);
                        $qrCode = base64_encode($qrCodeSvg);
                    @endphp
                    <img src="data:image/svg+xml;base64,{{ $qrCode }}" style="width: 65px; height: 65px;" />
                </td>
            </tr>
        </table>

        <!-- Divider Line -->
        <div class="footer-divider"></div>

        <!-- Footer Bottom Section -->
        <table style="width: 100%; margin-top: 10px;">
            <tr>
                <td class="footer-info" style="text-align: center;">
                    <p style="margin: 5px 0;">
                        <strong>Phone:</strong> +48 579 369 968 |
                        <strong>Email:</strong> info@eipu.edu.pl |
                        <strong>Website:</strong> www.eipu.edu.pl |
                        <strong>Address:</strong> Ogrodowa 5800-876 Warsaw / Poland
                    </p>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
