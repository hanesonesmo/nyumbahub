<?php

namespace App\Notifications;

use App\Models\Review;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReviewSubmittedNotification extends Notification implements ShouldQueue
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
        $url = route('agent.profile.show', $this->review->agent_id) . '#reviews';

        return (new MailMessage)
            ->subject('New Review Received - NyumbaHub')
            ->greeting('Hello ' . $notifiable->first_name . ',')
            ->line('You have received a new ' . $this->review->rating . '-star review from ' . $this->review->user->first_name . ' for the property viewing of "' . $this->review->listing->title . '".')
            ->action('View Review', $url)
            ->line('You can respond to this review on your public profile.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'review_id' => $this->review->id,
            'message' => 'New ' . $this->review->rating . '-star review received for ' . $this->review->listing->title,
            'action_url' => route('agent.profile.show', $this->review->agent_id) . '#reviews',
        ];
    }
}
