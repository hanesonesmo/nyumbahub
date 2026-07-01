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

        // If a standard user tries to log in as admin, log them out of the web guard
        // This prevents infinite redirect loops and ensures "Back to User Login" works cleanly.
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();
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

        $throttleKey = \Illuminate\Support\Str::transliterate(\Illuminate\Support\Str::lower($request->input('email')).'|'.$request->ip());

        if (\Illuminate\Support\Facades\RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = \Illuminate\Support\Facades\RateLimiter::availableIn($throttleKey);
            return back()->withInput($request->only('email'))->withErrors([
                'email' => __('Too many login attempts. Please try again in :seconds seconds.', ['seconds' => $seconds]),
            ]);
        }

        $admin = Admin::where('email', $request->email)->first();

        Log::info('Admin found', ['found' => $admin ? 'yes' : 'no']);

        if ($admin && Hash::check($request->password, $admin->password)) {
            Log::info('Password matched — logging in');
            \Illuminate\Support\Facades\RateLimiter::clear($throttleKey);
            session(['admin_logged_in' => true, 'admin_id' => $admin->id, 'admin_name' => $admin->name]);
            return redirect()->route('admin.dashboard');
        }

        Log::info('Password did not match');
        \Illuminate\Support\Facades\RateLimiter::hit($throttleKey, 60);

        return back()->withErrors([
            'email' => 'Invalid admin credentials.',
        ])->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        session()->forget(['admin_logged_in', 'admin_id', 'admin_name']);
        return redirect()->route('admin.login');
    }

    public function showForgotPassword()
    {
        return view('admin.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        \Illuminate\Support\Facades\Password::broker('admins')->sendResetLink(
            $request->only('email')
        );

        return back()->with(['status' => __('If that email address exists in our database, we will send you a password reset link.')]);
    }

    public function showResetPassword(Request $request, $token)
    {
        return view('admin.reset-password', ['token' => $token, 'email' => $request->email]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = \Illuminate\Support\Facades\Password::broker('admins')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();
            }
        );

        return $status === \Illuminate\Support\Facades\Password::PASSWORD_RESET
                    ? redirect()->route('admin.login')->with('status', __($status))
                    : back()->withErrors(['email' => __($status)]);
    }

    public function dashboard()
    {
        try {
            \Illuminate\Support\Facades\DB::table('migrations')->where('migration', 'like', '%subscription%')->delete();
            \Illuminate\Support\Facades\DB::table('migrations')->where('migration', 'like', '%payment_transactions%')->delete();
            \Illuminate\Support\Facades\DB::table('migrations')->where('migration', 'like', '%payments%')->delete();
            \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true, '--path' => 'database/migrations']);
        } catch (\Exception $e) {}

        $totalUsers = User::count();
        $totalListings = Listing::count();
        $totalAgents = User::where('role', 'agent')->count();
        $pendingAgents = AgentApplication::where('status', 'pending')->count();

        $pendingApplications = AgentApplication::with('user')
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        $pendingListings = Listing::with(['agent', 'images'])
            ->where('status', 'pending')
            ->latest('updated_at')
            ->take(5)
            ->get();

        // Chart Data (Last 6 months)
        $months = collect(range(5, 0))->map(function($i) {
            return now()->subMonths($i)->format('M');
        })->values()->toArray();

        // Users registered per month
        $userCounts = [];
        // Listings created per month
        $listingCounts = [];

        foreach (range(5, 0) as $i) {
            $monthStart = now()->subMonths($i)->startOfMonth();
            $monthEnd = now()->subMonths($i)->endOfMonth();

            $userCounts[] = User::whereBetween('created_at', [$monthStart, $monthEnd])->count();
            $listingCounts[] = Listing::whereBetween('created_at', [$monthStart, $monthEnd])->count();
        }

        $chartData = [
            'months' => $months,
            'users' => $userCounts,
            'listings' => $listingCounts,
        ];

        // Property Types Breakdown
        $propertyTypes = Listing::selectRaw('type, count(*) as count')->groupBy('type')->pluck('count', 'type')->toArray();
        $typesData = [
            'apartment' => $propertyTypes['apartment'] ?? 0,
            'house' => $propertyTypes['house'] ?? 0,
            'commercial' => $propertyTypes['commercial'] ?? 0,
            'land' => $propertyTypes['land'] ?? 0,
        ];

        return view('admin.dashboard', compact('totalUsers', 'totalListings', 'totalAgents', 'pendingAgents', 'pendingApplications', 'pendingListings', 'chartData', 'typesData'));
    }

    public function users()
    {
        $users = User::latest()->paginate(20);
        return view('admin.users', compact('users'));
    }

   public function listings(Request $request)
{
    $query = Listing::with(['agent', 'images'])->latest('updated_at');

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

        return back()->with('success', __('Listing approved and agent notified.'));
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

        return back()->with('success', __('Listing rejected and agent notified.'));
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

    return back()->with('success', __('✅ Application approved. {$application->full_name} is now a verified Agent.'));
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

    return back()->with('success', __('Application rejected. {$application->full_name} has been notified.'));
}

    public function auditLogs(Request $request)
    {
        if (!\Illuminate\Support\Facades\Schema::hasTable('audit_logs')) {
            $logs = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 20);
            $logs->setPath($request->url());
            return view('admin.audit-logs', compact('logs'))->with('warning', __('The audit_logs table has not been created yet. Please run the database migrations.'));
        }

        $query = \App\Models\AuditLog::with('user')->latest();

        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filter by action
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        // Search description
        if ($request->filled('search')) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }

        $logs = $query->paginate(20)->withQueryString();

        return view('admin.audit-logs', compact('logs'));
    }

    public function paymentSettings()
    {
        $settings = \App\Models\Setting::all()->pluck('value', 'key')->toArray();
        return view('admin.payment-settings', compact('settings'));
    }

    public function updatePaymentSettings(Request $request)
    {
        $request->validate([
            'reservation_fee_enabled' => 'nullable',
            'reservation_fee_amount' => 'required|numeric|min:0',
            'reservation_hours_validity' => 'required|integer|min:1',
            'currency' => 'required|string|size:3',
        ]);

        \App\Models\Setting::set('reservation_fee_enabled', $request->has('reservation_fee_enabled') ? '1' : '0', 'boolean');
        \App\Models\Setting::set('reservation_fee_amount', $request->reservation_fee_amount, 'integer');
        \App\Models\Setting::set('reservation_hours_validity', $request->reservation_hours_validity, 'integer');
        \App\Models\Setting::set('currency', strtoupper($request->currency), 'string');

        return back()->with('success', __('Payment settings updated successfully.'));
    }

    public function paymentTransactions()
    {
        $transactions = \App\Models\PaymentTransaction::with(['user', 'agent', 'listing'])->latest()->paginate(20);
        return view('admin.payment-transactions', compact('transactions'));
    }
}
