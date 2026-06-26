<?php

namespace App\Notifications;

use App\Models\Listing;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ListingApproved extends Notification
{
    use Queueable;

    public function __construct(public Listing $listing) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('✅ Your listing has been approved — NyumbaHub')
            ->greeting('Great news, ' . $notifiable->first_name . '!')
            ->line('Your property listing **"' . $this->listing->title . '"** has been **approved** and is now live on NyumbaHub.')
            ->line('Prospective tenants and buyers can now discover and book viewings for your property.')
            ->action('View Live Listing', url(route('listings.show', $this->listing->slug)))
            ->line('Thank you for listing with NyumbaHub. We wish you a quick and successful transaction!')
            ->salutation('The NyumbaHub Team');
    }
}
