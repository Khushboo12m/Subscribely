✅ Laravel Scheduler + Cron Job Setup Guide

This documentation explains how to run Laravel’s scheduled tasks automatically using Cron, specifically to automate subscription renewal reminder emails.

------------------------------------------------------------

Step 1 — Add Scheduled Command in Kernel

File: app/Console/Kernel.php

protected function schedule(\Illuminate\Console\Scheduling\Schedule $schedule)
{
    $schedule->command('subscriptions:send-reminders')->daily();
}

------------------------------------------------------------

Step 2 — Email Configuration (Optional for testing)

Update .env:

MAIL_MAILER=log

Emails will be logged inside:
storage/logs/laravel.log

------------------------------------------------------------

Step 3 — Configure Cron Job (Linux)

Open crontab:

crontab -e

Choose the editor → select nano (option 1)

Then add this line:

* * * * * cd /opt/lampp/htdocs/Subscribely && php artisan schedule:run >> /dev/null 2>&1

Runs every minute (ideal for development/testing)

------------------------------------------------------------

Cron Command Breakdown

* * * * *  → Run every minute
cd /opt/lampp/htdocs/Subscribely → Go to Laravel project directory
php artisan schedule:run → Execute Laravel scheduler
>> /dev/null 2>&1 → Hide output & errors

Cron runs every minute → Laravel checks if tasks are due → Executes them ✅

------------------------------------------------------------

Step 4 — Restart Cron Service

sudo service cron restart

------------------------------------------------------------

Step 5 — Verify Cron Logs

grep CRON /var/log/syslog | tail -n 10

You should see a line like:

(xyz) CMD (cd /opt/lampp/htdocs/Subscribely && php artisan schedule:run >> /dev/null 2>&1)

------------------------------------------------------------

Final Result ✅

✔ Scheduler command added  
✔ Cron job configured  
✔ Fully automated renewal reminders  

🎉 Your Laravel app now sends renewal notification emails automatically!

------------------------------------------------------------

Notes 📌

For production, consider running at a fixed time like midnight:
0 0 * * * cd /opt/lampp/htdocs/Subscribely && php artisan schedule:run >> /dev/null 2>&1

Ensure your server time is correct.
If using a hosting provider, configure cron from the hosting control panel.

------------------------------------------------------------

Completed ✅
