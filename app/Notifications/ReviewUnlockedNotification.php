<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReviewUnlockedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $appointment;

    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $url = route('reviews.create', $this->appointment->id);
        
        return (new MailMessage)
            ->subject('How was your viewing experience? Leave a Review')
            ->greeting('Hello ' . $notifiable->first_name . ',')
            ->line('Your property viewing for "' . $this->appointment->listing->title . '" has been marked as completed by the agent.')
            ->line('We value your feedback! By sharing your experience, you help maintain a trustworthy community on NyumbaHub.')
            ->action('Leave a Review', $url)
            ->line('Thank you for using NyumbaHub!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'appointment_id' => $this->appointment->id,
            'message' => 'Your viewing for ' . $this->appointment->listing->title . ' is complete. You can now leave a review.',
            'action_url' => route('reviews.create', $this->appointment->id),
        ];
    }
}
