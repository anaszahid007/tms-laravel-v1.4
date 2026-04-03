<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to TailorOnDesk</title>
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
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            padding: 32px 24px;
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
            margin-bottom: 16px;
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
        .feature-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin: 24px 0;
        }
        .feature-card {
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 16px;
            text-align: center;
        }
        .feature-icon {
            font-size: 24px;
            margin-bottom: 8px;
            color: #4f46e5;
        }
        .feature-title {
            font-size: 14px;
            font-weight: 600;
            color: #374151;
            margin: 0 0 4px 0;
        }
        .feature-desc {
            font-size: 12px;
            color: #9ca3af;
            margin: 0;
        }
        .button-container {
            text-align: center;
            margin: 32px 0;
        }
        .dashboard-button {
            display: inline-block;
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: white;
            text-decoration: none;
            padding: 16px 32px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.3);
            transition: all 0.3s ease;
        }
        .dashboard-button:hover {
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
        .shop-name {
            font-weight: 600;
            color: #4f46e5;
        }
        .highlight-box {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border: 1px solid #f59e0b;
            border-radius: 8px;
            padding: 16px;
            margin: 16px 0;
            text-align: center;
        }
        .highlight-text {
            font-size: 14px;
            color: #92400e;
            margin: 0;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <div class="logo">
                <span class="logo-icon">🎉</span>
                <span>Welcome to TailorOnDesk</span>
            </div>
            <h1 class="title">Your Journey Starts Here!</h1>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="greeting">Welcome aboard, {{ $user->name }}! 🎊</div>
            
            <div class="message">
                Your email has been successfully verified and you're now part of <span class="shop-name">{{ $shopName }}</span>! 
                We're thrilled to help you streamline your tailor shop operations and take your business to the next level.
            </div>

            <div class="highlight-box">
                <p class="highlight-text">
                    🚀 You're all set! Your account is now active and ready to use.
                </p>
            </div>

            <div class="message">
                Here's what you can do right now:
            </div>

            <div class="feature-grid">
                <div class="feature-card">
                    <div class="feature-icon">👥</div>
                    <div class="feature-title">Add Customers</div>
                    <div class="feature-desc">Start building your customer database</div>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📏</div>
                    <div class="feature-title">Record Measurements</div>
                    <div class="feature-desc">Store precise measurements for each customer</div>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📝</div>
                    <div class="feature-title">Create Orders</div>
                    <div class="feature-desc">Manage orders from start to finish</div>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📊</div>
                    <div class="feature-title">Track Progress</div>
                    <div class="feature-desc">Monitor your business performance</div>
                </div>
            </div>

            <div class="button-container">
                <a href="{{ url('/dashboard') }}" class="dashboard-button">
                    Go to Dashboard
                </a>
            </div>

            <div class="message">
                Need help getting started? Our support team is here to assist you every step of the way. 
                Feel free to reach out if you have any questions or need guidance.
            </div>

            <div class="message">
                Thank you for choosing TailorOnDesk. We can't wait to see what you'll accomplish!
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p class="footer-text">
                © {{ date('Y') }} TailorOnDesk. All rights reserved.<br>
                Streamlining tailor shop management, one stitch at a time.<br>
                Need help? Contact us at support@tailorondesk.com
            </p>
        </div>
    </div>
</body>
</html>