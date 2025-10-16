<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Subscription Renewal Reminder</title>
</head>
<body style="font-family: Arial, sans-serif; background: #f8f8f8; padding: 20px;">
    <div style="max-width: 600px; margin: auto; background: #ffffff; border-radius: 8px; padding: 20px;">
        <h2 style="color: #333;">Hi there,</h2>

        <p>This is a friendly reminder that your subscription for
            <strong>{{ $subscription->service_name }}</strong>
            is coming up for renewal.</p>

        <p><strong>Renewal Date:</strong> {{ \Carbon\Carbon::parse($subscription->next_renewal_date)->format('d M, Y') }}</p>

        <p>If you’ve already renewed, please ignore this message.</p>

        <p>Thank you for using our service!<br>
        <strong>— The Subscription Team</strong></p>
    </div>
</body>
</html>
