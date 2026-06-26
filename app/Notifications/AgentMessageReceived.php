<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AgentMessageReceived extends Notification
{
    use Queueable;

    public function __construct(
        public Appointment $appointment,
        public string $senderName,
        public string $senderEmail,
        public string $message
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $listing = $this->appointment->listing;

        return (new MailMessage)
            ->subject('💬 New message from ' . $this->senderName . ' — NyumbaHub')
            ->greeting('Hello, ' . $notifiable->first_name . '!')
            ->line('You have received a message from a tenant regarding your listing.')
            ->line('---')
            ->line('**Property:** ' . $listing->title)
            ->line('**From:** ' . $this->senderName . ' (' . $this->senderEmail . ')')
            ->line('---')
            ->line('**Message:**')
            ->line('"' . $this->message . '"')
            ->line('---')
            ->line('Reply directly to this email to respond, or contact the tenant at: **' . $this->senderEmail . '**')
            ->action('View My Listings', url(route('agent.listings.index')))
            ->salutation('NyumbaHub');
    }

    public function replyTo(): string
    {
        return $this->senderEmail;
    }
}
