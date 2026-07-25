<x-guest-layout :title="__('Welcome back')" :subtitle="__('Sign in to manage your bookings and stay.')">
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1.5 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="you@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between">
                <x-input-label for="password" :value="__('Password')" />
                @if (Route::has('password.request'))
                    <a class="text-sm hover:underline" style="color:#3F7C8A;" href="{{ route('password.request') }}">
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>

            <x-text-input id="password" class="block mt-1.5 w-full"
                            type="password"
                            name="password"
                            placeholder="••••••••"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <label for="remember_me" class="flex items-center select-none">
            <input id="remember_me" type="checkbox" class="rounded border-gray-300 focus:ring-[#3F7C8A]" style="color:#1E3A4A;" name="remember">
            <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
        </label>

        <x-primary-button class="w-full justify-center py-3 text-sm">
            {{ __('Log in') }}
        </x-primary-button>
    </form>

    <p class="mt-8 text-center text-sm text-gray-500">
        {{ __("Don't have an account?") }}
        <a href="{{ route('register') }}" class="font-semibold hover:underline" style="color:#1E3A4A;">{{ __('Sign up') }}</a>
    </p>
</x-guest-layout>
