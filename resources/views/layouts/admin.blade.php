<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="theme-color" content="#2E4636">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — Byiza Lodge Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-gray-50 font-sans" x-data="{ sidebarOpen: false, moreOpen: false }" @keydown.escape.window="moreOpen = false">

@php
    $user = auth()->user();
    $links = [
        ['route'=>'admin.dashboard','icon'=>'dashboard','label'=>'Dashboard'],
        ['route'=>'admin.bookings.index','icon'=>'calendar','label'=>'Bookings'],
        ['route'=>'admin.transactions.index','icon'=>'banknotes','label'=>'Transactions'],
        ['route'=>'admin.rooms.index','icon'=>'bed','label'=>'Rooms'],
        ['route'=>'admin.menu.index','icon'=>'utensils','label'=>'Menu'],
        ['route'=>'admin.gallery.index','icon'=>'photo','label'=>'Gallery'],
        ['route'=>'admin.inventory.index','icon'=>'archive','label'=>'Inventory'],
        ['route'=>'admin.blog.index','icon'=>'document','label'=>'Blog'],
    ];
    if($user->hasRole(['director','manager'])) {
        $links[] = ['route'=>'admin.site-images.index','icon'=>'photo','label'=>'Site Images'];
        $links[] = ['route'=>'admin.reports.index','icon'=>'chart','label'=>'Reports'];
    }
    if($user->hasRole('director')) {
        $links[] = ['route'=>'admin.staff.index','icon'=>'users','label'=>'Staff'];
    }
    $isActive = fn ($route) => request()->routeIs(rtrim($route, '.index').'*');
    $tabLinks = array_slice($links, 0, 4);
@endphp

