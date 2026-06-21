<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
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

require __DIR__.'/auth.php';

// Admin login — public (no auth needed)
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'login'])->name('admin.login.submit');
});

// Admin protected routes — auth + isAdmin + sessionTimeout
Route::prefix('admin')->middleware(['auth', 'isAdmin', 'sessionTimeout'])->group(function () {
    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/listings', [AdminController::class, 'listings'])->name('admin.listings');
    Route::post('/listings/{id}/approve', [AdminController::class, 'approveListing'])->name('admin.listings.approve');
    Route::post('/listings/{id}/reject', [AdminController::class, 'rejectListing'])->name('admin.listings.reject');
    Route::get('/appointments', [AdminController::class, 'appointments'])->name('admin.appointments');

    //theme settings
});Route::get('/themes', function () {
    return view('themes');
})->name('themes');


