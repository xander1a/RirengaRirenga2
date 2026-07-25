<x-guest-layout :title="__('Verify your email')" :subtitle="__('Click the link we sent you to activate your account.')">
    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm rounded-xl px-4 py-3" style="background:#EFE9DC;color:#1E3A4A;">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="flex flex-col gap-3">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <x-primary-button class="w-full justify-center py-3 text-sm">
                {{ __('Resend Verification Email') }}
            </x-primary-button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full text-center text-sm text-gray-500 hover:text-gray-800 py-2">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
