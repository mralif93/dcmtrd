<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = Auth::user();

        // Check if the user is authenticated
        if (!$user) {
            return redirect()->route('login')->withErrors(['access' => 'You must be logged in to access this page.']);
        }

        // Check if the user has the required role
        if ($user->role !== $role) {
            // If user doesn't have the required role, redirect based on their actual role
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard')->withErrors(['access' => 'You do not have access to this page.']);
                case 'user':
                    return redirect()->route('dashboard')->withErrors(['access' => 'You do not have access to this page.']);
                case 'legal':
                    return redirect()->route('legal.dashboard')->withErrors(['access' => 'You do not have access to this page.']);
                case 'compliance':
                    return redirect()->route('compliance.dashboard')->withErrors(['access' => 'You do not have access to this page.']);
                case 'maker':
                    return redirect()->route('maker.dashboard')->withErrors(['access' => 'You do not have access to this page.']);
                case 'approver':
                    return redirect()->route('approver.dashboard')->withErrors(['access' => 'You do not have access to this page.']);
                case 'sales':
                    return redirect()->route('sales.dashboard')->withErrors(['access' => 'You do not have access to this page.']);
                default:
                    return redirect()->route('main')->withErrors(['access' => 'You do not have access to this page.']);
            }
        }

        // User role check passed, continue to the next middleware
        return $next($request);
    }
}