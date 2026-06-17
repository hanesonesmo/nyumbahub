<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function confirm($id)
    {
        $appointment = Appointment::whereHas('listing', function($q) {
            $q->where('user_id', Auth::id());
        })->findOrFail($id);

        $appointment->update(['status' => 'confirmed']);
        return back()->with('success', 'Appointment confirmed.');
    }

    public function cancel($id)
    {
        $appointment = Appointment::whereHas('listing', function($q) {
            $q->where('user_id', Auth::id());
        })->findOrFail($id);

        $appointment->update(['status' => 'cancelled']);
        return back()->with('success', 'Appointment cancelled.');
    }
}
