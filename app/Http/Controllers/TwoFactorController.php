<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\TwoFactorCode;

class TwoFactorController extends Controller
{
    /**
     * Show the two-factor authentication verification form.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        $user = Auth::user();

        // If there's no code or the code is expired, generate a new one
        if (!$user->two_factor_code || $user->two_factor_expires_at < now()) {
            $this->generateAndSendCode($user);
        }

        return view('auth.two-factor');
    }

    /**
     * Verify the two-factor authentication code.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6',
        ]);
    
        $user = auth()->user();
    
        // Check if the provided code matches the user's stored code and if it hasn't expired
        if ($user->two_factor_code === $request->code && $user->two_factor_expires_at > now()) {
            // Code is valid, proceed with authentication
            $user->forceFill([
                'two_factor_code' => null,
                'two_factor_expires_at' => null,
                'two_factor_verified' => true,
                'last_login_at' => now()
            ])->save();
    
            // Set session variable to indicate 2FA has been verified
            $request->session()->put('two_factor_verified', true);
    
            return redirect()->route('main');
        }
    
        return back()->withErrors(['code' => 'The provided two-factor code is invalid or has expired.']);
    }

    /**
     * Generate a new two-factor authentication code and send it to the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function generateCode(Request $request)
    {
        $user = auth()->user();
        $this->generateAndSendCode($user);

        return response()->json(['message' => 'Two-factor code sent to your email.']);
    }

    /**
     * Generate and send a new two-factor authentication code.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    private function generateAndSendCode($user)
    {
        // Generate a random 6-digit code
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        $user->forceFill([
            'two_factor_code' => $code,
            'two_factor_expires_at' => now()->addMinutes(10), // 10 minutes
            'two_factor_verified' => false
        ])->save();

        // Send the code via email
        try {
            Mail::to($user->email)->send(new TwoFactorCode($code));
        } catch (\Exception $e) {
            \Log::error('Failed to send 2FA code: ' . $e->getMessage());
            // For development, log the code
            \Log::info('Two-factor code for user ' . $user->email . ': ' . $code);
        }
    }

    /**
     * Toggle two-factor authentication for the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggle(Request $request)
    {
        $user = auth()->user();
        
        // Toggle 2FA status
        $user->forceFill([
            'two_factor_enabled' => !$user->two_factor_enabled,
            'two_factor_code' => null,
            'two_factor_expires_at' => null,
            'two_factor_verified' => false
        ])->save();

        $status = $user->two_factor_enabled ? 'enabled' : 'disabled';
        return back()->with('status', "Two-factor authentication has been {$status}.");
    }
}