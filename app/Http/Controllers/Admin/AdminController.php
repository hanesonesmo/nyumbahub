<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AgentApplication;
use App\Models\Listing;
use App\Models\User;
use App\Notifications\AgentApplicationApproved;
use App\Notifications\AgentApplicationRejected;
use App\Notifications\ListingApproved;
use App\Notifications\ListingRejected;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function showLogin()
    {
        if (session('admin_logged_in')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        Log::info('Admin login attempt', ['email' => $request->email]);

        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        $admin = Admin::where('email', $request->email)->first();

        Log::info('Admin found', ['found' => $admin ? 'yes' : 'no']);

        if ($admin && Hash::check($request->password, $admin->password)) {
            Log::info('Password matched — logging in');
            session(['admin_logged_in' => true, 'admin_id' => $admin->id, 'admin_name' => $admin->name]);
            return redirect()->route('admin.dashboard');
        }

        Log::info('Password did not match');

        return back()->withErrors([
            'email' => 'Invalid admin credentials.',
        ])->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        session()->forget(['admin_logged_in', 'admin_id', 'admin_name']);
        return redirect()->route('admin.login');
    }

   public function dashboard()
{
    $stats = [
        'total_users'    => User::count(),
        'total_listings' => Listing::count(),
        'pending'        => Listing::where('status', 'pending')->count(),
        'active_agents'  => User::where('role', 'agent')->count(),
    ];

    $pendingApplications = AgentApplication::with('user')
        ->where('status', 'pending')
        ->latest()
        ->take(5)
        ->get();

    $pendingListings = Listing::with(['agent', 'images'])
        ->where('status', 'pending')
        ->latest()
        ->take(5)
        ->get();

    return view('admin.dashboard', compact('stats', 'pendingApplications', 'pendingListings'));
}

    public function users()
    {
        $users = User::latest()->paginate(20);
        return view('admin.users', compact('users'));
    }

   public function listings(Request $request)
{
    $query = Listing::with(['agent', 'images'])->latest();

    if ($request->status) {
        $query->where('status', $request->status);
    }
    if ($request->type) {
        $query->where('type', $request->type);
    }
    if ($request->search) {
        $query->where(function($q) use ($request) {
            $q->where('title', 'like', '%' . $request->search . '%')
              ->orWhere('location', 'like', '%' . $request->search . '%');
        });
    }

    $listings     = $query->paginate(15);
    $pendingCount = Listing::where('status', 'pending')->count();

    return view('admin.listings', compact('listings', 'pendingCount'));
}

    public function approveListing($id)
    {
        $listing = Listing::with('agent')->findOrFail($id);
        $listing->update(['status' => 'active', 'rejection_reason' => null]);

        // Notify agent by email
        if ($listing->agent) {
            try {
                $listing->agent->notify(new ListingApproved($listing));
            } catch (\Exception $e) {
                Log::error('ListingApproved notification failed: ' . $e->getMessage());
            }
        }

        return back()->with('success', 'Listing approved and agent notified.');
    }

    public function rejectListing(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => ['required', 'string', 'max:500'],
        ]);
        $listing = Listing::with('agent')->findOrFail($id);
        $listing->update([
            'status'           => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        // Notify agent by email
        if ($listing->agent) {
            try {
                $listing->agent->notify(new ListingRejected($listing, $request->rejection_reason));
            } catch (\Exception $e) {
                Log::error('ListingRejected notification failed: ' . $e->getMessage());
            }
        }

        return back()->with('success', 'Listing rejected and agent notified.');
    }

   public function appointments()
{
    $appointments = \App\Models\Appointment::with(['user', 'listing'])
        ->latest()
        ->paginate(20);

    $pending   = \App\Models\Appointment::where('status', 'pending')->count();
    $confirmed = \App\Models\Appointment::where('status', 'confirmed')->count();

    return view('admin.appointments', compact('appointments', 'pending', 'confirmed'));
}

// ── Agent Applications ──

public function agentApplications()
{
    $applications = AgentApplication::with('user')
        ->latest()
        ->paginate(20);

    $pending  = AgentApplication::where('status', 'pending')->count();
    $approved = AgentApplication::where('status', 'approved')->count();
    $rejected = AgentApplication::where('status', 'rejected')->count();

    return view('admin.agent-applications', compact('applications', 'pending', 'approved', 'rejected'));
}

public function approveApplication(Request $request, $id)
{
    $application = AgentApplication::with('user')->findOrFail($id);

    $application->update([
        'status'      => 'approved',
        'admin_notes' => $request->admin_notes ?? null,
        'reviewed_at' => now(),
    ]);

    // Promote user to agent
    $application->user->update(['role' => 'agent']);

    // Notify user
    try {
        $application->user->notify(new AgentApplicationApproved($application));
    } catch (\Exception $e) {
        Log::error('AgentApplicationApproved notification failed: ' . $e->getMessage());
    }

    return back()->with('success', "✅ Application approved. {$application->full_name} is now a verified Agent.");
}

public function rejectApplication(Request $request, $id)
{
    $request->validate([
        'admin_notes' => ['required', 'string', 'min:10', 'max:1000'],
    ]);

    $application = AgentApplication::with('user')->findOrFail($id);

    $application->update([
        'status'      => 'rejected',
        'admin_notes' => $request->admin_notes,
        'reviewed_at' => now(),
    ]);

    // Notify user
    try {
        $application->user->notify(new AgentApplicationRejected($application));
    } catch (\Exception $e) {
        Log::error('AgentApplicationRejected notification failed: ' . $e->getMessage());
    }

    return back()->with('success', "Application rejected. {$application->full_name} has been notified.");
}
}
