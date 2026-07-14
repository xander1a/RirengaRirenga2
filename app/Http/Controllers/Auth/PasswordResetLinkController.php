<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\PasswordOtpMail;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Send a 6-digit OTP code to the user's email.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            $otp = (string) random_int(100000, 999999);

            DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $user->email],
                ['token' => Hash::make($otp), 'created_at' => now()]
            );

            Mail::to($user->email)->send(new PasswordOtpMail($otp, $user->name));
        }

        // Always proceed to the OTP form so email addresses can't be probed.
        return redirect()->route('password.reset.otp', ['email' => $request->email])
            ->with('status', 'If that email exists, we\'ve sent it a 6-digit code. It expires in 10 minutes.');
    }
}
