<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->redirectGuestsTo('/login');
        $middleware->redirectUsersTo(function () {
            $user = Illuminate\Support\Facades\Auth::user();
            if (!$user) return '/login';
            return match ($user->role) {
                'admin'  => route('admin.dashboard'),
                'agent'  => route('agent.dashboard'),
                'buyer'  => route('buyer.dashboard'),
                default  => route('tenant.dashboard'),
            };
        });
        $middleware->alias([
            'isAdmin' => \App\Http\Middleware\IsAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
