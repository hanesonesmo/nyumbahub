<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppointmentCancelledByAgent extends Notification
{
    use Queueable;

    public function __construct(public Appointment $appointment) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $listing = $this->appointment->listing;
        $date    = \Carbon\Carbon::parse($this->appointment->date)->format('l, d F Y');

        return (new MailMessage)
            ->subject('❌ Viewing cancelled — ' . $listing->title)
            ->greeting('Hello, ' . $notifiable->first_name . '.')
            ->line('Unfortunately, your property viewing appointment has been **cancelled by the agent**.')
            ->line('---')
            ->line('**Property:** ' . $listing->title)
            ->line('**Date was:** ' . $date . ' at ' . $this->appointment->time)
            ->line('---')
            ->line('You can browse other available listings and book a new viewing anytime.')
            ->action('Browse Listings', url(route('listings.index')))
            ->line('We apologise for any inconvenience caused.')
            ->salutation('NyumbaHub');
    }
}
