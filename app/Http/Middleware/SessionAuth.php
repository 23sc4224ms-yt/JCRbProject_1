<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SessionAuth
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->session()->has('user_account_id')) {
            return redirect()->route('login')->with('error', 'Please sign in to continue.');
        }

        return $next($request);
    }
}
