<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Öğrenci Belgesi - {{ $student->first_name }} {{ $student->last_name }}</title>
    <style>
        @page {
            margin: 12mm;
            size: A4;
        }

        body {
            font-family: 'DejaVu Serif', 'Times New Roman', serif;
            font-size: 10pt;
            line-height: 1.1;
            color: #000;
            margin: 0;
            padding: 0;
            padding-bottom: 200px;
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
            background-image: url('{{ public_path('images/EIPU-logo-dark.png') }}');
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            opacity: 0.08;
            z-index: -1;
            pointer-events: none;
        }

        .header {
            border-bottom: 1.5px solid #000;
            padding: 3px 0;
            margin-top: -5px;
            margin-bottom: 2px;
        }

        .logo-container {
            text-align: center;
            padding: 0;
            position: relative;
            margin-bottom: 3px;
            margin-top: 0;
        }

        .logo {
            max-width: 25mm;
            height: auto;
            display: block;
            margin: 0 auto;
        }

        .university-name-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            margin-top: 2px;
        }

        .university-name {
            font-size: 12pt;
            font-weight: bold;
            color: #000;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        .directorate-name {
            font-size: 7pt;
            font-weight: normal;
            color: #000;
            text-align: center;
            margin: 2px 0 0 0;
            padding: 0;
        }

        .header-right-info {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            justify-content: center;
            font-size: 7pt;
            text-align: right;
            min-width: 80mm;
        }

        .document-info {
            font-size: 7pt;
            margin: 8px 0 4px 0;
            text-align: left;
        }

        .document-title {
            font-size: 9pt;
            font-weight: bold;
            text-align: center;
            margin: 10px 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .student-info-container {
            display: table;
            width: 100%;
            margin: 8px 0;
            border-collapse: separate;
            border-spacing: 20px 0;
        }

        .student-info-left {
            display: table-cell;
            width: auto;
            vertical-align: top;
        }

        .student-info-right {
            display: table-cell;
            width: 150px;
            vertical-align: top;
        }

        .info-grid {
            display: table;
            width: 100%;
            margin: 0;
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
        }

        .info-value {
            display: table-cell;
            padding: 4px 6px;
        }

        .photo-container {
            width: 150px;
            height: 150px;
            border: none;
            display: block;
            overflow: hidden;
            background-color: #f9f9f9;
        }

        .photo-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .footer {
            margin-top: 10px;
            padding-top: 10px;
            font-size: 7pt;
            line-height: 1.1;
        }

        .footer-note {
            margin: 3px 0;
            text-align: justify;
        }

        .signature-section {
            margin-top: 8px;
            text-align: right;
            /* padding-right: 50px; */
        }

        .signature-name {
            font-weight: bold;
            font-size: 7pt;
            margin-top: 10px;
            /* padding-right: 50px; */
        }

        .signature-title {
            font-size: 7pt;
            /* margin-top: 2px; */
            padding-right: 47px;
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

        .date-line {
            font-weight: bold;
            font-size: 7pt;
            margin-bottom: 8px;
        }

        .footer-divider {
            height: 1px;
            background-color: #666;
            margin: 10px 0;
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
    <!-- Top Verification Line -->

    <!-- Header -->
    <div class="header">
        @php
            $logoPath = public_path('images/EIPU-simvol.png');
            $logoData = file_exists($logoPath) ? base64_encode(file_get_contents($logoPath)) : '';
            $logoMime = 'image/jpeg';
        @endphp
        @if ($logoData)
            <div class="logo-container">
                <img src="data:{{ $logoMime }};base64,{{ $logoData }}" alt="EIPU Logo" class="logo">
            </div>
        @endif
        <div class="university-name-container">
            <div class="university-name">
                EUROPEAN INTERNATIONAL PEACE UNIVERSITY
            </div>
            <div class="directorate-name">
                Öğrenci İşleri Daire Başkanlığı
            </div>
        </div>
        {{-- <div class="document-info">
            Ref No : E-{{ strtoupper(\Illuminate\Support\Str::random(10)) }}-{{ now()->format('d.m.Y') }}-{{ rand(1000, 9999) }}<br>
            Subject : Student Certificate
        </div> --}}
    </div>

    <!-- Document Title -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin: 10px 0;">
        <div class="document-title" style="flex: 1; margin: 0;">
            ÖĞRENCİ BELGESİ
        </div>
        <div style="font-size: 9pt; font-weight: normal;">
            {{ now()->format('d/m/Y') }}
        </div>
    </div>

    <!-- Student Information -->
    <div class="student-info-container">
        <div class="student-info-left">
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-label">Öğrenci No</div>
                    <div class="info-value">{{ $student->student_number ?? $student->id }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Pasaport No</div>
                    <div class="info-value">{{ $student->passport_number ?? 'N/A' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Adı</div>
                    <div class="info-value">{{ tr_upper($student->first_name) }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Soyadı</div>
                    <div class="info-value">{{ tr_upper($student->last_name) }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Doğum Yeri & Tarihi</div>
                    <div class="info-value">
                        {{ tr_upper($student->place_of_birth ?? ($student->nationality ?? 'N/A')) }} -
                        {{ $student->date_of_birth ? $student->date_of_birth->format('d/m/Y') : 'N/A' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Ata Adı</div>
                    <div class="info-value">{{ tr_upper($student->father_name ?? 'N/A') }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Uyruk</div>
                    <div class="info-value">{{ tr_upper($student->nationality ?? 'N/A') }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Eğitim Düzeyi</div>
                    <div class="info-value">
                        {{ tr_upper($student->application->program?->degree?->getName('TR') ?: $student->application->program?->degree?->description ?? ($student->application->program?->degree?->name ?? 'N/A')) }}
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label">Enstitü / Fakülte</div>
                    <div class="info-value">
                        {{ tr_upper($student->application->program?->faculty?->getName('TR') ?: $student->application->program?->faculty?->name ?? 'GRADUATE SCHOOL' ) }}
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label">Bölüm</div>
                    <div class="info-value">
                        {{ tr_upper($student->application->program?->getName('TR') ?: $student->application->program?->name ?? 'N/A' ) }}
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label">Eğitim Dili</div>
                    <div class="info-value">{{ $student->study_language === 'EN' ? 'İngilizce' : 'Türkçe' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Eğitim Tipi</div>
                    <div class="info-value">Örğün</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Sınıf</div>
                    <div class="info-value">DERS AŞAMASI ({{ $student->current_course ?? 1 }} SINIF)</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Kayıt Tarihi</div>
                    <div class="info-value">{{ now()->format('d/m/Y') }}</div>
                </div>
            </div>
        </div>
        <div class="student-info-right">
            @php
                $photoData = null;
                $photoMime = 'image/jpeg';

                if ($student->profile_photo_path && Storage::exists($student->profile_photo_path)) {
                    try {
                        $photoContent = Storage::get($student->profile_photo_path);
                        if ($photoContent) {
                            $photoData = base64_encode($photoContent);
                            $extension = strtolower(pathinfo($student->profile_photo_path, PATHINFO_EXTENSION));
                            $photoMime = match ($extension) {
                                'jpg', 'jpeg' => 'image/jpeg',
                                'png' => 'image/png',
                                'gif' => 'image/gif',
                                'webp' => 'image/webp',
                                default => 'image/jpeg',
                            };
                        }
                    } catch (\Exception $e) {
                        // Şəkil yüklənə bilmədi
                    }
                }
            @endphp

            @if ($photoData)
                <div class="photo-container">
                    <img src="data:{{ $photoMime }};base64,{{ $photoData }}" alt="Student Photo">
                </div>
            @else
                <div class="photo-container">
                    <div
                        style="width: 100%; height: 100%; background-color: #f0f0f0; display: flex; align-items: center; justify-content: center; color: #999; font-size: 10pt;">
                        No Photo
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Footer Notes -->
    <div class="footer">
        <div class="footer-note">
            * Yukarıda kimlik bilgileri verilen kişi öğrencimizdir.
        </div>
        <div class="footer-note">
            * Belirtilen program için öngörülen eğitim süresi
            {{ $student->application->program?->degree?->duration ?? 4 }} yıldır.
        </div>
        <div class="footer-note">
            * {{$student->application->program?->degree?->getName('TR') ?: $student->application->program?->degree?->description ?? ($student->application->program?->degree?->name ?? 'N/A') }} Eğitim-Öğretim Yönergesinin ilgili maddeleri uyarınca programa kayıtlı kişilerin öğrencilik haklarından
            yararlanabilmelerini teminen dersler için gözetilen devam, katılım ve sınav koşullarını bir bütün olarak eksiksiz
            şekilde yerine getirmeleri gerekmektedir. Aksi takdirde ilgilisinin programla ilişiği kesilir.
        </div>
        <div class="footer-note">
            * İlgilisinin
            @php
                $duration = $student->application->program?->degree?->duration ?? 4;
                $startYear = now()->addYears($duration)->format('Y');
                $endYear = now()->addYears($duration + 1)->format('Y');
            @endphp
            {{ $startYear }}-{{ $endYear }} akademik yılında mezuniyet aşamasına gelmesi beklenmektedir
        </div>
        <div class="footer-note">
            * İşbu belge ilgilisinin talebine binaen tanzim edilmiştir.
        </div>
    </div>

    <!-- Signature Section -->
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
            Tarih: {{ now()->format('d/m/Y') }}
        </div>

        <!-- Verification Box with QR Code -->
        <table style="width: 100%; margin-bottom: 10px;">
            <tr>
                <!-- QR Code -->

                <!-- Text Box -->
                <td style="padding-left: 10px; margin-top: 8x;">
                    <div
                    style="background: #f0f0f0; padding: 12px 15px; border-radius: 8px; font-size: 11px; line-height: 1.2;">
                    Bu belge,
                    {{ now()->format('d/m/Y') }} tarihinde
                    <strong>{{ strtoupper($student->first_name . ' ' . $student->last_name) }}</strong> adına
                    <strong>{{ $verificationCode ?? tr_upper(Str::random(12)) }}</strong>
                    belge numarasıyla elektronik olarak imzalanmıştır. Belgenin geçerliliği, QR kodunu tarayarak veya belge numarasını kullanarak
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

                    <img src="data:image/svg+xml;base64,{{ $qrCodeBase64 }}" style="width: 70px; height: 70px;" />
                </td>

            </tr>
        </table>

        <!-- Divider Line -->
        <div class="footer-divider"></div>

        <!-- Footer Bottom Section -->
        <table style="width: 100%; margin-top: 8px;">
            <tr>
                <!-- LEFT SIDE -->
                <td style="width: 100%; font-size: 6pt; line-height: 1.1;">
                    <p style="margin: 2px 0; font-weight: bold; text-align: center;">
                        Fully Accredited Multinational Higher Education Institution and Global Service Provider
                    </p>
                    <p style="margin: 2px 0; text-align: center;">
                        ISTASYON MAH. 2325 SK. NO: 18 / 1 ETIMESGUT ANKARA / Türkiye [ EIPU ]
                    </p>
                    <p style="margin: 2px 0; text-align: center;">
                        Ogrodowa 5800-876 Warsaw / Poland [ EIPU ]
                    </p>
                    <p style="margin: 2px 0; text-align: center;">
                        32-36 Bd d'Avranches, 1160 Bonnevoie-Nord-Verlorenkost / Luxembourg [ EIPU ]
                    </p>
                    <p style="margin: 2px 0; text-align: center;">
                        <strong>Tel:</strong> +90 5386796595 | +48 579 369 968 | +352 661115815
                    </p>
                    <p style="margin: 2px 0; text-align: center;">
                        <strong>e-mail:</strong> info@eipu.edu.pl | rectorate@eipu.edu.pl | <strong>Web:</strong>
                        www.eipu.edu.pl | www.eipu.edu.rs
                    </p>
                </td>
            </tr>
        </table>

    </div>

</body>

</html>
