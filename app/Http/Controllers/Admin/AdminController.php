<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Listing;
use App\Models\User;
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
        'total_users'   => \App\Models\User::count(),
        'total_listings'=> \App\Models\Listing::count(),
        'pending'       => \App\Models\Listing::where('status','pending')->count(),
        'active_agents' => \App\Models\User::where('role','agent')->count(),
    ];

    $recentUsers    = \App\Models\User::latest()->take(5)->get();
    $recentListings = \App\Models\Listing::with('images')->latest()->take(5)->get();

    return view('admin.dashboard', compact('stats', 'recentUsers', 'recentListings'));
}

    public function users()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $users = User::latest()->paginate(20);
        return view('admin.users', compact('users'));
    }

   public function listings(Request $request)
{
    $query = \App\Models\Listing::with(['agent', 'images'])->latest();

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
    $pendingCount = \App\Models\Listing::where('status', 'pending')->count();

    return view('admin.listings', compact('listings', 'pendingCount'));
}

    public function approveListing($id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $listing = Listing::findOrFail($id);
        $listing->update(['status' => 'active', 'rejection_reason' => null]);
        return back()->with('success', 'Listing approved successfully.');
    }

    public function rejectListing(Request $request, $id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $request->validate([
            'rejection_reason' => ['required', 'string', 'max:500'],
        ]);
        $listing = Listing::findOrFail($id);
        $listing->update([
            'status'           => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);
        return back()->with('success', 'Listing rejected.');
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
}
