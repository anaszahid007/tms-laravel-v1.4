<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject ?? 'Important Announcement' }} - TailorOnDesk</title>
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
            background-color: #4f46e5;
            padding: 24px;
            text-align: center;
            color: white;
        }
        .logo {
            font-size: 24px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-bottom: 8px;
        }
        .logo-icon {
            font-size: 28px;
        }
        .announcement-badge {
            background-color: #ef4444;
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-block;
            margin-bottom: 8px;
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
        .shop-name {
            color: #4f46e5;
            font-weight: 600;
        }
        .announcement-content {
            background-color: #f8fafc;
            border-left: 4px solid #4f46e5;
            padding: 20px;
            margin: 24px 0;
            border-radius: 0 8px 8px 0;
            font-size: 16px;
            line-height: 1.7;
            color: #374151;
        }
        .cta-container {
            text-align: center;
            margin: 32px 0;
        }
        .cta-button {
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
        .cta-button:hover {
            background-color: #4338ca;
            transform: translateY(-1px);
            box-shadow: 0 8px 15px -3px rgba(79, 70, 229, 0.4);
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
        .admin-signature {
            margin-top: 24px;
            padding-top: 16px;
            border-top: 1px solid #e5e7eb;
            font-style: italic;
            color: #6b7280;
            font-size: 14px;
        }
        .unsubscribe-notice {
            font-size: 12px;
            color: #9ca3af;
            margin-top: 16px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <div class="announcement-badge">Important Announcement</div>
            <div class="logo">
                <i class="fa-solid fa-scissors text-white text-2xl"></i>
                <span>TailorOnDesk</span>
            </div>
            <h1 class="title">{{ $subject ?? 'Important Update' }}</h1>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="greeting">
                Hello {{ $owner->name }}! 👋
            </div>
            
            <p>
                We have an important announcement for your shop <span class="shop-name">{{ $shop->name }}</span>.
            </p>

            <div class="announcement-content">
                {!! nl2br(e($content)) !!}
            </div>

            <div class="admin-signature">
                Best regards,<br>
                The TailorOnDesk Team
                @if($admin->name)
                    <br><em>{{ $admin->name }}</em>
                @endif
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p class="footer-text">
                © {{ date('Y') }} TailorOnDesk. All rights reserved.<br>
                Streamlining tailor shop management, one stitch at a time.
            </p>
            <div class="unsubscribe-notice">
                This is an important announcement from TailorOnDesk. 
                You are receiving this because you are an active shop owner.
            </div>
        </div>
    </div>
</body>
</html>