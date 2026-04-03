<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email - TailorOnDesk</title>
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9fafb;
            color: #374151;
            line-height: 1.6;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background-color: #ffffff;
            padding: 32px 24px;
            text-align: center;
            color: #374151;
            border-bottom: 1px solid #e5e7eb;
        }
        .logo {
            font-size: 24px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-bottom: 16px;
            color: #4f46e5;
        }
        .logo-icon {
            font-size: 28px;
        }
        .title {
            font-size: 20px;
            font-weight: 600;
            margin: 0;
        }
        .content {
            padding: 32px 24px;
        }
        .greeting {
            font-size: 18px;
            font-weight: 600;
            color: #111827;
            margin-bottom: 16px;
        }
        .message {
            font-size: 16px;
            color: #6b7280;
            margin-bottom: 24px;
        }
        .button-container {
            text-align: center;
            margin: 32px 0;
        }
        .verify-button {
            display: inline-block;
            background-color: #4f46e5;
            color: white;
            text-decoration: none;
            padding: 16px 32px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.3);
            transition: all 0.3s ease;
        }
        .verify-button:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 15px -3px rgba(79, 70, 229, 0.4);
        }
        .alternative-text {
            font-size: 14px;
            color: #9ca3af;
            margin-top: 16px;
        }
        .link-box {
            background-color: #f3f4f6;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 16px;
            margin: 16px 0;
            word-break: break-all;
            font-family: monospace;
            font-size: 14px;
            color: #6b7280;
        }
        .footer {
            background-color: #f9fafb;
            padding: 24px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }
        .footer-text {
            font-size: 14px;
            color: #9ca3af;
            margin: 0;
        }
        .shop-name {
            font-weight: 600;
            color: #6366f1;
        }
        .expiry-notice {
            background-color: #fef3c7;
            border: 1px solid #f59e0b;
            border-radius: 8px;
            padding: 16px;
            margin: 16px 0;
            font-size: 14px;
            color: #92400e;
        }
        .expiry-icon {
            color: #f59e0b;
            margin-right: 8px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <div class="logo">
                <i class="fa-solid fa-scissors text-indigo-400 text-2xl"></i>
                <span>TailorOnDesk</span>
            </div>
            <h1 class="title">Email Verification</h1>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="greeting">Hello {{ $user->name }}! 👋</div>
            
            <div class="message">
                Welcome to <span class="shop-name">{{ $shopName }}</span>! We're excited to have you on board. 
                To complete your registration and ensure the security of your account, please verify your email address by clicking the button below.
            </div>

            <div class="expiry-notice">
                <i class="expiry-icon">⏰</i>
                <strong>Important:</strong> This verification link will expire in 60 minutes for security reasons.
            </div>

            <div class="button-container">
                <a href="{{ $verificationUrl }}" class="verify-button">
                    Verify Email Address
                </a>
            </div>

            <div class="alternative-text">
                If the button doesn't work, you can copy and paste this link into your browser:
            </div>
            
            <div class="link-box">
                {{ $verificationUrl }}
            </div>

            <div class="message">
                Once verified, you'll be automatically logged in and can start using all the features of your tailor shop management system.
            </div>

            <div class="message">
                If you didn't create an account with us, please ignore this email. No further action is required.
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p class="footer-text">
                © {{ date('Y') }} TailorOnDesk. All rights reserved.<br>
                Streamlining tailor shop management, one stitch at a time.
            </p>
        </div>
    </div>
</body>
</html>