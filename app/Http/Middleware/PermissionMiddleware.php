<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $permission
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $user = Auth::user();

        // Check if the user is authenticated
        if (!$user) {
            return redirect()->route('login')->withErrors(['access' => 'You must be logged in to access this page.']);
        }

        // Admin users bypass permission checks (they have all permissions)
        if ($user->isAdmin()) {
            return $next($request);
        }

        // Check if the user has the required permission
        if (!$user->hasPermission($permission)) {
            // Redirect based on user role
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard')->withErrors(['access' => 'You do not have permission to access this page.']);
                case 'user':
                    return redirect()->route('dashboard')->withErrors(['access' => 'You do not have permission to access this page.']);
                case 'legal':
                    return redirect()->route('legal.dashboard')->withErrors(['access' => 'You do not have permission to access this page.']);
                case 'compliance':
                    return redirect()->route('compliance.dashboard')->withErrors(['access' => 'You do not have permission to access this page.']);
                case 'maker':
                    return redirect()->route('maker.dashboard')->withErrors(['access' => 'You do not have permission to access this page.']);
                case 'approver':
                    return redirect()->route('approver.dashboard')->withErrors(['access' => 'You do not have permission to access this page.']);
                default:
                    return redirect()->route('main')->withErrors(['access' => 'You do not have permission to access this page.']);
            }
        }

        // Permission check passed, continue to the next middleware
        return $next($request);
    }
}