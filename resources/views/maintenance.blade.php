<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance Mode</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #333;
        }

        .maintenance-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 60px 40px;
            text-align: center;
            max-width: 500px;
            animation: slideIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .maintenance-icon {
            font-size: 80px;
            margin-bottom: 20px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.5;
            }
        }

        h1 {
            font-size: 32px;
            margin-bottom: 15px;
            color: #667eea;
        }

        p {
            font-size: 16px;
            color: #666;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .maintenance-details {
            background: #f8f9fa;
            padding: 20px;
            border-left: 4px solid #667eea;
            border-radius: 5px;
            text-align: left;
            margin-bottom: 30px;
        }

        .maintenance-details p {
            margin-bottom: 10px;
            font-size: 14px;
        }

        .maintenance-details strong {
            color: #333;
        }

        .contact-info {
            background: #e7f3ff;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .contact-info a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
        }

        .contact-info a:hover {
            text-decoration: underline;
        }

        .loader {
            display: inline-block;
            width: 30px;
            height: 30px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-top: 20px;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        .status-badge {
            display: inline-block;
            background: #fff3cd;
            color: #856404;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="maintenance-container">
        <div class="status-badge">
            ⚠️ Maintenance in Progress
        </div>

        <div class="maintenance-icon">
            🔧
        </div>

        <h1>System Maintenance</h1>

        <p>
            We're currently performing scheduled maintenance to improve our service.
            We'll be back online shortly.
        </p>

        <div class="maintenance-details">
            <p><strong>Status:</strong> Maintenance Mode Active</p>
            <p><strong>Expected Duration:</strong> A few hours</p>
            <p><strong>Last Updated:</strong> {{ now()->format('F j, Y g:i A') }}</p>
        </div>

        <div class="contact-info">
            For urgent matters, please contact us at:
            <br>
            <a href="mailto:support@example.com">support@example.com</a>
        </div>

        <div class="loader"></div>
        <p style="font-size: 12px; color: #999; margin-top: 20px;">
            We appreciate your patience and understanding.
        </p>
    </div>
</body>
</html>
