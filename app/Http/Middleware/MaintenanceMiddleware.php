<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MaintenanceMiddleware
{
    /**
     * Routes that should be accessible during maintenance mode.
     */
    protected $allowedRoutes = [
        'maintenance',
        'login',
        'debug-env',
        'login.store',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $routeName = $request->route()?->getName();
        if ($routeName && in_array($routeName, $this->allowedRoutes)) {
            return $next($request);
        }

        $path = trim($request->getPathInfo(), '/');
        $allowedPaths = ['maintenance', 'login', 'debug-env'];
        if (in_array($path, $allowedPaths)) {
            return $next($request);
        }

        $isMaintenanceEnabled = env('APP_MAINTENANCE', false);
        $isLocalEnv = env('APP_ENV') === 'local';

        if ($isMaintenanceEnabled && $isLocalEnv) {
            return redirect('/maintenance')->setStatusCode(503);
        }

        return $next($request);
    }
}
