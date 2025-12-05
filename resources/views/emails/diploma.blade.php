<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diploma Certificate</title>
</head>
<body style="font-family: 'Segoe UI', Arial, sans-serif; line-height: 1.7; color: #333; background-color: #f4f4f4; margin: 0; padding: 0;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <!-- Header -->
        <div style="background: linear-gradient(135deg, #8B0000 0%, #6B0000 100%); padding: 30px; text-align: center; border-radius: 12px 12px 0 0;">
            <h1 style="color: #fff; margin: 0; font-size: 24px; letter-spacing: 1px;">
                🎓 Congratulations!
            </h1>
            <p style="color: #f0d9d9; margin: 10px 0 0 0; font-size: 14px;">
                European International Peace University
            </p>
        </div>
        
        <!-- Main Content -->
        <div style="background-color: #ffffff; padding: 40px 30px; border-radius: 0 0 12px 12px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
            
            <p style="font-size: 16px; margin-bottom: 20px;">
                Dear <strong>{{ $studentApplication->first_name ?? $student->name }} {{ $studentApplication->last_name ?? $student->surname }}</strong>,
            </p>
            
            <p style="font-size: 15px; margin-bottom: 20px;">
                We are delighted to inform you that your diploma certificate has been officially issued by the European International Peace University.
            </p>
            
            <!-- Program Info Box -->
            <div style="background: linear-gradient(135deg, #f8f6f0 0%, #fff 100%); border: 1px solid #e0d5c5; border-radius: 10px; padding: 25px; margin: 25px 0;">
                <h3 style="color: #8B0000; margin: 0 0 15px 0; font-size: 16px; border-bottom: 2px solid #C4A35A; padding-bottom: 10px;">
                    📜 Diploma Details
                </h3>
                <table style="width: 100%; font-size: 14px;">
                    <tr>
                        <td style="padding: 8px 0; color: #666; width: 40%;">Degree:</td>
                        <td style="padding: 8px 0; font-weight: 600; color: #1a1a2e;">
                            {{ $application->program->degree->name ?? 'N/A' }}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #666;">Program:</td>
                        <td style="padding: 8px 0; font-weight: 600; color: #1a1a2e;">
                            {{ $application->program->name ?? 'N/A' }}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #666;">Faculty:</td>
                        <td style="padding: 8px 0; font-weight: 600; color: #1a1a2e;">
                            {{ $application->program->faculty->name ?? 'N/A' }}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #666;">Issue Date:</td>
                        <td style="padding: 8px 0; font-weight: 600; color: #1a1a2e;">
                            {{ now()->format('F d, Y') }}
                        </td>
                    </tr>
                </table>
            </div>
            
            <!-- Attachment Notice -->
            <div style="background-color: #e8f5e9; border: 1px solid #4caf50; border-radius: 8px; padding: 15px; margin: 20px 0;">
                <p style="margin: 0; font-size: 14px; color: #2e7d32;">
                    <strong>📎 Attachment:</strong> Your official diploma certificate is attached to this email as a PDF document. Please download and keep it in a safe place.
                </p>
            </div>
            
            <!-- Important Note -->
            <div style="background-color: #fff8e1; border: 1px solid #ffc107; border-radius: 8px; padding: 15px; margin: 20px 0;">
                <p style="margin: 0; font-size: 13px; color: #856404;">
                    <strong>ℹ️ Note:</strong> This diploma certificate can be verified using the QR code printed on the document or by visiting our verification portal.
                </p>
            </div>
            
            <p style="font-size: 15px; margin-top: 25px;">
                We wish you continued success in your future endeavors. Your achievement is a testament to your hard work and dedication.
            </p>
            
            <!-- Signature -->
            <div style="margin-top: 35px; padding-top: 20px; border-top: 1px solid #eee;">
                <p style="margin: 0; font-size: 14px; color: #666;">
                    Best regards,
                </p>
                <p style="margin: 5px 0 0 0; font-size: 15px; font-weight: 600; color: #8B0000;">
                    European International Peace University
                </p>
                <p style="margin: 5px 0 0 0; font-size: 13px; color: #888;">
                    Office of the Registrar
                </p>
            </div>
        </div>
        
        <!-- Footer -->
        <div style="text-align: center; padding: 20px; font-size: 12px; color: #888;">
            <p style="margin: 0;">
                European International Peace University<br>
                Warsaw, Poland
            </p>
            <p style="margin: 10px 0 0 0;">
                <a href="https://eipu.edu.pl" style="color: #8B0000; text-decoration: none;">www.eipu.edu.pl</a>
            </p>
        </div>
    </div>
</body>
</html>

