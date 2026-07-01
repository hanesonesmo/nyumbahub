<?php

namespace App\Policies;

use App\Models\Appointment;
use App\Models\Review;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ReviewPolicy
{
    /**
     * Determine whether the user can create a review for the given appointment.
     */
    public function create(User $user, Appointment $appointment): Response
    {
        if ($appointment->user_id !== $user->id) {
            return Response::deny('You do not own this appointment.');
        }

        if ($appointment->status !== 'completed') {
            return Response::deny('You can only review completed viewings.');
        }

        if ($appointment->review()->exists()) {
            return Response::deny('You have already submitted a review for this viewing.');
        }

        return Response::allow();
    }

    /**
     * Determine whether the user can update the review.
     */
    public function update(User $user, Review $review): Response
    {
        return $user->id === $review->user_id
            ? Response::allow()
            : Response::deny('You do not own this review.');
    }

    /**
     * Determine whether the user can delete the review.
     */
    public function delete(User $user, Review $review): Response
    {
        // Only if it doesn't have an agent response yet? The prompt says "Delete their review before it receives responses if business rules allow."
        if ($review->agent_response) {
            return Response::deny('You cannot delete a review after the agent has responded.');
        }

        return $user->id === $review->user_id
            ? Response::allow()
            : Response::deny('You do not own this review.');
    }

    /**
     * Determine whether the agent can respond to the review.
     */
    public function respond(User $user, Review $review): Response
    {
        return $user->id === $review->agent_id
            ? Response::allow()
            : Response::deny('You can only respond to reviews left on your profile.');
    }
}
