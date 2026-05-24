<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ListingController;
use Illuminate\Support\Facades\Route;

// Public routes — no login required
Route::get('/listings', [ListingController::class, 'index'])->name('listings.index');
Route::get('/listings/{id}', [ListingController::class, 'show'])->name('listings.show');

// Guest only
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated users
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/tenant/dashboard', function () { return view('tenant.dashboard'); })->name('tenant.dashboard');
    Route::get('/buyer/dashboard', function () { return view('buyer.dashboard'); })->name('buyer.dashboard');
    Route::get('/agent/dashboard', function () { return view('agent.dashboard'); })->name('agent.dashboard');
    Route::get('/agent/listings/create', function () { return 'Add listing coming soon'; })->name('agent.listings.create');
});

//Agent Listing Management
Route::prefix('agent')->name('agent.')->group(function () {
    Route::get('/listings', [App\Http\Controllers\Agent\ListingController::class, 'index'])->name('listings.index');
    Route::get('/listings/create', [App\Http\Controllers\Agent\ListingController::class, 'create'])->name('listings.create');
    Route::post('/listings', [App\Http\Controllers\Agent\ListingController::class, 'store'])->name('listings.store');
    Route::get('/listings/{id}/edit', [App\Http\Controllers\Agent\ListingController::class, 'edit'])->name('listings.edit');
    Route::put('/listings/{id}', [App\Http\Controllers\Agent\ListingController::class, 'update'])->name('listings.update');
    Route::delete('/listings/{id}', [App\Http\Controllers\Agent\ListingController::class, 'destroy'])->name('listings.destroy');
    Route::delete('/listings/images/{id}', [App\Http\Controllers\Agent\ListingController::class, 'deleteImage'])->name('listings.images.delete');
});
