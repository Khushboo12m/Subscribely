<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Subscription;
use App\Mail\SubscriptionReminderMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendSubscriptionReminders extends Command
{
    protected $signature = 'subscriptions:send-reminders';
    protected $description = 'Send email reminders for upcoming subscription renewals';

    public function handle()
    {
        $today = Carbon::today();

        // Fetch subscriptions renewing within next 3 days
        $subscriptions = Subscription::whereDate('next_renewal_date', '>=', $today)
                                     ->whereDate('next_renewal_date', '<=', $today->copy()->addDays(3))
                                     ->get();

        foreach ($subscriptions as $sub) {
            if ($sub->notification_email) {
                Mail::to($sub->notification_email)->send(new SubscriptionReminderMail($sub));
                $this->info('Reminder sent for: ' . $sub->service_name);
            }
        }

        $this->info('All reminders checked.');
    }
}
