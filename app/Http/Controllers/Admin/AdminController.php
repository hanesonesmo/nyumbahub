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
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

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

    public function users()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $users = User::latest()->paginate(20);
        return view('admin.users', compact('users'));
    }

    public function listings(Request $request)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $query = Listing::with('agent')->latest();
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        $listings = $query->paginate(20);
        return view('admin.listings', compact('listings'));
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
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        return view('admin.appointments');
    }
}
