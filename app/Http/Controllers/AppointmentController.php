<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Listing;
use App\Notifications\AppointmentBooked;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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

        $rules = [
            'date'    => ['required', 'date', 'after:today'],
            'time'    => ['required'],
            'message' => ['nullable', 'string', 'max:500'],
        ];

        $validated = $request->validate($rules);

        // Prevent duplicate appointments
        $exists = Appointment::where('user_id', Auth::id())
            ->where('listing_id', $listing->id)
            ->where('status', '!=', 'cancelled')
            ->exists();

        if ($exists) {
            return back()->withErrors([
                'date' => 'You already have an active appointment for this listing.',
            ])->withInput();
        }

        $appointment = Appointment::create([
            'user_id'    => Auth::id(),
            'listing_id' => $listing->id,
            'date'       => $validated['date'],
            'time'       => $validated['time'],
            'message'    => $validated['message'] ?? null,
            'status'     => 'pending',
        ]);

        if ($listing->agent) {
            try {
                $appointment->load('user', 'listing.agent');
                $listing->agent->notify(new AppointmentBooked($appointment));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('AppointmentBooked notification failed: ' . $e->getMessage());
            }
        }

        return redirect()->route('listings.show', $listing->slug)
            ->with('success', __('✅ Viewing booked successfully! The agent will confirm shortly. Check your bookings for updates.'));
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

        return back()->with('success', __('Appointment cancelled successfully.'));
    }
}
