<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';
Route::get('/home', function () {
    $user = request()->user();
    return 'Welcome, ' . $user->first_name . '! You are logged in.';
})->middleware('auth')->name('home');

Route::get('/agent/dashboard', function () {
    $user = request()->user();
    return $user ? 'Welcome Agent, ' . $user->first_name . '!' : 'Unauthorized';
})->middleware('auth')->name('agent.dashboard');
