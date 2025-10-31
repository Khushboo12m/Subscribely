# 📧 Laravel Email Configuration — Complete Guide

## 🧭 Overview
This guide explains how to configure, test, and send emails in Laravel — including using Mailtrap, Mailpit, and the `log` mailer for testing.

---

## 📁 1️⃣ File: `.env`
Configure your mail settings here:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=reminder@subscribely.com
MAIL_FROM_NAME="Subscribely"
```

---

## ⚙️ 2️⃣ Supported Mail Drivers (Mailers)

| Mailer | Description | Example Usage |
|--------|--------------|----------------|
| **smtp** | Sends email using SMTP protocol (most common) | Gmail, Mailtrap, SendGrid |
| **sendmail** | Uses the system’s Sendmail program | For Linux servers |
| **mailgun** | Sends mail using Mailgun API | For high-volume apps |
| **postmark** | Sends mail using Postmark API | For transactional emails |
| **ses** | Uses AWS Simple Email Service | For production-scale apps |
| **log** | Writes emails to `storage/logs/laravel.log` | ✅ For local testing |
| **array** | Stores emails in an array (for testing) | Used in tests |
| **failover** | Tries multiple mailers in order | For redundancy |
| **mailpit** | Local email catcher (Mailpit/Mailhog) | Great for local dev |

---

## 🧪 3️⃣ Local Testing Options

### 🔹 a) Using `MAIL_MAILER=log`
- No real emails sent.
- Email contents logged to `storage/logs/laravel.log`.
- Perfect for development when no SMTP is available.

### 🔹 b) Using Mailtrap
- Fake SMTP inbox that catches emails (for preview).
- Steps:
  1. Create free account: [https://mailtrap.io](https://mailtrap.io)
  2. Copy SMTP credentials to `.env`
  3. Open inbox in Mailtrap to view all test mails.

### 🔹 c) Using Mailpit or Mailhog (local tools)
- Install [Mailpit](https://github.com/axllent/mailpit)
- Run Mailpit locally:  
  ```bash
  mailpit
  ```
- Access inbox at `http://localhost:8025`
- Set in `.env`:
  ```env
  MAIL_MAILER=smtp
  MAIL_HOST=127.0.0.1
  MAIL_PORT=1025
  ```

---

## 🏗️ 4️⃣ Create a Mailable Class

```bash
php artisan make:mail WelcomeUserMail
```

This creates:  
`app/Mail/WelcomeUserMail.php`

Example:

```php
namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Queueable;

class WelcomeUserMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject('Welcome to Subscribely!')
                    ->view('emails.welcome');
    }
}
```

---

## 🖼️ 5️⃣ Create the Email Blade View

📂 `resources/views/emails/welcome.blade.php`
```html
<!DOCTYPE html>
<html>
<body>
  <h2>Hi {{ $user->name }},</h2>
  <p>Welcome to Subscribely! We’re glad to have you on board.</p>
</body>
</html>
```

---

## 🚀 6️⃣ Sending an Email

Anywhere in your controller:
```php
use App\Mail\WelcomeUserMail;
use Illuminate\Support\Facades\Mail;

Mail::to('user@example.com')->send(new WelcomeUserMail($user));
```

---

## 🧰 7️⃣ Testing Your Mailable

In `routes/web.php`:
```php
use App\Mail\WelcomeUserMail;

Route::get('/test-mail', function () {
    $user = (object)['name' => 'Khushboo'];
    return new WelcomeUserMail($user);
});
```

Visit:  
👉 `http://127.0.0.1:8000/test-mail`

You’ll see the full rendered email template — no email is actually sent!

---

## 🧾 8️⃣ Queuing Emails (Optional)

To send emails in the background (faster response time):

```php
Mail::to($user->email)->queue(new WelcomeUserMail($user));
```

Set queue connection:
```env
QUEUE_CONNECTION=database
```
and run:
```bash
php artisan queue:work
```

---

## 🧹 9️⃣ Common Debugging Tips

| Issue | Fix |
|--------|------|
| `Connection could not be established` | Check `MAIL_HOST`, `MAIL_PORT`, or firewall. |
| Email not arriving | Try Mailtrap or check spam folder. |
| Nothing in logs | Set `MAIL_MAILER=log` and retry. |
| “Could not authenticate” | Wrong SMTP credentials. |

---

## 💡 10️⃣ Recommended Setup for Development

```env
MAIL_MAILER=log
# or
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
```

---

✅ **Now you can test, log, and send real emails confidently in any Laravel project!**
