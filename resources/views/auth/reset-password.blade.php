<x-guest-layout :title="__('Set a new password')" subtitle="Enter the 6-digit code we emailed you, then choose a new password.">
    @if (session('status'))
        <div class="mb-4 px-4 py-3 rounded-xl text-sm" style="background:#3F7C8A20;color:#1E3A4A;border:1px solid #3F7C8A;">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1.5 w-full" type="email" name="email" :value="old('email', $email)" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- OTP code -->
        <div>
            <x-input-label for="otp" value="6-digit code" />
            <x-text-input id="otp" class="block mt-1.5 w-full text-center text-2xl tracking-[0.5em] font-bold" type="text"
                          name="otp" inputmode="numeric" pattern="[0-9]{6}" maxlength="6" required autofocus
                          placeholder="••••••" autocomplete="one-time-code" />
            <x-input-error :messages="$errors->get('otp')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('New Password')" />
            <x-text-input id="password" class="block mt-1.5 w-full" type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1.5 w-full" type="password"
                          name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <x-primary-button class="w-full justify-center py-3 text-sm">
            {{ __('Reset Password') }}
        </x-primary-button>

        <p class="text-center text-sm text-gray-500">
            Didn't get the code?
            <a href="{{ route('password.request') }}" class="font-semibold hover:underline" style="color:#D07A54;">Send again</a>
        </p>
    </form>
</x-guest-layout>
