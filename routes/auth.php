<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Route;

// ── Public routes — no login required ──
Route::get('/listings', [ListingController::class, 'index'])->name('listings.index');
Route::get('/listings/{id}', [ListingController::class, 'show'])->name('listings.show');

// ── Guest only ──
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // Profile
Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile');
Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
Route::put('/profile/password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password');

    // Password reset
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

// ── Authenticated users ──
Route::middleware(['auth', 'sessionTimeout'])->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Tenant dashboard
    Route::get('/tenant/dashboard', function () {
        $appointments = App\Models\Appointment::with('listing.images')
            ->where('user_id', auth()->id())
            ->latest()->take(5)->get();

        $totalAppointments     = App\Models\Appointment::where('user_id', auth()->id())->count();
        $pendingAppointments   = App\Models\Appointment::where('user_id', auth()->id())->where('status', 'pending')->count();
        $confirmedAppointments = App\Models\Appointment::where('user_id', auth()->id())->where('status', 'confirmed')->count();

        $recentListings = App\Models\Listing::with('images')->active()->latest()->take(5)->get();

        return view('tenant.dashboard', compact(
            'appointments',
            'totalAppointments',
            'pendingAppointments',
            'confirmedAppointments',
            'recentListings'
        ));
    })->name('tenant.dashboard');

    // Buyer dashboard
    Route::get('/buyer/dashboard', function () {
        $appointments = App\Models\Appointment::with('listing.images')
            ->where('user_id', auth()->id())
            ->latest()->take(5)->get();

        $totalAppointments     = App\Models\Appointment::where('user_id', auth()->id())->count();
        $pendingAppointments   = App\Models\Appointment::where('user_id', auth()->id())->where('status', 'pending')->count();
        $confirmedAppointments = App\Models\Appointment::where('user_id', auth()->id())->where('status', 'confirmed')->count();

        $recentListings = App\Models\Listing::with('images')->active()->where('type', 'sale')->latest()->take(5)->get();

        return view('buyer.dashboard', compact(
            'appointments',
            'totalAppointments',
            'pendingAppointments',
            'confirmedAppointments',
            'recentListings'
        ));
    })->name('buyer.dashboard');

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
        $totalAppointments   = App\Models\Appointment::whereHas('listing', fn($q) => $q->where('user_id', auth()->id()))->count();
        $pendingAppointments = App\Models\Appointment::whereHas('listing', fn($q) => $q->where('user_id', auth()->id()))->where('status', 'pending')->count();

        return view('agent.dashboard', compact(
            'listings', 'appointments',
            'totalListings', 'activeListings',
            'totalAppointments', 'pendingAppointments'
        ));
    })->name('agent.dashboard');

    // Appointments
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/listings/{id}/book', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/listings/{id}/book', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::post('/appointments/{id}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');

});

// ── Agent Listing Management ──
Route::middleware(['auth', 'sessionTimeout'])->prefix('agent')->name('agent.')->group(function () {
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
