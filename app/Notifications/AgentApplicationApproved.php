<?php

namespace App\Notifications;

use App\Models\AgentApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AgentApplicationApproved extends Notification
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
            ->subject('🎉 Congratulations! Your Agent Application is Approved — NyumbaHub')
            ->greeting("Hello {$notifiable->first_name}!")
            ->line('We are thrilled to inform you that your Agent Application has been **approved**.')
            ->line('You are now a **Verified Agent** on NyumbaHub. You can immediately start listing properties, managing appointments, and growing your business on our platform.')
            ->action('Go to Agent Dashboard', url(route('agent.dashboard')))
            ->line('**What\'s next?**')
            ->line('→ Submit your first property listing from the Agent Dashboard')
            ->line('→ Listings are reviewed and published within 24 hours')
            ->line('→ Respond to booking requests from tenants and buyers')
            ->line('Welcome to the NyumbaHub Agent community!')
            ->salutation('The NyumbaHub Team');
    }
}
