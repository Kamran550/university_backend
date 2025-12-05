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
        
        <div style="background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px; margin: 20px 0;">
            <h3 style="color: #2c3e50; margin-top: 0;">Tələbə Portalına Giriş Məlumatları</h3>
            <p style="margin-bottom: 10px;">
                <strong>Portal ünvanı:</strong> 
                <a href="https://student.eipu.edu.pl" style="color: #007bff;">https://student.eipu.edu.pl</a>
            </p>
            <p style="margin-bottom: 10px;">
                <strong>İstifadəçi adı:</strong> {{ $user->username }}
            </p>
            <p style="margin-bottom: 10px;">
                <strong>Email:</strong> {{ $user->email }}
            </p>
            @if($plainPassword)
            <p style="margin-bottom: 0;">
                <strong>Şifrə:</strong> <code style="background-color: #e9ecef; padding: 2px 6px; border-radius: 4px;">{{ $plainPassword }}</code>
            </p>
            @endif
        </div>
        
        <p style="background-color: #fff3cd; border: 1px solid #ffc107; border-radius: 8px; padding: 15px; color: #856404;">
            <strong>⚠️ Vacib:</strong> Zəhmət olmasa, ilk girişdən sonra şifrənizi dəyişdirin. Bu email-i təhlükəsiz yerdə saxlayın.
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

