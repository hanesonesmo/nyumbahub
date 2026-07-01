<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Store a new review.
     */
    public function store(Request $request, Appointment $appointment)
    {
        // Must be the user who booked the appointment
        if ($appointment->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Appointment must be completed
        if ($appointment->status !== 'completed') {
            return back()->with('error', __('You can only review an agent after a completed viewing.'));
        }

        // Must not have already reviewed this appointment
        if ($appointment->review()->exists()) {
            return back()->with('error', __('You have already submitted a review for this viewing.'));
        }

        $request->validate([
            'rating'  => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string', 'min:10', 'max:1000'],
        ]);

        Review::create([
            'user_id'        => Auth::id(),
            'agent_id'       => $appointment->listing->user_id,
            'appointment_id' => $appointment->id,
            'rating'         => $request->rating,
            'comment'        => $request->comment,
            'status'         => 'pending', // Requires admin approval
        ]);

        return redirect()->route('reviews.my')->with('success', __('Your review has been submitted and is pending admin approval.'));
    }

    public function myReviews()
    {
        $reviews = Review::where('user_id', Auth::id())->with(['agent', 'appointment.listing'])->latest()->paginate(10);
        return view('user.reviews', compact('reviews'));
    }

    public function create(Appointment $appointment)
    {
        if ($appointment->user_id !== Auth::id()) {
            abort(403);
        }
        if ($appointment->status !== 'completed') {
            return redirect()->route('user.appointments')->with('error', __('You can only review an agent after a completed viewing.'));
        }
        if ($appointment->review()->exists()) {
            return redirect()->route('user.appointments')->with('error', __('You have already submitted a review for this viewing.'));
        }

        return view('user.review-create', compact('appointment'));
    }

    public function edit(Review $review)
    {
        if ($review->user_id !== Auth::id()) {
            abort(403);
        }
        return view('user.review-edit', compact('review'));
    }

    public function update(Request $request, Review $review)
    {
        if ($review->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'rating'  => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string', 'min:10', 'max:1000'],
        ]);

        $review->update([
            'rating'  => $request->rating,
            'comment' => $request->comment,
            'status'  => 'pending', // Re-requires approval after edit
        ]);

        return redirect()->route('reviews.my')->with('success', __('Review updated and is pending approval.'));
    }

    public function destroy(Review $review)
    {
        if ($review->user_id !== Auth::id()) {
            abort(403);
        }
        $review->delete();
        return back()->with('success', __('Review deleted.'));
    }
}
