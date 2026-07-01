<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class ReviewController extends Controller
{
    /**
     * Display the user's reviews dashboard.
     */
    public function myReviews()
    {
        $user = auth()->user();
        
        $reviews = Review::where('user_id', $user->id)
            ->with(['agent', 'listing'])
            ->latest()
            ->get();

        // Find completed appointments without reviews
        $pendingAppointments = Appointment::where('user_id', $user->id)
            ->where('status', 'completed')
            ->doesntHave('review')
            ->with(['listing', 'listing.agent'])
            ->get();

        return view('reviews.my-reviews', compact('reviews', 'pendingAppointments'));
    }

    /**
     * Show the form for creating a new review.
     */
    public function create(Appointment $appointment)
    {
        Gate::authorize('create', [Review::class, $appointment]);
        
        // Ensure the appointment has a listing and agent
        $appointment->load(['listing', 'listing.agent']);

        return view('reviews.create', compact('appointment'));
    }

    /**
     * Store a newly created review in storage.
     */
    public function store(Request $request, Appointment $appointment)
    {
        Gate::authorize('create', [Review::class, $appointment]);

        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'review_title' => ['nullable', 'string', 'max:100'],
            'review_text' => ['required', 'string', 'min:10', 'max:1000'],
        ]);

        $appointment->load('listing');

        $review = Review::create([
            'appointment_id' => $appointment->id,
            'listing_id' => $appointment->listing_id,
            'agent_id' => $appointment->listing->user_id, // Agent who owns the listing
            'user_id' => auth()->id(),
            'rating' => $validated['rating'],
            'review_title' => $validated['review_title'],
            'review_text' => $validated['review_text'],
            'status' => 'approved', // Auto-approved by default, can be moderated later
        ]);

        // Send Notification to Agent
        if ($review->agent) {
            $review->agent->notify(new \App\Notifications\ReviewSubmittedNotification($review));
        }

        return redirect()->route('reviews.my')->with('success', 'Your review has been submitted successfully.');
    }

    /**
     * Show the form for editing the specified review.
     */
    public function edit(Review $review)
    {
        Gate::authorize('update', $review);
        
        $review->load(['listing', 'agent']);

        return view('reviews.edit', compact('review'));
    }

    /**
     * Update the specified review in storage.
     */
    public function update(Request $request, Review $review)
    {
        Gate::authorize('update', $review);

        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'review_title' => ['nullable', 'string', 'max:100'],
            'review_text' => ['required', 'string', 'min:10', 'max:1000'],
        ]);

        $review->update($validated);

        return redirect()->route('reviews.my')->with('success', 'Your review has been updated.');
    }

    /**
     * Remove the specified review from storage.
     */
    public function destroy(Review $review)
    {
        Gate::authorize('delete', $review);

        $review->delete();

        return redirect()->route('reviews.my')->with('success', 'Your review has been deleted.');
    }
}
