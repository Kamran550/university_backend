<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tam Qəbul Məktubu</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h2 style="color: #2c3e50;">Tam Qəbul Məktubu</h2>
        
        <p>Hörmətli {{ $student->first_name }} {{ $student->last_name }},</p>
        
        <p>
            Təbriklər! Müraciətiniz təsdiqləndi və sistemə qeydiyyatınız tamamlandı.
        </p>
        
        <p>
            Tam qəbul məktubunuz PDF formatında bu email-ə əlavə edilmişdir. Lütfən, əlavəni yükləyib oxuyun.
        </p>
        
        <p>
            <strong>İstifadəçi məlumatları:</strong><br>
            Email: {{ $user->email }}<br>
            İstifadəçi adı: {{ $user->username }}
        </p>
        
        <p>
            Əgər sualınız varsa, bizimlə əlaqə saxlayın.
        </p>
        
        <p style="margin-top: 30px;">
            Hörmətlə,<br>
            {{ config('app.name') }}
        </p>
    </div>
</body>
</html>

