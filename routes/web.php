<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
// Contact form handled by ContactController (see below)

// Language Switcher Route
Route::get('lang/{locale}', [\App\Http\Controllers\LanguageController::class, 'switch'])->name('lang.switch');


Route::get('/', function () {
    $featuredListings = App\Models\Listing::with(['images', 'agent'])
        ->active()
        ->latest()
        ->take(6)
        ->get();
    return view('home', compact('featuredListings'));
})->name('home');

// Keep session alive ping
Route::post('/ping', function () {
    return response()->json(['status' => 'ok']);
})->middleware('auth')->name('ping');


require __DIR__."/auth.php";

Route::post('/contact', [App\Http\Controllers\ContactController::class, 'send'])->name('contact.send');
// Admin login — public (no auth needed)
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'login'])->name('admin.login.submit');
    
    // Admin Password Reset Routes
    Route::get('/forgot-password', [AdminController::class, 'showForgotPassword'])->name('admin.password.request');
    Route::post('/forgot-password', [AdminController::class, 'sendResetLinkEmail'])->name('admin.password.email');
    Route::get('/reset-password/{token}', [AdminController::class, 'showResetPassword'])->name('admin.password.reset');
    Route::post('/reset-password', [AdminController::class, 'resetPassword'])->name('admin.password.update');
});

