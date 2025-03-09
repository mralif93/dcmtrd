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
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Check if the user is authenticated
        if (!$user) {
            return redirect()->route('login')->withErrors(['access' => 'You must be logged in to access this page.']);
        }
        
        // If 2FA is enabled for the user but not yet verified
        if ($user->two_factor_enabled && !$user->two_factor_verified) {
            // Allow access to 2FA verification routes
            if ($request->routeIs('two-factor.show') || $request->routeIs('two-factor.verify')) {
                return $next($request);
            }
            
            // Redirect to 2FA verification for all other routes
            return redirect()->route('two-factor.show');
        }
        
        // If user doesn't need 2FA or has already verified
        if ($request->routeIs('two-factor.show') || $request->routeIs('two-factor.verify')) {
            // Redirect away from 2FA pages if not needed
            if (!$user->two_factor_enabled || $user->two_factor_verified) {
                return redirect()->route('dashboard');
            }
        }
        
        // Allow the request to proceed
        return $next($request);
    }
}