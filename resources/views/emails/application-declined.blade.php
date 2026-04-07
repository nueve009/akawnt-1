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
            background-color: #dc3545;
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
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Application Status Update</h1>
        </div>

        <div class="content">
            <p>Dear {{ $application->first_name }},</p>

            <p>Thank you for your interest in joining our company and for taking the time to submit your application for the position of <strong>{{ $application->position }}</strong>.</p>

            <p>After careful consideration, we have decided not to move forward with your application at this time. This decision was not made lightly, as we received many qualified candidates.</p>

            <p>We appreciate the effort you put into your application and the time you took to learn about our organization. We encourage you to keep an eye on our careers page for future opportunities that may be a better fit.</p>

            <p>Thank you again for your interest in {{ config('app.name') }}. We wish you all the best in your career endeavors.</p>

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
