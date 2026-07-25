<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Rirenga') — Rirenga</title>
    <meta name="description" content="@yield('meta_description', 'Rirenga — A sustainable eco-lodge in the heart of Rwanda.')">

    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#1E3A4A">
    <link rel="apple-touch-icon" href="/icons/icon-192.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- Tailwind v4 (CDN build) + brand theme --}}
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style type="text/tailwindcss">
        @theme {
            --color-forest: #1E3A4A;
            --color-sage: #3F7C8A;
            --color-terracotta: #D07A54;
            --color-sand: #EFE9DC;
            --color-gold: #C99A52;
            --color-charcoal: #22201D;
            --font-display: 'Playfair Display', Georgia, serif;
            --font-sans: 'Inter', ui-sans-serif, system-ui, sans-serif;
        }
    </style>

    {{-- Editorial design layer + base (inlined so styling never depends on a build) --}}
    <style>
        :root {
            --color-forest: #1E3A4A; --color-sage: #3F7C8A; --color-terracotta: #D07A54;
            --color-sand: #EFE9DC; --color-gold: #C99A52; --color-charcoal: #22201D;
            --font-display: 'Playfair Display', Georgia, serif;
            --font-sans: 'Inter', ui-sans-serif, system-ui, sans-serif;
        }
        body { background-color: var(--color-sand); color: var(--color-charcoal); font-family: var(--font-sans); }
        h1, h2, h3, .font-display { font-family: var(--font-display); }
        [x-cloak] { display: none !important; }

        [data-reveal] { opacity: 0; transform: translateY(18px); transition: opacity .7s ease, transform .7s ease; }
        [data-reveal].is-visible { opacity: 1; transform: translateY(0); }

        .icon-tile { position: relative; overflow: hidden; }
        .icon-tile::before { content: ''; position: absolute; inset: 0; background-image: radial-gradient(circle, currentColor 1px, transparent 1px); background-size: 16px 16px; opacity: .08; }

        .sidebar-scroll { scrollbar-width: thin; scrollbar-color: #C99A5266 #1E3A4A; }
        .sidebar-scroll::-webkit-scrollbar { width: 6px; }
        .sidebar-scroll::-webkit-scrollbar-track { background-color: #1E3A4A; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background-color: #C99A5266; border-radius: 999px; }

        .ed-kicker { display: inline-flex; align-items: center; gap: .75rem; font-family: var(--font-sans); font-size: .72rem; font-weight: 600; letter-spacing: .22em; text-transform: uppercase; color: var(--color-terracotta); }
        .ed-kicker::before { content: ''; width: 2.25rem; height: 1px; background: currentColor; opacity: .7; }
        .ed-kicker--center { justify-content: center; }
        .ed-kicker--light { color: var(--color-gold); }

        .ed-title { font-family: var(--font-display); font-weight: 700; line-height: 1.05; letter-spacing: -.01em; color: var(--color-forest); }
        .ed-title em { font-style: italic; font-weight: 400; }
        .ed-title--light { color: #fff; }

        .ed-lede { font-size: 1.15rem; line-height: 1.75; font-weight: 300; color: #4b4a45; }

        .ed-rule { height: 1px; width: 100%; background: rgba(34,32,29,.14); }
        .ed-rule-gold { height: 2px; width: 3.5rem; background: var(--color-gold); }

        .ed-btn { display: inline-flex; align-items: center; justify-content: center; gap: .5rem; padding: .95rem 2rem; font-family: var(--font-sans); font-size: .75rem; font-weight: 600; letter-spacing: .16em; text-transform: uppercase; border-radius: 2px; transition: all .25s ease; cursor: pointer; }
        .ed-btn-solid { background: var(--color-terracotta); color: #fff; }
        .ed-btn-solid:hover { background: #b8613f; }
        .ed-btn-outline { background: transparent; color: var(--color-forest); border: 1px solid var(--color-forest); }
        .ed-btn-outline:hover { background: var(--color-forest); color: #fff; }
        .ed-btn-outline-light { background: transparent; color: #fff; border: 1px solid rgba(255,255,255,.55); }
        .ed-btn-outline-light:hover { background: #fff; color: var(--color-forest); }

        .ed-arrow { display: inline-flex; align-items: center; gap: .5rem; font-family: var(--font-sans); font-size: .78rem; font-weight: 600; letter-spacing: .12em; text-transform: uppercase; color: var(--color-terracotta); transition: gap .25s ease; }
        .ed-arrow:hover { gap: .85rem; }
        .ed-arrow svg { width: 1.1rem; height: 1.1rem; }

        .ed-index { font-family: var(--font-display); font-size: .9rem; font-weight: 400; letter-spacing: .1em; color: var(--color-gold); }

        .ed-dropcap::first-letter { font-family: var(--font-display); font-size: 3.4em; font-weight: 700; float: left; line-height: .8; padding: .05em .12em 0 0; color: var(--color-terracotta); }

        .ed-frame { border-radius: 2px; overflow: hidden; }
        .ed-frame img { display: block; width: 100%; height: 100%; object-fit: cover; }
    </style>

    {{-- Alpine.js (menus, dropdowns, lightbox, forms) --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
    @stack('styles')
</head>
<body class="min-h-screen flex flex-col font-sans" style="background-color:#EFE9DC;color:#22201D;">

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
             style="{{ $flashError ? 'background:#fff;border:1px solid #D07A5460;color:#D07A54;' : 'background:#1E3A4A;color:#fff;' }}">
            @if($flashError)
            <svg class="w-5 h-5 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20Zm-1 5h2v7h-2V7Zm1 9.75a1.25 1.25 0 1 1 0 2.5 1.25 1.25 0 0 1 0-2.5Z"/></svg>
            <span>{{ $flashError }}</span>
            @else
            <svg class="w-5 h-5 shrink-0 mt-0.5" style="color:#C99A52;" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20Zm4.7 7.3-5.6 5.6a1 1 0 0 1-1.4 0l-2.4-2.4a1 1 0 1 1 1.4-1.4l1.7 1.7 4.9-4.9a1 1 0 0 1 1.4 1.4Z"/></svg>
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

    {{-- Scroll-reveal --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const targets = document.querySelectorAll('[data-reveal]');
            if (!targets.length) return;
            if (!('IntersectionObserver' in window)) {
                targets.forEach(el => el.classList.add('is-visible'));
                return;
            }
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.15 });
            targets.forEach(el => observer.observe(el));
        });

        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/sw.js').catch(() => {});
        }
    </script>
</body>
</html>
