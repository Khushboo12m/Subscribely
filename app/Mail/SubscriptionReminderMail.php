<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Subscription;

class SubscriptionReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subscription;

    public function __construct(Subscription $subscription)
    {
        $this->subscription = $subscription;
    }

    public function build()
    {
        return $this->subject('Upcoming Renewal Reminder - ' . $this->subscription->service_name)
                    ->view('emails.subscription_reminder');
    }
}