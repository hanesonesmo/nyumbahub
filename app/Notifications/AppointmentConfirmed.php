<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppointmentConfirmed extends Notification
{
    use Queueable;

    public function __construct(public Appointment $appointment) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $agent   = $this->appointment->listing->agent;
        $listing = $this->appointment->listing;
        $date    = \Carbon\Carbon::parse($this->appointment->date)->format('l, d F Y');

        return (new MailMessage)
            ->subject('✅ Your viewing is confirmed — ' . $listing->title)
            ->greeting('Great news, ' . $notifiable->first_name . '!')
            ->line('Your property viewing has been **confirmed** by the agent. See you there!')
            ->line('---')
            ->line('**Property:** ' . $listing->title)
            ->line('**Location:** ' . $listing->location . ', Arusha')
            ->line('**Date:** ' . $date)
            ->line('**Time:** ' . $this->appointment->time)
            ->line('---')
            ->line('**Agent contact:**')
            ->line('Name: ' . ($agent->first_name ?? '') . ' ' . ($agent->last_name ?? ''))
            ->line('Email: ' . ($agent->email ?? ''))
            ->line('Phone: ' . ($agent->phone ?? 'Not provided'))
            ->when($agent->whatsapp ?? null, fn($msg) => $msg->line('WhatsApp: ' . $agent->whatsapp))
            ->action('View My Bookings', url(route('appointments.index')))
            ->line('Please arrive on time. If you need to cancel, you can do so from your bookings page.')
            ->salutation('NyumbaHub');
    }
}
