<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class TwoFactorController extends Controller
{
    public function show()
    {
        return view('auth.two-factor'); // Return the view for 2FA input
    }

    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6',
        ]);
    
        $user = auth()->user();
    
        // Check if the provided code matches the user's stored code and if it hasn't expired
        if ($user->two_factor_code === $request->code && $user->two_factor_expires_at > now()) {
            // Code is valid, proceed with authentication
            $user->two_factor_code = null; // Clear the code
            $user->two_factor_expires_at = null; // Clear the expiration
            $user->two_factor_verified = true; // Mark as verified
            $user->last_login_at = now();
            $user->save();
    
            // Set session variable to indicate 2FA has been verified
            $request->session()->put('two_factor_verified', true);
    
            // Redirect based on user role
            return redirect()->route($this->getRedirectRoute($user->role));
        }
    
        return back()->withErrors(['code' => 'The provided two-factor code is invalid or has expired.']);
    }

    public function generateCode(Request $request)
    {
        $user = auth()->user();
        $user->two_factor_code = rand(100000, 999999); // Generate a random 6-digit code
        $user->two_factor_expires_at = now()->addMinutes(10); // Set expiration time
        $user->save();

        // Here you would send the code to the user via email/SMS
        // For example: Mail::to($user->email)->send(new TwoFactorCodeMail($user));

        return response()->json(['message' => 'Two-factor code sent.']);
    }

    /**
     * Get the redirect route based on the user's role.
     *
     * @param string $role
     * @return string
     */
    private function getRedirectRoute($role)
    {
        switch ($role) {
            case 'admin':
                return 'admin.dashboard';
            case 'compliance':
                return 'compliance.dashboard';
            case 'legal':
                return 'legal.dashboard';
            case 'maker':
                return 'maker.dashboard';
            case 'approver':
                return 'legal.dashboard';
            default:
                return 'dashboard';
        }
    }
}