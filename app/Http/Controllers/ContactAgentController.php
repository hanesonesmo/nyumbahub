<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Notifications\AgentMessageReceived;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ContactAgentController extends Controller
{
    public function send(Request $request)
    {
        $validated = $request->validate([
            'appointment_id' => ['required', 'integer'],
            'message'        => ['required', 'string', 'min:10', 'max:1000'],
        ]);

        // Verify the appointment belongs to the authenticated user
        $appointment = Appointment::with(['listing.agent', 'user'])
            ->where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'confirmed'])
            ->findOrFail($validated['appointment_id']);

        $agent = $appointment->listing->agent;

        if (!$agent) {
            return back()->withErrors(['message' => 'Agent not found for this listing.']);
        }

        $sender = Auth::user();

        try {
            $agent->notify(new AgentMessageReceived(
                appointment: $appointment,
                senderName:  $sender->first_name . ' ' . $sender->last_name,
                senderEmail: $sender->email,
                message:     $validated['message']
            ));
        } catch (\Exception $e) {
            Log::error('AgentMessageReceived notification failed: ' . $e->getMessage());
            return back()->with('error', __('Message could not be sent. Please try again.'));
        }

        return back()
            ->with('success', '✅ Message sent to ' . $agent->first_name . ' successfully!')
            ->with('contact_appointment_id', $appointment->id);
    }
}
