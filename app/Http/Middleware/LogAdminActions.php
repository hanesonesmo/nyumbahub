<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\AuditService;

class LogAdminActions
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only log POST, PUT, DELETE requests made by admins
        if (in_array($request->method(), ['POST', 'PUT', 'DELETE']) && session('admin_logged_in')) {
            $path = $request->path();
            $action = $request->method();
            
            // Generate a readable description
            $description = "Admin performed {$action} on {$path}";

            // Map path to module
            $module = 'Admin Dashboard';
            if (str_contains($path, 'listings')) $module = 'Listings';
            if (str_contains($path, 'applications')) $module = 'Agent Applications';
            if (str_contains($path, 'users')) $module = 'Users';

            AuditService::log(
                action: $action,
                module: $module,
                description: $description,
            );
        }

        return $response;
    }
}