<div class="flex h-full">
    {{-- Sidebar (desktop only) --}}
    <aside class="hidden lg:flex w-72 flex-col" style="background-color:#2E4636;">
        <div class="p-5 border-b border-white/10">
            <a href="{{ route('home') }}" class="font-display text-xl font-bold text-white tracking-wide">
                Byiza Lodge <span class="font-sans text-xs font-normal text-white/50 align-middle">Admin</span>
            </a>
        </div>
        <nav class="flex-1 overflow-y-auto sidebar-scroll p-3 space-y-1">
            @foreach($links as $link)
            @php $active = $isActive($link['route']); @endphp
            <a href="{{ route($link['route']) }}"
               class="relative flex items-center gap-3 px-4 py-3 min-h-[44px] rounded-xl text-sm font-medium transition
                      {{ $active ? 'bg-white/15 text-white' : 'text-white/65 hover:bg-white/10 hover:text-white' }}">
                @if($active)
                <span class="absolute left-0 top-1/2 -translate-y-1/2 h-5 w-1 rounded-r-full" style="background:#C9A24B;"></span>
                @endif
                <x-admin-icon :name="$link['icon']" class="w-5 h-5 shrink-0 {{ $active ? 'text-[#C9A24B]' : '' }}" />
                {{ $link['label'] }}
            </a>
            @endforeach
        </nav>
    </aside>

    {{-- Main --}}
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
        {{-- Top bar --}}
        <header class="sticky top-0 z-30 bg-white/90 backdrop-blur border-b border-gray-200 px-4 sm:px-6 py-3 flex justify-between items-center gap-3">
            <div class="flex items-center gap-2.5 min-w-0">
                <span class="lg:hidden w-8 h-8 rounded-lg flex items-center justify-center text-white font-display font-bold text-sm shrink-0" style="background:#2E4636;">B</span>
                <h1 class="text-base sm:text-lg font-semibold text-gray-800 truncate">@yield('title', 'Dashboard')</h1>
            </div>

            {{-- User menu --}}
            <div class="relative shrink-0" x-data="{ open: false }" @keydown.escape.window="open = false">
                <button @click="open = !open"
                        class="flex items-center gap-2.5 pl-2 pr-3 py-1.5 min-h-[44px] rounded-full hover:bg-gray-100 transition"
                        :aria-expanded="open">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-semibold text-white shrink-0" style="background:#6E8C5A;">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <span class="hidden sm:flex flex-col items-start leading-tight">
                        <span class="text-sm font-medium text-gray-800">{{ auth()->user()->name }}</span>
                        <span class="text-xs text-gray-400 capitalize">{{ auth()->user()->getRoleNames()->first() }}</span>
                    </span>
                    <x-admin-icon name="chevron-right" class="hidden sm:block w-4 h-4 text-gray-400 rotate-90 transition" x-bind:class="open ? '-rotate-90' : ''" />
                </button>

                <div x-show="open" x-cloak @click.outside="open = false"
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     class="absolute right-0 mt-2 w-52 bg-white rounded-xl shadow-lg border border-gray-100 py-1.5 z-50">
                    <div class="sm:hidden px-4 py-2 border-b border-gray-100 mb-1">
                        <p class="text-sm font-medium text-gray-800 truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-400 capitalize">{{ auth()->user()->getRoleNames()->first() }}</p>
                    </div>
                    <a href="{{ route('home') }}" class="flex items-center gap-2.5 px-4 py-2.5 min-h-[44px] text-sm text-gray-600 hover:bg-gray-50">
                        <x-admin-icon name="external" class="w-4 h-4 text-gray-400" /> Public Site
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center gap-2.5 px-4 py-2.5 min-h-[44px] w-full text-left text-sm text-red-600 hover:bg-red-50">
                            <x-admin-icon name="logout" class="w-4 h-4" /> Logout
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-auto admin-main p-4 sm:p-6 pb-28 lg:pb-6">
            @if(session('success'))
            <div class="mb-4 px-4 py-3 rounded-xl text-sm flex items-center gap-2" style="background:#6E8C5A20;color:#2E4636;border:1px solid #6E8C5A;">
                <x-admin-icon name="check" class="w-4 h-4 shrink-0" />
                {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="mb-4 px-4 py-3 rounded-xl text-sm bg-red-50 text-red-700 border border-red-200 flex items-center gap-2">
                <x-admin-icon name="alert-triangle" class="w-4 h-4 shrink-0" />
                {{ session('error') }}
            </div>
            @endif
            @if($errors->any())
            <div class="mb-4 px-4 py-3 rounded-xl text-sm bg-red-50 text-red-700 border border-red-200 flex items-center gap-2">
                <x-admin-icon name="alert-triangle" class="w-4 h-4 shrink-0" />
                {{ $errors->first() }}
            </div>
            @endif
            @yield('content')
        </main>
    </div>
</div>

{{-- Mobile bottom tab bar (app-style) --}}
<nav class="lg:hidden fixed bottom-0 inset-x-0 z-40 bg-white border-t border-gray-200 shadow-[0_-4px_16px_rgba(0,0,0,0.06)]"
     style="padding-bottom: env(safe-area-inset-bottom);">
    <div class="grid grid-cols-5">
        @foreach($tabLinks as $link)
        @php $active = $isActive($link['route']); @endphp
        <a href="{{ route($link['route']) }}"
           class="flex flex-col items-center justify-center gap-1 py-2 min-h-[56px] text-[10px] font-medium transition {{ $active ? '' : 'text-gray-400 active:text-gray-600' }}"
           style="{{ $active ? 'color:#2E4636;' : '' }}">
            <span class="relative flex items-center justify-center w-12 h-7 rounded-full transition" style="{{ $active ? 'background:#2E463614;' : '' }}">
                <x-admin-icon :name="$link['icon']" class="w-5 h-5" style="{{ $active ? 'color:#C9A24B;' : '' }}" />
            </span>
            {{ $link['label'] }}
        </a>
        @endforeach
        @php $moreActive = ! collect($tabLinks)->contains(fn ($l) => $isActive($l['route'])); @endphp
        <button @click="moreOpen = true"
                class="flex flex-col items-center justify-center gap-1 py-2 min-h-[56px] text-[10px] font-medium {{ $moreActive ? '' : 'text-gray-400 active:text-gray-600' }}"
                style="{{ $moreActive ? 'color:#2E4636;' : '' }}">
            <span class="flex items-center justify-center w-12 h-7 rounded-full" style="{{ $moreActive ? 'background:#2E463614;' : '' }}">
                <x-admin-icon name="menu" class="w-5 h-5" style="{{ $moreActive ? 'color:#C9A24B;' : '' }}" />
            </span>
            More
        </button>
    </div>
</nav>

{{-- Mobile "More" bottom sheet --}}
<div class="lg:hidden">
    <div x-show="moreOpen" x-cloak x-transition.opacity
         @click="moreOpen = false"
         class="fixed inset-0 z-50 bg-black/50"></div>

    <div x-show="moreOpen" x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="translate-y-full"
         x-transition:enter-end="translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="translate-y-0"
         x-transition:leave-end="translate-y-full"
         class="fixed bottom-0 inset-x-0 z-[60] bg-white rounded-t-3xl shadow-2xl"
         style="padding-bottom: env(safe-area-inset-bottom);">

        <div class="flex justify-center pt-3 pb-1" @click="moreOpen = false">
            <span class="w-10 h-1.5 rounded-full bg-gray-300"></span>
        </div>

        <div class="px-5 pb-2 flex items-center justify-between">
            <h2 class="text-sm font-semibold text-gray-800">More</h2>
            <button @click="moreOpen = false" class="p-2 -mr-2 text-gray-400 active:text-gray-600" aria-label="Close">
                <x-admin-icon name="x-mark" class="w-5 h-5" />
            </button>
        </div>

        <div class="grid grid-cols-4 gap-2 px-4 pb-4">
            @foreach(array_slice($links, 4) as $link)
            @php $active = $isActive($link['route']); @endphp
            <a href="{{ route($link['route']) }}"
               class="flex flex-col items-center gap-1.5 py-3 rounded-2xl text-[11px] font-medium transition {{ $active ? '' : 'text-gray-500 active:bg-gray-100' }}"
               style="{{ $active ? 'color:#2E4636;background:#2E46360d;' : '' }}">
                <span class="w-11 h-11 rounded-2xl flex items-center justify-center" style="background:{{ $active ? '#2E463618' : '#F3F4F6' }};">
                    <x-admin-icon :name="$link['icon']" class="w-5 h-5" style="color:{{ $active ? '#C9A24B' : '#6B7280' }};" />
                </span>
                {{ $link['label'] }}
            </a>
            @endforeach
        </div>

        <div class="border-t border-gray-100 px-4 py-2 grid grid-cols-2 gap-2">
            <a href="{{ route('home') }}" class="flex items-center justify-center gap-2 py-3 min-h-[44px] rounded-xl text-sm font-medium text-gray-600 active:bg-gray-100">
                <x-admin-icon name="external" class="w-4 h-4 text-gray-400" /> Public Site
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 py-3 min-h-[44px] rounded-xl text-sm font-medium text-red-600 active:bg-red-50">
                    <x-admin-icon name="logout" class="w-4 h-4" /> Logout
                </button>
            </form>
        </div>
    </div>
</div>

<x-confirm-modal />

@stack('scripts')
</body>
</html>
