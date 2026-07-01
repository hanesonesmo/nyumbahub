<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\FavoriteController;
use Illuminate\Support\Facades\Route;

// ── Public routes — no login required ──
Route::get('/listings', [ListingController::class, 'index'])->name('listings.index');
Route::get('/listings/{listing:slug}', [ListingController::class, 'show'])->name('listings.show');

// ── Guest only ──
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // Password reset
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

    // Google Auth
    Route::get('/auth/google', [\App\Http\Controllers\Auth\GoogleController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/auth/google/callback', [\App\Http\Controllers\Auth\GoogleController::class, 'handleGoogleCallback'])->name('auth.google.callback');
});

// ── Email Verification ──
Route::middleware(['auth'])->group(function () {
    Route::get('/email/verify', [AuthController::class, 'showVerifyEmail'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])->middleware(['signed'])->name('verification.verify');
    Route::post('/email/verification-notification', [AuthController::class, 'resendVerificationEmail'])->middleware(['throttle:6,1'])->name('verification.send');
});

// ── Authenticated users ──
Route::middleware(['auth', 'sessionTimeout'])->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Profile
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/profile', [App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');

    // ── Unified User Dashboard ──
    Route::get('/dashboard', function () {
        $user = auth()->user();

        $appointments = App\Models\Appointment::with(['listing.images', 'listing.agent'])
            ->where('user_id', $user->id)
            ->latest()->take(5)->get();

        $totalAppointments     = App\Models\Appointment::where('user_id', $user->id)->count();
        $pendingAppointments   = App\Models\Appointment::where('user_id', $user->id)->where('status', 'pending')->count();
        $confirmedAppointments = App\Models\Appointment::where('user_id', $user->id)->where('status', 'confirmed')->count();

        $recentListings = App\Models\Listing::with('images')->active()->latest()->take(6)->get();

        // Guard: table may not exist yet if migration hasn't run
        $application = null;
        if (\Illuminate\Support\Facades\Schema::hasTable('agent_applications')) {
            $application = App\Models\AgentApplication::where('user_id', $user->id)->latest()->first();
        }

        return view('user.dashboard', compact(
            'appointments',
            'totalAppointments',
            'pendingAppointments',
            'confirmedAppointments',
            'recentListings',
            'application'
        ));
    })->name('user.dashboard');

    // Legacy redirects — old URLs still work
    Route::get('/tenant/dashboard', fn() => redirect()->route('user.dashboard'))->name('tenant.dashboard');
    Route::get('/buyer/dashboard',  fn() => redirect()->route('user.dashboard'))->name('buyer.dashboard');

    // Agent dashboard
    Route::get('/agent/dashboard', function () {
        $listings = App\Models\Listing::with('images')
            ->where('user_id', auth()->id())
            ->latest()->take(5)->get();

        $appointments = App\Models\Appointment::with('listing', 'user')
            ->whereHas('listing', fn($q) => $q->where('user_id', auth()->id()))
            ->where('status', 'pending')
            ->latest()->take(5)->get();

        $totalListings       = App\Models\Listing::where('user_id', auth()->id())->count();
        $activeListings      = App\Models\Listing::where('user_id', auth()->id())->where('status', 'active')->count();
        $pendingListings     = App\Models\Listing::where('user_id', auth()->id())->where('status', 'pending')->count();
        $rejectedListings    = App\Models\Listing::where('user_id', auth()->id())->where('status', 'rejected')->count();
        $totalAppointments   = App\Models\Appointment::whereHas('listing', fn($q) => $q->where('user_id', auth()->id()))->count();
        $pendingAppointments = App\Models\Appointment::whereHas('listing', fn($q) => $q->where('user_id', auth()->id()))->where('status', 'pending')->count();

        // Chart Data: Bookings over the last 6 months
        $months = collect(range(5, 0))->map(function($i) {
            return now()->subMonths($i)->format('M');
        })->values()->toArray();

        $bookingCounts = [];
        foreach (range(5, 0) as $i) {
            $monthStart = now()->subMonths($i)->startOfMonth();
            $monthEnd = now()->subMonths($i)->endOfMonth();

            $bookingCounts[] = App\Models\Appointment::whereHas('listing', fn($q) => $q->where('user_id', auth()->id()))
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->count();
        }

        $chartData = [
            'months' => $months,
            'bookings' => $bookingCounts,
        ];

        return view('agent.dashboard', compact(
            'listings', 'appointments',
            'totalListings', 'activeListings', 'pendingListings', 'rejectedListings',
            'totalAppointments', 'pendingAppointments', 'chartData'
        ));
    })->name('agent.dashboard');

    // Appointments (index only)
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::post('/appointments/{id}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');

    // ── Verified Users Only ──
    Route::middleware(['verified'])->group(function () {
        // Become an Agent
        Route::get('/user/become-agent',  [App\Http\Controllers\AgentApplicationController::class, 'show'])->name('become.agent');
        Route::post('/user/become-agent', [App\Http\Controllers\AgentApplicationController::class, 'store'])->name('become.agent.store');

        // Book Appointments
        Route::get('/listings/{id}/book', [AppointmentController::class, 'create'])->name('appointments.create');
        Route::post('/listings/{id}/book', [AppointmentController::class, 'store'])->name('appointments.store');

        // Direct message to agent
        Route::post('/contact-agent', [App\Http\Controllers\ContactAgentController::class, 'send'])->name('contact.agent');

        // Favorites
        Route::get('/user/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
        Route::post('/listings/{listing:slug}/favorite', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
        Route::get('/listings/{listing:slug}/favorite/add', [FavoriteController::class, 'addFavoriteIntent'])->name('favorites.add_intent');
    });

});

// ── Agent Listing Management — agents only ──
Route::middleware(['auth', 'sessionTimeout', 'isAgent'])->prefix('agent')->name('agent.')->group(function () {
    Route::get('/listings', [App\Http\Controllers\Agent\ListingController::class, 'index'])->name('listings.index');
    Route::get('/listings/create', [App\Http\Controllers\Agent\ListingController::class, 'create'])->name('listings.create');
    Route::post('/listings', [App\Http\Controllers\Agent\ListingController::class, 'store'])->name('listings.store');
    Route::get('/listings/{id}/edit', [App\Http\Controllers\Agent\ListingController::class, 'edit'])->name('listings.edit');
    Route::put('/listings/{id}', [App\Http\Controllers\Agent\ListingController::class, 'update'])->name('listings.update');
    Route::delete('/listings/{id}', [App\Http\Controllers\Agent\ListingController::class, 'destroy'])->name('listings.destroy');
    Route::delete('/listings/images/{id}', [App\Http\Controllers\Agent\ListingController::class, 'deleteImage'])->name('listings.images.delete');
    Route::post('/listings/{id}/sold', [App\Http\Controllers\Agent\ListingController::class, 'markSold'])->name('listings.markSold');
    Route::post('/listings/{id}/rented', [App\Http\Controllers\Agent\ListingController::class, 'markRented'])->name('listings.markRented');

    // Agent appointment management
    Route::post('/appointments/{id}/confirm', [App\Http\Controllers\Agent\AppointmentController::class, 'confirm'])->name('appointments.confirm');
    Route::post('/appointments/{id}/cancel', [App\Http\Controllers\Agent\AppointmentController::class, 'cancel'])->name('appointments.cancel');
});
