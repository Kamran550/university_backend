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
            font-size: 9pt;
            line-height: 1.3;
            color: #000;
            margin: 0 auto;
            padding: 0 15mm;
            padding-bottom: 160px;
            background: white;
            position: relative;
            min-height: 100vh;
            max-width: 170mm;
        }

        .header {
            border-bottom: 1.5px solid #000;
            padding: 5px 0;
            margin-bottom: 10px;
        }

        .logo-container {
            text-align: center;
            padding: 0;
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
            font-size: 14pt;
            font-weight: bold;
            color: #000;
            text-align: center;
            margin: 5px 0;
            padding: 0;
            text-transform: uppercase;
        }

        .document-title {
            font-size: 10pt;
            font-weight: bold;
            text-align: center;
            margin: 8px 0 15px 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .section-header {
            font-size: 7.5pt;
            font-weight: bold;
            margin: 10px 0 5px 0;
            padding: 3px 5px;
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
            padding: 3px 5px;
            font-weight: bold;
            width: 35%;
            border: 1px solid #000;
        }

        .info-value {
            display: table-cell;
            padding: 3px 5px;
            border: 1px solid #000;
        }

        .payment-table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
            font-size: 7pt;
        }

        .payment-table th,
        .payment-table td {
            padding: 4px 5px;
            border: 1px solid #000;
            text-align: left;
        }

        .payment-table th {
            background-color: #fff;
            color: #000;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 6.5pt;
        }

        .amount-cell {
            text-align: right;
            font-weight: bold;
        }

        .verification-footer {
            position: absolute;
            bottom: 0;
            left: 15mm;
            right: 15mm;
            margin-top: 20px;
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
    <div class="section-header">Invoiced Person: {{ $applicationNumber }}</div>
    <div class="info-grid">
        <div class="info-row">
            <div class="info-label">Name Surname</div>
            <div class="info-value">{{ strtoupper($user->name . ' ' . $user->surname) }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Email</div>
            <div class="info-value">{{ $user->email }}</div>
        </div>
        @if ($user->phone)
            <div class="info-row">
                <div class="info-label">Phone</div>
                <div class="info-value">{{ $user->phone }}</div>
            </div>
        @endif
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
                <td>UNICREDIT BANK SRBIJA A.D.</td>
            </tr>
            <tr>
                <td><strong>CITY / COUNTRY</strong></td>
                <td>BEOGRAD - SERBIA</td>
            </tr>
            <tr>
                <td><strong>ACCOUNT NAME</strong></td>
                <td>BALKAN SCIENCE MANAGEMENT UNIVERSITY</td>
            </tr>
            <tr>
                <td><strong>SWIFT CODE</strong></td>
                <td>BACXRSBG</td>
            </tr>
            <tr>
                <td><strong>ACCOUNT NUMBER</strong></td>
                <td>[To be filled by admin]</td>
            </tr>
            <tr>
                <td><strong>IBAN</strong></td>
                <td>[To be filled by admin]</td>
            </tr>
        </tbody>
    </table>

    <div style="text-align: center; margin-top: 12px; font-size: 7.5pt;">
        <strong>Prof. Dr. Serdar KORAL</strong><br>
        Rector
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