// Admin protected routes — isAdmin checks session('admin_logged_in') set by AdminController::login()
Route::prefix('admin')->middleware(['isAdmin'])->group(function () {
    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/listings', [AdminController::class, 'listings'])->name('admin.listings');
    Route::post('/listings/{id}/approve', [AdminController::class, 'approveListing'])->name('admin.listings.approve');
    Route::post('/listings/{id}/reject', [AdminController::class, 'rejectListing'])->name('admin.listings.reject');
    Route::get('/appointments', [AdminController::class, 'appointments'])->name('admin.appointments');

    // Reviews Moderation
    Route::get('/reviews', [App\Http\Controllers\Admin\ReviewController::class, 'index'])->name('admin.reviews.index');
    Route::get('/reviews/reports', [App\Http\Controllers\Admin\ReviewController::class, 'reports'])->name('admin.reviews.reports');
    Route::get('/reviews/{review}', [App\Http\Controllers\Admin\ReviewController::class, 'show'])->name('admin.reviews.show');
    Route::patch('/reviews/{review}/status', [App\Http\Controllers\Admin\ReviewController::class, 'updateStatus'])->name('admin.reviews.updateStatus');
    Route::delete('/reviews/{review}', [App\Http\Controllers\Admin\ReviewController::class, 'destroy'])->name('admin.reviews.destroy');
    Route::patch('/reviews/reports/{report}/status', [App\Http\Controllers\Admin\ReviewController::class, 'updateReportStatus'])->name('admin.reviews.updateReportStatus');

    Route::get('/audit-logs', [AdminController::class, 'auditLogs'])->name('admin.audit-logs');

    // Payments & Settings
    Route::get('/payment-settings', [AdminController::class, 'paymentSettings'])->name('admin.payment-settings');
    Route::post('/payment-settings', [AdminController::class, 'updatePaymentSettings'])->name('admin.payment-settings.update');
    Route::get('/payment-transactions', [AdminController::class, 'paymentTransactions'])->name('admin.payment-transactions');


    // Agent Applications
    Route::get('/agent-applications', [AdminController::class, 'agentApplications'])->name('admin.agent-applications');
    Route::post('/agent-applications/{id}/approve', [AdminController::class, 'approveApplication'])->name('admin.agent-applications.approve');
    Route::post('/agent-applications/{id}/reject', [AdminController::class, 'rejectApplication'])->name('admin.agent-applications.reject');

    // Reports — protected under admin auth
    Route::get('/reports',  [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('admin.reports');
    Route::post('/reports', [App\Http\Controllers\Admin\ReportController::class, 'generate'])->name('admin.reports.generate');

    // Agent Subscriptions
    Route::get('/subscriptions', [App\Http\Controllers\Admin\PaymentController::class, 'subscriptions'])->name('admin.subscriptions.index');
    Route::get('/subscriptions/payments', [App\Http\Controllers\Admin\PaymentController::class, 'payments'])->name('admin.subscriptions.payments');
    Route::get('/subscriptions/plans', [App\Http\Controllers\Admin\SubscriptionPlanController::class, 'index'])->name('admin.subscriptions.plans');
    Route::post('/subscriptions/plans', [App\Http\Controllers\Admin\SubscriptionPlanController::class, 'store'])->name('admin.subscriptions.plans.store');
    Route::put('/subscriptions/plans/{plan}', [App\Http\Controllers\Admin\SubscriptionPlanController::class, 'update'])->name('admin.subscriptions.plans.update');
    Route::patch('/subscriptions/plans/{plan}/toggle', [App\Http\Controllers\Admin\SubscriptionPlanController::class, 'toggleActive'])->name('admin.subscriptions.plans.toggle');
});


Route::get('/agents/{id}', [App\Http\Controllers\AgentProfileController::class, 'show'])->name('agent.profile.show');

// Static pages
Route::get('/about',          fn() => view('pages.about'))->name('about');
Route::get('/services',       fn() => view('pages.services'))->name('services');
Route::get('/how-it-works',   fn() => view('pages.how-it-works'))->name('how-it-works');
Route::get('/contact',        fn() => view('pages.contact'))->name('contact');
Route::get('/become-agent',   [\App\Http\Controllers\AgentSubscriptionController::class, 'becomeAgent'])->name('become-agent');
Route::post('/become-agent/subscribe', [\App\Http\Controllers\AgentSubscriptionController::class, 'subscribe'])->name('become-agent.subscribe');
Route::get('/help-center',    fn() => view('pages.help-center'))->name('help-center');
Route::get('/privacy-policy', fn() => view('pages.privacy-policy'))->name('privacy-policy');
Route::get('/terms',          fn() => view('pages.terms'))->name('terms');

// Agent Profile editing route (must be protected by isAgent middleware)
Route::prefix('agent')->middleware(['isAgent'])->group(function () {
    Route::get('/profile', [App\Http\Controllers\AgentProfileController::class, 'edit'])->name('agent.profile.edit');
    Route::post('/profile', [App\Http\Controllers\AgentProfileController::class, 'update'])->name('agent.profile.update');
    
    // Agent Payment History & Renewal
    Route::get('/payments', [\App\Http\Controllers\AgentSubscriptionController::class, 'history'])->name('agent.payments.index');

    // Agent Reviews Response
    Route::post('/reviews/{review}/respond', [App\Http\Controllers\Agent\ReviewController::class, 'respond'])->name('agent.reviews.respond');
});




Route::post('/api/mpesa/callback', [App\Http\Controllers\Api\MpesaCallbackController::class, 'handleCallback'])->name('api.mpesa.callback');
Route::middleware('auth')->group(function () {
    Route::get('/listings/{listing}/reserve', [App\Http\Controllers\ListingController::class, 'showReserveForm'])->name('listings.reserve');
    Route::post('/listings/{listing}/reserve', [App\Http\Controllers\ListingController::class, 'processReserve'])->name('listings.process_reserve');

    // Security & Sessions
    Route::get('/my-security', [App\Http\Controllers\SecurityController::class, 'index'])->name('security.index');
    Route::post('/my-security/logout-other-devices', [App\Http\Controllers\SecurityController::class, 'logoutOtherDevices'])->name('security.logout_other_devices');

    // User Reviews
    Route::get('/my-reviews', [App\Http\Controllers\ReviewController::class, 'myReviews'])->name('reviews.my');
    Route::get('/appointments/{appointment}/review/create', [App\Http\Controllers\ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/appointments/{appointment}/review', [App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/reviews/{review}/edit', [App\Http\Controllers\ReviewController::class, 'edit'])->name('reviews.edit');
    Route::put('/reviews/{review}', [App\Http\Controllers\ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [App\Http\Controllers\ReviewController::class, 'destroy'])->name('reviews.destroy');

    // Messages
    Route::get('/messages', [App\Http\Controllers\MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{conversation}', [App\Http\Controllers\MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{conversation}', [App\Http\Controllers\MessageController::class, 'store'])->name('messages.store');
    Route::post('/messages/start/{listing}', [App\Http\Controllers\MessageController::class, 'start'])->name('messages.start');
});
