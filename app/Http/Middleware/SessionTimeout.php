<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionTimeout
{
    // Timeout in seconds (inactivity-based — resets on every request)
    const TIMEOUT = 7200;       // 2 hours for regular users (gives time to fill out long forms)
    const ADMIN_TIMEOUT = 3600; // 1 hour for admins

    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $timeout = Auth::user()->role === 'admin'
                ? self::ADMIN_TIMEOUT
                : self::TIMEOUT;

            $lastActivity = session('last_activity');

            if ($lastActivity && (time() - $lastActivity > $timeout)) {
                // Session expired
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')
                    ->with('error', 'Your session has expired. Please login again.');
            }

            // Update last activity time
            session(['last_activity' => time()]);
        }

        return $next($request);
    }
}
