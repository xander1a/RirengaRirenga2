<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'BYIZA Eco-lodge') — BYIZA Eco-lodge</title>
    <meta name="description" content="@yield('meta_description', 'BYIZA Eco-lodge — A sustainable eco-lodge in the heart of Rwanda.')">

    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#2E4636">
    <link rel="apple-touch-icon" href="/icons/icon-192.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="min-h-screen flex flex-col font-sans" style="background-color:#F1E9D7;color:#2B2A28;">

    @include('layouts.public-navbar')

    {{-- Floating flash toast (success / error / validation) --}}
    @php
        $flashMessage = session('success') ?? session('status');
        $flashError   = session('error') ?? ($errors->any() ? $errors->first() : null);
    @endphp
    @if($flashMessage || $flashError)
    <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 100); setTimeout(() => show = false, 6000)"
         x-show="show" x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         class="fixed top-20 inset-x-0 z-[90] flex justify-center px-4 pointer-events-none">
        <div class="pointer-events-auto flex items-start gap-3 max-w-md w-full sm:w-auto rounded-2xl shadow-xl px-5 py-4 text-sm font-medium"
             style="{{ $flashError ? 'background:#fff;border:1px solid #BF6B4760;color:#BF6B47;' : 'background:#2E4636;color:#fff;' }}">
            @if($flashError)
            <svg class="w-5 h-5 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20Zm-1 5h2v7h-2V7Zm1 9.75a1.25 1.25 0 1 1 0 2.5 1.25 1.25 0 0 1 0-2.5Z"/></svg>
            <span>{{ $flashError }}</span>
            @else
            <svg class="w-5 h-5 shrink-0 mt-0.5" style="color:#C9A24B;" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20Zm4.7 7.3-5.6 5.6a1 1 0 0 1-1.4 0l-2.4-2.4a1 1 0 1 1 1.4-1.4l1.7 1.7 4.9-4.9a1 1 0 0 1 1.4 1.4Z"/></svg>
            <span>{{ $flashMessage }}</span>
            @endif
            <button @click="show = false" class="ml-2 -mr-1 opacity-60 hover:opacity-100 shrink-0" aria-label="Dismiss">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M6.7 5.3a1 1 0 0 0-1.4 1.4L10.6 12l-5.3 5.3a1 1 0 1 0 1.4 1.4l5.3-5.3 5.3 5.3a1 1 0 0 0 1.4-1.4L13.4 12l5.3-5.3a1 1 0 1 0-1.4-1.4L12 10.6 6.7 5.3Z"/></svg>
            </button>
        </div>
    </div>
    @endif

    <main class="flex-grow">
        @yield('content')
    </main>

    @include('layouts.public-footer')

    @stack('scripts')

    <script>
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/sw.js').catch(() => {});
        }
    </script>
</body>
</html>
