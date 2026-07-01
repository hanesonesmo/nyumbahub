<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\LoginHistory;

class SuspiciousLoginNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $loginHistory;

    /**
     * Create a new notification instance.
     */
    public function __construct(LoginHistory $loginHistory)
    {
        $this->loginHistory = $loginHistory;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Security Alert: Unusual Login Detected')
                    ->greeting('Hello ' . $notifiable->first_name . ',')
                    ->line('We noticed a new login to your NyumbaHub account from an unrecognized device or IP address.')
                    ->line('**Device:** ' . ($this->loginHistory->device ?: 'Unknown') . ' / ' . ($this->loginHistory->platform ?: 'Unknown'))
                    ->line('**Browser:** ' . ($this->loginHistory->browser ?: 'Unknown'))
                    ->line('**IP Address:** ' . $this->loginHistory->ip_address)
                    ->line('**Time:** ' . $this->loginHistory->created_at->toDayDateTimeString())
                    ->line('If this was you, you can safely ignore this email.')
                    ->line('If you did not authorize this login, please change your password immediately and review your active sessions.')
                    ->action('Review Active Sessions', url('/my-security'))
                    ->line('Thank you for using NyumbaHub!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'login_history_id' => $this->loginHistory->id,
            'ip_address' => $this->loginHistory->ip_address,
        ];
    }
}
