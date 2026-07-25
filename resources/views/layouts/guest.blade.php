@props(['title' => null, 'subtitle' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ? $title . ' — ' : '' }}{{ config('app.name', 'Rirenga') }}</title>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">

        {{-- Top nav bar --}}
        <nav style="background:#1E3A4A;" class="w-full px-6 py-3 flex items-center justify-between">
            <a href="/" class="font-display text-lg font-bold tracking-wide text-white">
                Rirenga 
            </a>
            <div class="flex items-center gap-4 text-sm">
                <a href="{{ route('login') }}" class="text-white/70 hover:text-white transition">Login</a>
                <a href="{{ route('register') }}" class="px-4 py-1.5 rounded-full text-white font-semibold transition" style="background:#C99A52;">Sign up</a>
            </div>
        </nav>

        <div class="flex" style="min-height: calc(100vh - 52px);">

            {{-- Left branding panel --}}
            <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden flex-col justify-between p-12"
                 style="background: radial-gradient(circle at 20% 20%, #3a5a45 0%, #1E3A4A 55%, #20331f 100%);">

                <div class="absolute inset-0 opacity-10 pointer-events-none" style="
                    background-image: radial-gradient(circle, #C99A52 1px, transparent 1px);
                    background-size: 28px 28px;"></div>

                <a href="/" class="relative z-10 font-display text-2xl font-bold tracking-wide text-white">
                    Rirenga 
                </a>

                <div class="relative z-10 max-w-md">
                    <p class="font-display text-3xl leading-snug text-white/95">
                        "Wake up to mist over the hills, the smell of fresh coffee, and nothing but green for miles."
                    </p>
                    <div class="mt-6 flex items-center gap-3">
                        <div class="h-px w-10" style="background:#C99A52;"></div>
                        <span class="text-sm uppercase tracking-widest text-white/60">A sustainable retreat in Rwanda</span>
                    </div>
                </div>

                <div class="relative z-10 flex items-center gap-6 text-white/50 text-sm">
                    <span>🌿 Eco-friendly</span>
                    <span>🍽️ Restaurant & Bar</span>
                    <span>🛏️ 5 Rooms</span>
                </div>
            </div>

            {{-- Right form panel --}}
            <div class="w-full lg:w-1/2 flex flex-col items-center justify-center px-6 py-12" style="background-color:#F9F6EF;">
                <div class="w-full max-w-sm">

                    <a href="/" class="inline-flex items-center gap-2 mb-6 px-4 py-2 rounded-full text-sm font-semibold border transition hover:shadow-sm"
                       style="color:#1E3A4A;border-color:#1E3A4A30;background:#ffffff;">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M11.03 3.97a.75.75 0 0 1 0 1.06L4.81 11.25H21a.75.75 0 0 1 0 1.5H4.81l6.22 6.22a.75.75 0 1 1-1.06 1.06l-7.5-7.5a.75.75 0 0 1 0-1.06l7.5-7.5a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd"/></svg>
                        Back
                    </a>

                    @if($title)
                        <h1 class="font-display text-3xl font-bold mb-2" style="color:#1E3A4A;">{{ $title }}</h1>
                    @endif
                    @if($subtitle)
                        <p class="text-sm text-gray-500 mb-8">{{ $subtitle }}</p>
                    @else
                        <div class="mb-8"></div>
                    @endif

                    @if(session('error'))
                        <div class="mb-4 px-4 py-3 rounded-xl text-sm" style="background:#D07A5415;border:1px solid #D07A5440;color:#D07A54;">
                            {{ session('error') }}
                        </div>
                    @endif

                    {{ $slot }}

                </div>
            </div>
        </div>
    </body>
</html>
