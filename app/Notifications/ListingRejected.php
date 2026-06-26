<?php

namespace App\Notifications;

use App\Models\Listing;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ListingRejected extends Notification
{
    use Queueable;

    public function __construct(public Listing $listing, public string $reason) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('❌ Listing requires attention — NyumbaHub')
            ->greeting('Hello, ' . $notifiable->first_name . '.')
            ->line('Unfortunately, your listing **"' . $this->listing->title . '"** was **not approved** at this time.')
            ->line('**Reason given by our admin team:**')
            ->line('> ' . $this->reason)
            ->line('Please update your listing to address the feedback above and resubmit for approval.')
            ->action('Edit Your Listing', url(route('agent.listings.edit', $this->listing->id)))
            ->line('If you believe this decision was made in error, please contact our support team.')
            ->salutation('The NyumbaHub Team');
    }
}
