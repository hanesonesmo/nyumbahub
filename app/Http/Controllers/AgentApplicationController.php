<?php

namespace App\Http\Controllers;

use App\Models\AgentApplication;
use App\Notifications\AgentApplicationApproved;
use App\Notifications\AgentApplicationRejected;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AgentApplicationController extends Controller
{
    /**
     * Show the Become an Agent page.
     * If user already has an application, shows its status instead of the form.
     */
    public function show()
    {
        $user = Auth::user();
        
        // Guard: table may not exist yet if migration hasn't run
        if (!\Illuminate\Support\Facades\Schema::hasTable('agent_applications')) {
            return redirect()->route('user.dashboard')
                ->with('error', 'The database migration for agent applications has not been run. Please visit /run-migrate first.');
        }

        $application = AgentApplication::where('user_id', $user->id)
            ->latest()
            ->first();

        return view('user.become-agent', compact('application'));
    }

    /**
     * Store a new agent application.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // Prevent agents from applying
        if ($user->role === 'agent') {
            return redirect()->route('agent.dashboard')
                ->with('info', 'You are already a verified agent.');
        }

        // Guard: table may not exist yet if migration hasn't run
        if (!\Illuminate\Support\Facades\Schema::hasTable('agent_applications')) {
            return redirect()->route('user.dashboard')
                ->with('error', 'The database migration for agent applications has not been run. Please visit /run-migrate first.');
        }

        // Block if there is an active pending application
        $existing = AgentApplication::where('user_id', $user->id)
            ->where('status', 'pending')
            ->first();

        if ($existing) {
            return redirect()->route('become.agent')
                ->with('info', 'Your application is already under review.');
        }

        $validated = $request->validate([
            'full_name'           => ['required', 'string', 'max:150'],
            'phone'               => ['required', 'string', 'max:20'],
            'email'               => ['required', 'email', 'max:150'],
            'nida_number'         => ['required', 'string', 'max:50'],
            'agency_name'         => ['nullable', 'string', 'max:150'],
            'years_experience'    => ['required', 'integer', 'min:0', 'max:50'],
            'bio'                 => ['required', 'string', 'min:50', 'max:2000'],
            'profile_photo'       => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:3072'],
            'supporting_document' => ['nullable', 'file', 'mimes:pdf,jpeg,jpg,png', 'max:5120'],
        ]);

        // Handle file uploads
        $photoPath    = null;
        $documentPath = null;

        if ($request->hasFile('profile_photo')) {
            $photoPath = $request->file('profile_photo')
                ->store('applications/photos', 'public');
        }

        if ($request->hasFile('supporting_document')) {
            $documentPath = $request->file('supporting_document')
                ->store('applications/documents', 'public');
        }

        AgentApplication::create([
            'user_id'              => $user->id,
            'full_name'            => $validated['full_name'],
            'phone'                => $validated['phone'],
            'email'                => $validated['email'],
            'nida_number'          => $validated['nida_number'],
            'agency_name'          => $validated['agency_name'] ?? null,
            'years_experience'     => $validated['years_experience'],
            'bio'                  => $validated['bio'],
            'profile_photo'        => $photoPath,
            'supporting_document'  => $documentPath,
            'status'               => 'pending',
        ]);

        return redirect()->route('become.agent')
            ->with('success', '✅ Application submitted! We\'ll review it within 24–48 hours and notify you by email.');
    }
}
