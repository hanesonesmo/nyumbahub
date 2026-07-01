<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ReviewController extends Controller
{
    /**
     * Store the agent's official response to a review.
     */
    public function respond(Request $request, Review $review)
    {
        Gate::authorize('respond', $review);

        $validated = $request->validate([
            'agent_response' => ['required', 'string', 'max:1000'],
        ]);

        $review->update([
            'agent_response' => $validated['agent_response'],
        ]);

        // Notify the user that the agent has responded
        if ($review->user) {
            $review->user->notify(new \App\Notifications\AgentResponseReceivedNotification($review));
        }

        return back()->with('success', 'Your response has been saved.');
    }
}
