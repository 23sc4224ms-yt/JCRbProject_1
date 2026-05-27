<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  string  $roles
     */
    public function handle(Request $request, Closure $next, string $roles): Response
    {
        $allowedRoles = explode('|', $roles);
        $currentRole = $request->session()->get('role');

        if (!$currentRole || !in_array($currentRole, $allowedRoles, true)) {
            return redirect()->route('dashboard')->with('error', 'You are not authorized to access that page.');
        }

        return $next($request);
    }
}
