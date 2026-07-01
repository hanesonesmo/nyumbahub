<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MpesaCallbackController;

Route::post('/mpesa/callback', [MpesaCallbackController::class, 'handleCallback'])->name('api.mpesa.callback');
