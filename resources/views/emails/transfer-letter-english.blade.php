<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transfer Acceptance Letter</title>
</head>

<body
    style="font-family: 'Arial', sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background-color: #f8f9fa; border-radius: 10px; padding: 30px; margin-bottom: 20px;">
        <h1 style="color: #2c3e50; margin-bottom: 20px; font-size: 24px;">
            Dear {{ $student->first_name }} {{ $student->last_name }},
        </h1>

        <p style="font-size: 16px; margin-bottom: 15px;">
            We would like to share an important update regarding your transfer application to European International
            Peace University.
        </p>

        <div
            style="background-color: #d4edda; border-left: 4px solid #28a745; padding: 15px; margin: 20px 0; border-radius: 5px;">
            <p style="margin: 0; font-size: 16px; font-weight: bold; color: #155724;">
                ✓ Your application has been approved!
            </p>
        </div>

        <p style="font-size: 16px; margin-bottom: 15px;">
            Your Transfer Acceptance Letter is attached to this email as a PDF file. Please review this document
            carefully and follow the instructions.
        </p>

        <div
            style="background-color: #fff3cd; border-left: 4px solid #ffc107; padding: 15px; margin: 20px 0; border-radius: 5px;">
            <p style="margin: 0; font-size: 14px; color: #856404;">
                <strong>Important:</strong> You must submit the required documents within the specified period to
                complete your registration.
            </p>
        </div>

        <h2 style="color: #2c3e50; margin-top: 30px; margin-bottom: 15px; font-size: 18px;">
            Next Steps:
        </h2>

        <ol style="font-size: 14px; line-height: 1.8; padding-left: 20px;">
            <li>Read the attached Transfer Acceptance Letter carefully</li>
            <li>Prepare the required documents</li>
            <li>Note the registration dates</li>
            <li>Contact us if you have any questions</li>
        </ol>

        <div style="background-color: #e7f3ff; border-radius: 8px; padding: 20px; margin: 25px 0;">
            <h3 style="color: #2c3e50; margin-top: 0; margin-bottom: 15px; font-size: 16px;">
                Contact Information:
            </h3>
            <p style="margin: 5px 0; font-size: 14px;">
                <strong>Email:</strong> <a href="mailto:international@eipu.edu.pl"
                    style="color: #007bff; text-decoration: none;">international@eipu.edu.pl</a>
            </p>
            <p style="margin: 5px 0; font-size: 14px;">
                <strong>Phone:</strong> +48 579 369 968
            </p>
            <p style="margin: 5px 0; font-size: 14px;">
                <strong>Web:</strong> <a href="https://www.eipu.edu.pl"
                    style="color: #007bff; text-decoration: none;">www.eipu.edu.pl</a>
            </p>
        </div>

        <p style="font-size: 14px; margin-top: 30px; color: #6c757d;">
            Thank you for joining our community. We wish you a successful academic journey!
        </p>

        <div style="margin-top: 30px; padding-top: 20px; border-top: 2px solid #dee2e6;">
            <p style="font-size: 14px; margin: 5px 0;">
                <strong>Best regards,</strong>
            </p>
            <p style="font-size: 14px; margin: 5px 0;">
                International Student Affairs Department
            </p>
            <p style="font-size: 14px; margin: 5px 0; color: #2c3e50; font-weight: bold;">
                European International Peace University
            </p>
        </div>
    </div>

    <div
        style="text-align: center; font-size: 12px; color: #6c757d; margin-top: 30px; padding-top: 20px; border-top: 1px solid #dee2e6;">
        <p style="margin: 5px 0;">
            © {{ date('Y') }} European International Peace University. All rights reserved.
        </p>
        <p style="margin: 5px 0;">
            Ogrodowa 58, 00-876 Warsaw / Poland
        </p>
    </div>
</body>

</html>
