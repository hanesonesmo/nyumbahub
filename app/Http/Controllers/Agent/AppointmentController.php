<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Notifications\AppointmentConfirmed;
use App\Notifications\AppointmentCancelledByAgent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AppointmentController extends Controller
{
    public function confirm($id)
    {
        $appointment = Appointment::with(['user', 'listing.agent'])
            ->whereHas('listing', function ($q) {
                $q->where('user_id', Auth::id());
            })->findOrFail($id);

        $appointment->update(['status' => 'confirmed']);

        // Notify the tenant
        try {
            $appointment->user->notify(new AppointmentConfirmed($appointment));
        } catch (\Exception $e) {
            Log::error('AppointmentConfirmed notification failed: ' . $e->getMessage());
        }

        return back()->with('success', __('Appointment confirmed and tenant notified.'));
    }

    public function cancel($id)
    {
        $appointment = Appointment::with(['user', 'listing'])
            ->whereHas('listing', function ($q) {
                $q->where('user_id', Auth::id());
            })->findOrFail($id);

        $appointment->update(['status' => 'cancelled']);

        // Notify the tenant
        try {
            $appointment->user->notify(new AppointmentCancelledByAgent($appointment));
        } catch (\Exception $e) {
            Log::error('AppointmentCancelledByAgent notification failed: ' . $e->getMessage());
        }

        return back()->with('success', __('Appointment cancelled and tenant notified.'));
    }

    public function complete($id)
    {
        $appointment = Appointment::with(['user', 'listing.agent'])
            ->whereHas('listing', function ($q) {
                $q->where('user_id', Auth::id());
            })->findOrFail($id);

        $appointment->update(['status' => 'completed']);

        // Notify the tenant to leave a review
        try {
            $appointment->user->notify(new \App\Notifications\ReviewUnlockedNotification($appointment));
        } catch (\Exception $e) {
            Log::error('ReviewUnlockedNotification failed: ' . $e->getMessage());
        }

        return back()->with('success', __('Appointment marked as completed and tenant invited to review.'));
    }
}
