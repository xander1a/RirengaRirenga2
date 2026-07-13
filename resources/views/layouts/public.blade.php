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

    <main class="flex-grow">
        @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 py-3">
            <div class="rounded-xl p-4 text-sm" style="background:#6E8C5A20;border:1px solid #6E8C5A;color:#2E4636;">
                {{ session('success') }}
            </div>
        </div>
        @endif
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
