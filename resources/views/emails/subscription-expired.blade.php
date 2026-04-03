<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscription Expired - TailorOnDesk</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
        <h1 style="color: #dc3545; margin: 0; font-size: 24px;">⏰ Subscription Expired</h1>
    </div>

    <div style="background: #ffffff; padding: 20px; border: 1px solid #dee2e6; border-radius: 8px;">
        <p>Dear {{ $shopName }},</p>

        <p>Your <strong>{{ $planName }}</strong> subscription has expired. However, you are currently in a <strong>7-day grace period</strong> that ends on <strong>{{ $gracePeriodEnds }}</strong>.</p>

        <div style="background: #fff3cd; border: 1px solid #ffeaa7; padding: 15px; border-radius: 5px; margin: 20px 0;">
            <p style="margin: 0; font-weight: bold; color: #856404;">⚠️ Important: Grace Period Reminder</p>
            <p style="margin: 5px 0 0 0; color: #856404;">After the grace period ends, you will lose access to premium features including creating new orders, customers, and measurements.</p>
        </div>

        <h3 style="color: #495057; margin-bottom: 10px;">What you can still do during grace period:</h3>
        <ul style="color: #6c757d; margin-bottom: 20px;">
            <li>✅ View existing customers and their data</li>
            <li>✅ View existing orders and measurements</li>
            <li>✅ Access your dashboard</li>
            <li>❌ Cannot create new orders, customers, or measurements</li>
        </ul>

        <div style="text-align: center; margin: 25px 0;">
            <a href="{{ $renewalUrl }}" style="background: #dc3545; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block;">
                Renew Subscription Now
            </a>
        </div>

        <p>Don't worry - all your existing data is safe and will remain accessible once you renew your subscription.</p>

        <p>If you have any questions or need assistance with the renewal process, please contact our support team.</p>

        <p>Thank you for choosing TailorOnDesk!</p>

        <p style="margin-top: 20px; color: #6c757d; font-size: 14px;">
            Best regards,<br>
            <strong>TailorOnDesk Team</strong>
        </p>
    </div>

    <div style="text-align: center; margin-top: 20px; color: #6c757d; font-size: 12px;">
        <p>This is an automated notification from TailorOnDesk.</p>
        <p>Please do not reply to this email.</p>
    </div>
</body>
</html>