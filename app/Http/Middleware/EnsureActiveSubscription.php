<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureActiveSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // Let admins bypass this check
        if (session('admin_logged_in') || ($user && $user->role === 'admin')) {
            return $next($request);
        }

        // Must be logged in
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please log in to continue.');
        }

        // If they are an agent, ensure they have an active subscription
        if ($user->role === 'agent') {
            $hasActiveSubscription = $user->subscriptions()
                ->where('status', 'active')
                ->where('expiry_date', '>', now())
                ->exists();

            if (!$hasActiveSubscription) {
                if ($request->expectsJson()) {
                    return response()->json(['error' => 'Your subscription has expired. Please renew.'], 403);
                }
                
                return redirect()->route('agent.payments.index')
                    ->with('error', 'Your subscription has expired. Please renew your subscription to continue managing properties.');
            }
        }

        return $next($request);
    }
}
