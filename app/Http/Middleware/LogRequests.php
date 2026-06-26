<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Log;
class LogRequests {
    public function handle($request, Closure $next) {
        $response = $next($request);
        Log::info('Request: ' . $request->method() . ' ' . $request->fullUrl(), [
            'status' => $response->getStatusCode(),
            'redirect' => $response->headers->get('Location'),
            'user' => auth()->id()
        ]);
        return $response;
    }
}
