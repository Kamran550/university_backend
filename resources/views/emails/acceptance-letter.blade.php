<!DOCTYPE html>
<html lang="az">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Şərtli Qəbul Məktubu</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <div style="text-align: center; margin-bottom: 30px;">
            <h1 style="color: #1a1a1a; margin-bottom: 10px;">EİPU</h1>
            <h2 style="color: #1a1a1a; margin-top: 0;">EUROPEAN INTERNATIONAL PEACE UNIVERSITY</h2>
        </div>

        <p>Hörmətli <strong>{{ $student->first_name }} {{ $student->last_name }}</strong>,</p>

        <p>
            Sizə şərtli qəbul məktubunuzu göndəririk. Qəbul məktubunuz PDF formatında bu email-ə əlavə edilmişdir.
        </p>

        <p>
            <strong>Müraciət Nömrəsi:</strong> {{ $student->application_id ?? $student->id }}<br>
            <strong>Dərəcə:</strong> {{ $student->application->program?->degree?->name ?? 'N/A' }}<br>
            <strong>Fakültə:</strong> {{ $student->application->program?->faculty?->name ?? 'N/A' }}<br>
            <strong>Proqram:</strong> {{ $student->application->program?->name ?? 'N/A' }}<br>
        </p>

        <p>
            Qəbul məktubunuzu yükləyib oxuyun və lazımi addımları yerinə yetirin.
        </p>

        <p>
            Əgər sualınız varsa, bizimlə əlaqə saxlayın.
        </p>

        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd; font-size: 12px; color: #666;">
            <p>Hörmətlə,<br>
            <strong>EİPU</strong><br>
            Qəbul Komitəsi</p>
        </div>
    </div>
</body>
</html>

