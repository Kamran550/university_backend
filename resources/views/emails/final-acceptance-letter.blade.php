<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate of Final Acceptance</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h2 style="color: #2c3e50;">Certificate of Final Acceptance</h2>
        
        <p>Dear {{ $student->first_name }} {{ $student->last_name }},</p>
        
        <p>
            Congratulations! Your application has been approved and your registration in the system is complete.
        </p>
        
        <p>
            Your final acceptance letter is attached to this email in PDF format. Please upload it and read it.
        </p>
        
        <div style="background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px; margin: 20px 0;">
            <h3 style="color: #2c3e50; margin-top: 0;">Student Portal Login Information</h3>
            <p style="margin-bottom: 10px;">
                <strong>Portal address:</strong> 
                <a href="https://student.eipu.edu.pl" style="color: #007bff;">https://student.eipu.edu.pl</a>
            </p>
            <p style="margin-bottom: 10px;">
                <strong>Username:</strong> {{ $user->username }}
            </p>
            <p style="margin-bottom: 10px;">
                <strong>E-mail:</strong> {{ $user->email }}
            </p>
            @if($plainPassword)
            <p style="margin-bottom: 0;">
                <strong>Password:</strong> <code style="background-color: #e9ecef; padding: 2px 6px; border-radius: 4px;">{{ $plainPassword }}</code>
            </p>
            @endif
        </div>
        
        <p style="background-color: #fff3cd; border: 1px solid #ffc107; border-radius: 8px; padding: 15px; color: #856404;">
            <strong>⚠️ Important:</strong> Please change your password after your first login. Keep this email safe.
        </p>
        
        <p>
            If you have any questions, please contact us.
        </p>
        
        <p style="margin-top: 30px;">
            Best regards,<br>
            {{ config('app.name') }}
        </p>
    </div>
</body>
</html>

