<!DOCTYPE html>
<html lang="az">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceptance Letter</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <div style="text-align: center; margin-bottom: 30px;">
            <h1 style="color: #1a1a1a; margin-bottom: 10px;">EİPU</h1>
            <h2 style="color: #1a1a1a; margin-top: 0;">EUROPEAN INTERNATIONAL PEACE UNIVERSITY</h2>
        </div>

        <p>Dear <strong>{{ $student->first_name }} {{ $student->last_name }}</strong>,</p>

        <p>
            We are sending you the conditional acceptance letter. The conditional acceptance letter is attached to this email in PDF format.
        </p>

        <p>
            <strong>Application Number:</strong> {{ $student->application_id ?? $student->id }}<br>
            <strong>Degree:</strong> {{ $student->application->program?->degree?->name ?? 'N/A' }}<br>
            <strong>Faculty:</strong> {{ $student->application->program?->faculty?->name ?? 'N/A' }}<br>
            <strong>Program:</strong> {{ $student->application->program?->name ?? 'N/A' }}<br>
        </p>

        <p>
            Upload the acceptance letter and follow the necessary steps to complete your registration.
        </p>

        <p>
            If you have any questions, please contact us at <a href="mailto:international@eipu.edu.pl">international@eipu.edu.pl</a>.
        </p>

        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd; font-size: 12px; color: #666;">
            <p>Best regards,<br>
            <strong>EİPU</strong><br>
            Acceptance Committee</p>
        </div>
    </div>
</body>
</html>

