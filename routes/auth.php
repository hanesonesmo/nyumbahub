<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

//NYUMBAHUB AUTH ROUTES
//THESE ROUTES WILL BE ADDING INTO routes/web.php file

Route::middleware('guest')->group(function () {

//LOGIN
Route::get('/login', [AuthController::class, 'showLogin'])
->name('login');
Route::post('/login', [AuthController::class, 'login']);

//REGISTER
Route::get('/register', [AuthController::class, 'showRegister'])
->name('register');
Route::post('/register', [AuthController::class, 'register']);
});

//AUTHENTICATED ROUTES
Route::middleware('auth')->group(function () {

//LOGOUT
Route::post('/logout', [AuthController::class, 'logout'])
->name('logout');

Route::get('/home', function () {
        return view('home'); // create resources/views/home.blade.php
    })->name('home');

    // Agent dashboard (replace with real controller later)
    Route::get('/agent/dashboard', function () {
        return view('agent.dashboard'); // create resources/views/agent/dashboard.blade.php
    })->name('agent.dashboard');
});
