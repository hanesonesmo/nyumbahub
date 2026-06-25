<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    // Show booking form
    public function create($listingId)
    {
        $listing = Listing::with(['agent', 'images'])
            ->active()
            ->findOrFail($listingId);

        return view('appointments.create', compact('listing'));
    }

    // Store new appointment
    public function store(Request $request, $listingId)
    {
        $listing = Listing::active()->findOrFail($listingId);

        $validated = $request->validate([
            'date'    => ['required', 'date', 'after:today'],
            'time'    => ['required'],
            'message' => ['nullable', 'string', 'max:500'],
        ]);

        // Prevent duplicate appointments
        $exists = Appointment::where('user_id', Auth::id())
            ->where('listing_id', $listing->id)
            ->where('status', '!=', 'cancelled')
            ->exists();

        if ($exists) {
            return back()->withErrors([
                'date' => 'You already have an active appointment for this listing.',
            ]);
        }

        Appointment::create([
            'user_id'    => Auth::id(),
            'listing_id' => $listing->id,
            'date'       => $validated['date'],
            'time'       => $validated['time'],
            'message'    => $validated['message'] ?? null,
            'status'     => 'pending',
        ]);

        return redirect()->route('listings.show', $listing->slug)
            ->with('success', '✅ Viewing booked successfully! The agent will confirm shortly. Check your bookings for updates.');
    }

    // List user's appointments
    public function index()
    {
        $appointments = Appointment::with(['listing.images', 'listing.agent'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('appointments.index', compact('appointments'));
    }

    // Cancel appointment (by user)
    public function cancel($id)
    {
        $appointment = Appointment::where('user_id', Auth::id())
            ->findOrFail($id);

        $appointment->update(['status' => 'cancelled']);

        return back()->with('success', 'Appointment cancelled successfully.');
    }
}
