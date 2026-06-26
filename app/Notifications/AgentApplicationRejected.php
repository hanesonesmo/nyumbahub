<?php

namespace App\Notifications;

use App\Models\AgentApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AgentApplicationRejected extends Notification
{
    use Queueable;

    public function __construct(public AgentApplication $application) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your Agent Application Update — NyumbaHub')
            ->greeting("Hello {$notifiable->first_name},")
            ->line('Thank you for your interest in becoming a NyumbaHub Agent.')
            ->line('After careful review, we were unable to approve your application at this time.')
            ->line('**Reason from our review team:**')
            ->line('> ' . $this->application->admin_notes)
            ->line('You are welcome to address the feedback above and submit a new application from your dashboard.')
            ->action('Submit a New Application', url(route('become.agent')))
            ->line('If you believe this decision was made in error, please contact our support team.')
            ->salutation('The NyumbaHub Team');
    }
}
