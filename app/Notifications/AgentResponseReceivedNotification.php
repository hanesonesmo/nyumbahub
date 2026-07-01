<?php

namespace App\Notifications;

use App\Models\Review;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AgentResponseReceivedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $review;

    public function __construct(Review $review)
    {
        $this->review = $review;
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $url = route('reviews.my');

        return (new MailMessage)
            ->subject('Agent Responded to Your Review - NyumbaHub')
            ->greeting('Hello ' . $notifiable->first_name . ',')
            ->line('The agent has officially responded to your review for "' . $this->review->listing->title . '".')
            ->action('View Response', $url)
            ->line('Thank you for being an active part of the NyumbaHub community!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'review_id' => $this->review->id,
            'message' => 'The agent has responded to your review for ' . $this->review->listing->title,
            'action_url' => route('reviews.my'),
        ];
    }
}
