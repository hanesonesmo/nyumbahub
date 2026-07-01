<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AgentProfile;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgentProfileController extends Controller
{
    /**
     * Show the public profile of an agent.
     */
    public function show($id)
    {
        if (!\Illuminate\Support\Facades\Schema::hasTable('agent_profiles')) {
            $agent = User::where('role', 'agent')->findOrFail($id);
            // Dynamically set relation to null to avoid view errors
            $agent->setRelation('agentProfile', null);
        } else {
            $agent = User::with('agentProfile')->where('role', 'agent')->findOrFail($id);
        }
        
        $listings = Listing::where('user_id', $agent->id)
            ->where('status', 'active')
            ->with('images')
            ->latest()
            ->paginate(6);

        $reviews = \App\Models\Review::with('user')
            ->where('agent_id', $agent->id)
            ->approved()
            ->latest()
            ->paginate(5, ['*'], 'reviews_page');

        return view('pages.agent-profile', compact('agent', 'listings', 'reviews'));
    }

    /**
     * Show the edit profile form for the logged-in agent.
     */
    public function edit()
    {
        $user = Auth::user();
        if ($user->role !== 'agent') abort(403);

        if (!\Illuminate\Support\Facades\Schema::hasTable('agent_profiles')) {
            return redirect()->route('agent.dashboard')->with('error', __('Agent profiles are temporarily unavailable. Please ask an admin to run migrations.'));
        }

        // Ensure a profile exists
        $profile = $user->agentProfile()->firstOrCreate([]);

        return view('agent.profile', compact('user', 'profile'));
    }

    /**
     * Update the agent profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        if ($user->role !== 'agent') abort(403);

        if (!\Illuminate\Support\Facades\Schema::hasTable('agent_profiles')) {
            return redirect()->route('agent.dashboard')->with('error', __('Agent profiles are temporarily unavailable.'));
        }

        $validated = $request->validate([
            'agency_name' => ['nullable', 'string', 'max:150'],
            'bio' => ['nullable', 'string', 'max:2000'],
            'years_experience' => ['required', 'integer', 'min:0', 'max:50'],
            'service_regions' => ['nullable', 'string', 'max:255'],
            'profile_photo' => ['nullable', 'image', 'max:3072'],
        ]);

        $profile = $user->agentProfile()->firstOrCreate([]);

        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('agent_profiles', 'public');
            $profile->profile_photo = $path;
        }

        $profile->agency_name = $validated['agency_name'];
        $profile->bio = $validated['bio'];
        $profile->years_experience = $validated['years_experience'];
        $profile->service_regions = $validated['service_regions'];
        $profile->save();

        \App\Services\AuditService::log('Updated', 'Agent Profiles', "Agent updated their profile");

        return back()->with('success', __('Profile updated successfully.'));
    }
}
