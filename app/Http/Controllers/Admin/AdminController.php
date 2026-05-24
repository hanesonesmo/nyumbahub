<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Listing;
use App\Models\User;

class AdminController extends Controller
{
    // ── Login ──
    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('admin')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid admin credentials.',
        ])->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }

    // ── Dashboard ──
    public function dashboard()
    {
        $stats = [
            'total_users'    => User::count(),
            'total_listings' => Listing::count(),
            'pending'        => Listing::where('status', 'pending')->count(),
            'active_agents'  => User::where('role', 'agent')->count(),
        ];

        $recentUsers    = User::latest()->take(5)->get();
        $recentListings = Listing::with('agent')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'recentListings'));
    }

    // ── Users ──
    public function users()
    {
        $users = User::latest()->paginate(20);
        return view('admin.users', compact('users'));
    }

    // ── Listings ──
    public function listings()
    {
        $listings = Listing::with('agent')->latest()->paginate(20);
        return view('admin.listings', compact('listings'));
    }

    public function approveListing($id)
    {
        $listing = Listing::findOrFail($id);
        $listing->update(['status' => 'active', 'rejection_reason' => null]);
        return back()->with('success', 'Listing approved successfully.');
    }

    public function rejectListing(Request $request, $id)
    {
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

    // ── Appointments ──
    public function appointments()
    {
        return view('admin.appointments');
    }
}
