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
        $user = auth()->user();
        if (!$user) return '/login';
        return match ($user->role) {
            'admin'  => route('admin.dashboard'),
            'agent'  => route('agent.dashboard'),
            'buyer'  => route('buyer.dashboard'),
            default  => route('tenant.dashboard'),
        };
    });
    $middleware->alias([
        'isAdmin'        => \App\Http\Middleware\IsAdmin::class,
        'isAgent'        => \App\Http\Middleware\IsAgent::class,
        'sessionTimeout' => \App\Http\Middleware\SessionTimeout::class,
        App\Http\Middleware\LogRequests::class,
    ]);

    // Prevent caching of authenticated pages
    $middleware->web(append: [
        \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
        \App\Http\Middleware\LogRequests::class,
    ]);
})
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->reportable(function (Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Exception captured: ' . $e->getMessage(), [
                'class' => get_class($e),
                'trace' => $e->getTraceAsString()
            ]);
        });
    })->create();
