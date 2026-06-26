<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppointmentBooked extends Notification
{
    use Queueable;

    public function __construct(public Appointment $appointment) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $tenant  = $this->appointment->user;
        $listing = $this->appointment->listing;
        $date    = \Carbon\Carbon::parse($this->appointment->date)->format('l, d F Y');

        return (new MailMessage)
            ->subject('📅 New viewing request for "' . $listing->title . '"')
            ->greeting('Hello, ' . $notifiable->first_name . '!')
            ->line('A tenant has requested a property viewing. Please confirm or decline from your dashboard.')
            ->line('---')
            ->line('**Property:** ' . $listing->title)
            ->line('**Date:** ' . $date)
            ->line('**Time:** ' . $this->appointment->time)
            ->line('---')
            ->line('**Tenant details:**')
            ->line('Name: ' . $tenant->first_name . ' ' . $tenant->last_name)
            ->line('Email: ' . $tenant->email)
            ->line('Phone: ' . ($tenant->phone ?? 'Not provided'))
            ->when($this->appointment->message, fn($msg) => $msg->line('Message: "' . $this->appointment->message . '"'))
            ->action('Manage Appointments', url(route('agent.dashboard')))
            ->salutation('NyumbaHub');
    }
}
