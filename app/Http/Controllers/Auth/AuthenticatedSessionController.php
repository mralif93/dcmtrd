<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Http\Controllers\TwoFactorController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Carbon\Carbon;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Validate the incoming request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        // Check if the user exists and the password is correct
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();

            // Check if the user has 2FA enabled
            if ($user->two_factor_enabled) {
                // Generate a random 6-digit code
                $code = Str::random(6);
                $user->two_factor_code = $code;
                $user->two_factor_expires_at = Carbon::now()->addMinutes(10); // Code valid for 10 minutes
                $user->save();

                // Send the code via email
                // Mail::to($user->email)->send(new \App\Mail\TwoFactorCode($code));

                // Redirect to the 2FA verification page
                return redirect()->route('two-factor.show');
            }

            // Only update last login if 2FA is NOT required
            $user->update(['last_login_at' => now()]);


            // Redirect based on user role
            return redirect()->route('main');
        }
    
        // If authentication fails, redirect back with an error message
        return back()->withErrors(['email' => 'The provided credentials do not match our records.']);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Log the user out of the application
        Auth::guard('web')->logout();
    
        // Invalidate the current session to clear all session data
        $request->session()->invalidate();
    
        // Regenerate the session token to prevent session fixation attacks
        $request->session()->regenerateToken();
    
        // Redirect the user to the home page or any other desired route
        return redirect('/'); // Change '/' to your desired route if needed
    }

    protected function authenticated(Request $request, $user)
    {
        try {
            $user->updateOrFail(['last_login_at' => now()]);
        } catch (\Exception $e) {
            \Log::error('Login time update failed: '.$e->getMessage());
        }
    }
}
