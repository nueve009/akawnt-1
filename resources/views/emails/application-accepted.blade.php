<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.6;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #28a745;
            color: white;
            padding: 20px;
            border-radius: 5px 5px 0 0;
            text-align: center;
        }
        .content {
            background-color: #f9f9f9;
            padding: 20px;
            border: 1px solid #ddd;
        }
        .footer {
            background-color: #f0f0f0;
            padding: 15px;
            border-radius: 0 0 5px 5px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        .credentials {
            background-color: #fff3cd;
            border: 1px solid #ffc107;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .button {
            display: inline-block;
            background-color: #28a745;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Congratulations!</h1>
        </div>

        <div class="content">
            <p>Dear {{ $application->first_name }},</p>

            <p>We are pleased to inform you that your job application for the position of <strong>{{ $application->position }}</strong> has been accepted!</p>

            <p>We were impressed by your qualifications and look forward to having you join our team.</p>

            <div class="credentials">
                <strong>Your Account Credentials:</strong><br><br>
                <strong>Email:</strong> {{ $application->email }}<br>
                <strong>Temporary Password:</strong> <code>{{ $tempPassword }}</code>
            </div>

            <p><strong>Next Steps:</strong></p>
            <ol>
                <li>Click the button below to login to your account</li>
                <li>Use your email and the temporary password provided above</li>
                <li>Change your password in your profile settings</li>
            </ol>

            <div style="text-align: center;">
                <a href="{{ $loginUrl }}" class="button">Login to Your Account</a>
            </div>

            <p>If you have any questions or need assistance, please don't hesitate to contact us.</p>

            <p>Best regards,<br>
            The {{ config('app.name') }} Team</p>
        </div>

        <div class="footer">
            <p>This is an automated email. Please do not reply to this message.</p>
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
