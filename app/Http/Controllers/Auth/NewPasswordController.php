<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
    /**
     * Show the "enter code + new password" form.
     */
    public function create(Request $request): View
    {
        return view('auth.reset-password', ['email' => $request->query('email', '')]);
    }

    /**
     * Verify the OTP code and reset the password.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'otp'      => ['required', 'digits:6'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $record = DB::table('password_reset_tokens')->where('email', $request->email)->first();

        if (! $record || now()->diffInMinutes($record->created_at, true) > 10) {
            throw ValidationException::withMessages([
                'otp' => 'This code has expired. Please request a new one.',
            ]);
        }

        if (! Hash::check($request->otp, $record->token)) {
            throw ValidationException::withMessages([
                'otp' => 'The code is incorrect. Check your email and try again.',
            ]);
        }

        $user = User::where('email', $request->email)->firstOrFail();

        $user->forceFill([
            'password' => Hash::make($request->password),
            'remember_token' => Str::random(60),
        ])->save();

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        event(new PasswordReset($user));

        return redirect()->route('login')->with('status', 'Your password has been reset — you can now log in.');
    }
}
