<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>100% Scholarship - Conditional Acceptance Letter</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <div style="text-align: center; margin-bottom: 30px;">
            <h1 style="color: #1a1a1a; margin-bottom: 10px;">EİPU</h1>
            <h2 style="color: #1a1a1a; margin-top: 0;">EUROPEAN INTERNATIONAL PEACE UNIVERSITY</h2>
        </div>

        <p>Dear <strong>{{ $student->first_name }} {{ $student->last_name }}</strong>,</p>

        <p>
            Congratulations! We are delighted to inform you that you have been granted <strong style="color: #2ecc71;">100% Scholarship</strong> conditional acceptance at World Peace University (WPU). 
            The conditional acceptance letter with detailed information is attached to this email in PDF format.
        </p>

        <div style="background-color: #d4edda; border: 1px solid #c3e6cb; border-radius: 5px; padding: 15px; margin: 20px 0;">
            <h3 style="margin-top: 0; color: #155724;">Scholarship Details</h3>
            <p style="margin: 5px 0;"><strong>Scholarship Status:</strong> 100% Scholarship</p>
            <p style="margin: 5px 0;"><strong>Programme Fee after Scholarship:</strong> 185.00 EUR</p>
        </div>

        <p>
            <strong>Student Number:</strong> {{ $student->student_number ?? 'N/A' }}<br>
            <strong>Application Number:</strong> {{ $student->application_number ?? $student->id }}<br>
            <strong>Degree:</strong> {{ $student->application->program?->degree?->name ?? 'N/A' }}<br>
            <strong>Faculty:</strong> {{ $student->application->program?->faculty?->name ?? 'N/A' }}<br>
            <strong>Program:</strong> {{ $student->application->program?->name ?? 'N/A' }}<br>
            <strong>Medium of Education:</strong> {{ $student->study_language === 'EN' ? 'English' : 'Turkish' }}<br>
        </p>

        <p>
            <strong>Important:</strong> Please read the attached conditional acceptance letter carefully. It contains important information about:
        </p>
        <ul>
            <li>Deposit payment details (185.00 EUR)</li>
            <li>Bank account information</li>
            <li>Registration dates</li>
            <li>Required documents</li>
        </ul>

        <p>
            We very much look forward to welcoming you to WPU. If you have any questions, please contact us at 
            <a href="mailto:international@eipu.edu.pl">international@eipu.edu.pl</a> or <a href="mailto:imo@wpu.edu.tr">imo@wpu.edu.tr</a>.
        </p>

        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd; font-size: 12px; color: #666;">
            <p>Sincerely,<br>
            <strong>Prof Dr. Serdar KORAL</strong><br>
            Director of International Student Office<br>
            <strong>World Peace University</strong></p>
            <p style="margin-top: 15px;">
                Tel: +48 579 369 968<br>
                Website: www.eipu.edu.pl
            </p>
        </div>
    </div>
</body>
</html>

