<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAgent
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || auth()->user()->role !== 'agent') {
            abort(403, 'Access restricted to agents.');
        }

        return $next($request);
    }
}
