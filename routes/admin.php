<?php

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
    
    // Password Reset Routes
    Route::get('/forgot-password', [AdminController::class, 'showForgotPassword'])->name('admin.password.request');
    Route::post('/forgot-password', [AdminController::class, 'sendResetLinkEmail'])->name('admin.password.email');
    Route::get('/reset-password/{token}', [AdminController::class, 'showResetPassword'])->name('admin.password.reset');
    Route::post('/reset-password', [AdminController::class, 'resetPassword'])->name('admin.password.update');
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/listings', [AdminController::class, 'listings'])->name('admin.listings');
    Route::post('/listings/{id}/approve', [AdminController::class, 'approveListing'])->name('admin.listings.approve');
    Route::post('/listings/{id}/reject', [AdminController::class, 'rejectListing'])->name('admin.listings.reject');
    Route::get('/appointments', [AdminController::class, 'appointments'])->name('admin.appointments');
});
