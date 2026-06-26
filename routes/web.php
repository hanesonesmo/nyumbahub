<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;

// Contact form handled by ContactController (see below)


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

// Migration completed.

require __DIR__.'/auth.php';

Route::post('/contact', [App\Http\Controllers\ContactController::class, 'send'])->name('contact.send');
// Admin login — public (no auth needed)
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'login'])->name('admin.login.submit');
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

    // Agent Applications
    Route::get('/agent-applications', [AdminController::class, 'agentApplications'])->name('admin.agent-applications');
    Route::post('/agent-applications/{id}/approve', [AdminController::class, 'approveApplication'])->name('admin.agent-applications.approve');
    Route::post('/agent-applications/{id}/reject', [AdminController::class, 'rejectApplication'])->name('admin.agent-applications.reject');

    // Reports — protected under admin auth
    Route::get('/reports',  [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('admin.reports');
    Route::post('/reports', [App\Http\Controllers\Admin\ReportController::class, 'generate'])->name('admin.reports.generate');
});

Route::get('/themes', function () {
    return view('themes');
})->name('themes');

// Static pages
Route::get('/about',          fn() => view('pages.about'))->name('about');
Route::get('/how-it-works',   fn() => view('pages.how-it-works'))->name('how-it-works');
Route::get('/contact',        fn() => view('pages.contact'))->name('contact');
Route::get('/become-agent',   fn() => view('pages.become-agent'))->name('become-agent');
Route::get('/help-center',    fn() => view('pages.help-center'))->name('help-center');
Route::get('/privacy-policy', fn() => view('pages.privacy-policy'))->name('privacy-policy');
Route::get('/terms',          fn() => view('pages.terms'))->name('terms');




