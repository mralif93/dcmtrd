<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TwoFactorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Check if the user is authenticated
        if (!$user) {
            return redirect()->route('login')->withErrors(['access' => 'You must be logged in to access this page.']);
        }

        if ($request->routeIs('two-factor.show')) {
            if ($user->two_factor_code == null && $user->two_factor_verified) {
                return redirect()->route('login')->withErrors(['access' => 'You must be logged in to access this page.']);
            }
        }

        return $next($request);
    }
}