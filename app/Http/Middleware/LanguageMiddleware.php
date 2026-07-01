<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        \Illuminate\Support\Facades\Log::info('LanguageMiddleware triggered. Session locale: ' . Session::get('locale'));
        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
            \Illuminate\Support\Facades\Log::info('App locale set to: ' . App::getLocale());
        }
        return $next($request);
    }
}
