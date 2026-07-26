<style>
    .rnav-link { position: relative; color: rgba(255,255,255,0.72); transition: color .25s ease; }
    .rnav-link:hover, .rnav-link.is-active { color: #fff; }
    .rnav-link::after { content:''; position:absolute; left:0; right:0; bottom:-4px; height:2px; background:#C99A52; transform:scaleX(0); transform-origin:left; transition:transform .3s ease; }
    .rnav-link:hover::after, .rnav-link.is-active::after { transform: scaleX(1); }
    .rnav-wordmark:hover .rnav-dot { transform: scale(1.4); }
    .rnav-dot { transition: transform .3s ease; }
</style>
<nav x-data="{ open: false, scrolled: false }" x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 40)"
     @keydown.escape.window="open = false"
     :class="scrolled ? 'shadow-lg' : ''"
     class="fixed top-0 inset-x-0 z-50 transition-all duration-300"
     :style="scrolled ? 'background-color:#1E3A4A;' : 'background-color:transparent;'">

    {{-- Legibility scrim over hero images (fades out once scrolled) --}}
    <div x-show="!scrolled" x-transition.opacity class="pointer-events-none absolute inset-x-0 top-0 h-28" style="background:linear-gradient(to bottom, rgba(12,26,33,0.55), transparent);"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16 lg:h-20">

            {{-- Wordmark --}}
            <a href="{{ route('home') }}" class="rnav-wordmark flex items-baseline gap-2 shrink-0">
                <span class="font-display text-2xl lg:text-[1.7rem] font-bold tracking-tight text-white">Rirenga</span>
                <span class="rnav-dot inline-block w-1.5 h-1.5 rounded-full self-center" style="background:#C99A52;"></span>
                <span class="hidden sm:inline text-[0.58rem] font-semibold uppercase tracking-[0.3em]" style="color:rgba(201,162,82,0.95);">Treat&nbsp;Ltd</span>
            </a>

            @php
                $navLinks = [
                    ['route' => 'home', 'icon' => 'home', 'label' => __('nav.home'), 'exact' => true],
                    ['route' => 'rooms', 'icon' => 'bed', 'label' => __('nav.rooms')],
                    ['route' => 'restaurant', 'icon' => 'utensils', 'label' => __('nav.restaurant')],
                    ['route' => 'bar', 'icon' => 'cocktail', 'label' => __('nav.bar')],
                    ['route' => 'gallery', 'icon' => 'photo', 'label' => __('nav.gallery')],
                    ['route' => 'blog', 'icon' => 'newspaper', 'label' => __('nav.blog')],
                    ['route' => 'about', 'icon' => 'info', 'label' => __('nav.about')],
                    ['route' => 'contact', 'icon' => 'envelope', 'label' => __('nav.contact')],
                ];
            @endphp

            {{-- Desktop Nav (text-only, editorial) --}}
            <div class="hidden lg:flex items-center gap-7 text-[0.72rem] font-semibold uppercase tracking-[0.14em]">
                @foreach($navLinks as $link)
                @php $active = ($link['exact'] ?? false) ? request()->routeIs($link['route']) : request()->routeIs($link['route'].'*'); @endphp
                <a href="{{ route($link['route']) }}"
                   class="rnav-link {{ $active ? 'is-active' : '' }} py-1.5 whitespace-nowrap">
                    {{ $link['label'] }}
                </a>
                @endforeach
            </div>

            {{-- Right: Lang, Auth, Book --}}
            <div class="hidden lg:flex items-center gap-4 text-xs whitespace-nowrap">
                {{-- Language switcher --}}
                <div class="flex items-center gap-2 text-[0.7rem] font-semibold tracking-wider" style="color:rgba(255,255,255,0.5);">
                    <a href="{{ route('locale.set', 'en') }}"
                       style="color:{{ app()->getLocale() === 'en' ? '#ffffff' : 'inherit' }};" class="hover:opacity-70">EN</a>
                    <span style="opacity:0.5;">/</span>
                    <a href="{{ route('locale.set', 'fr') }}"
                       style="color:{{ app()->getLocale() === 'fr' ? '#ffffff' : 'inherit' }};" class="hover:opacity-70">FR</a>
                </div>

                @auth
                    <div class="relative" x-data="{ userMenu: false }" @keydown.escape.window="userMenu = false">
                        <button @click="userMenu = !userMenu"
                                class="flex items-center gap-1.5 py-1 transition" :aria-expanded="userMenu">
                            <span class="w-7 h-7 rounded-full flex items-center justify-center text-[11px] font-bold text-white shrink-0" style="background:#3F7C8A;">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </span>
                            <span class="font-medium max-w-[110px] truncate text-white">{{ Str::before(auth()->user()->name, ' ') }}</span>
                            <x-admin-icon name="chevron-right" class="w-3 h-3 rotate-90 transition" style="color:rgba(255,255,255,0.55);" x-bind:class="userMenu ? '-rotate-90' : 'rotate-90'" />
                        </button>

                        <div x-show="userMenu" x-cloak @click.outside="userMenu = false"
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             class="absolute right-0 mt-3 w-52 bg-white shadow-lg border border-gray-100 py-1.5 z-50 text-gray-700 text-sm" style="border-radius:2px;">
                            <div class="px-4 py-2 border-b border-gray-100 mb-1">
                                <p class="font-semibold text-gray-800 truncate">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-400 truncate">{{ auth()->user()->email }}</p>
                            </div>
                            @if(auth()->user()->hasRole(['director','manager','staff']))
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 px-4 py-2.5 hover:bg-gray-50">
                                <x-admin-icon name="dashboard" class="w-4 h-4 text-gray-400" /> {{ __('nav.admin') }}
                            </a>
                            @else
                            <a href="{{ route('portal.dashboard') }}" class="flex items-center gap-2.5 px-4 py-2.5 hover:bg-gray-50">
                                <x-admin-icon name="users" class="w-4 h-4 text-gray-400" /> {{ __('nav.my_account') }}
                            </a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center gap-2.5 px-4 py-2.5 w-full text-left text-red-600 hover:bg-red-50">
                                    <x-admin-icon name="logout" class="w-4 h-4" /> {{ __('nav.logout') }}
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-[0.72rem] font-semibold uppercase tracking-[0.14em] transition hover:opacity-70" style="color:rgba(255,255,255,0.68);">{{ __('nav.login') }}</a>
                @endauth

                <a href="{{ route('booking') }}" class="ed-btn ed-btn-solid" style="padding:0.6rem 1.4rem;">{{ __('nav.book_now') }}</a>
            </div>

            {{-- Mobile menu button --}}
            <button @click="open = true" class="lg:hidden p-2 -mr-2 focus:outline-none text-white" aria-label="Open menu">
                <x-admin-icon name="menu" class="w-6 h-6" />
            </button>
        </div>
    </div>

    {{-- Mobile backdrop --}}
    <div x-show="open" x-cloak x-transition.opacity
         @click="open = false"
         class="fixed inset-0 z-[60] bg-black/50 lg:hidden"></div>

    {{-- Mobile slide-in drawer --}}
    <div x-show="open" x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="translate-x-full"
         @click.outside="open = false"
         class="fixed inset-y-0 right-0 z-[70] w-80 max-w-[85vw] flex flex-col shadow-2xl lg:hidden"
         style="background-color:#1E3A4A;">

        <div class="flex items-center justify-between p-5 border-b border-white/10">
            <span class="font-display text-lg font-bold text-white tracking-wide">Rirenga <span class="font-sans text-[0.55rem] font-semibold uppercase tracking-[0.25em] align-middle" style="color:#C99A52;">Treat Ltd</span></span>
            <button @click="open = false" class="text-white/70 hover:text-white p-2 -mr-2" aria-label="Close menu">
                <x-admin-icon name="x-mark" class="w-5 h-5" />
            </button>
        </div>

        <nav class="flex-1 overflow-y-auto sidebar-scroll p-4 space-y-1">
            @foreach($navLinks as $link)
            @php $active = ($link['exact'] ?? false) ? request()->routeIs($link['route']) : request()->routeIs($link['route'].'*'); @endphp
            <a href="{{ route($link['route']) }}" @click="open=false"
               class="relative flex items-center gap-3 px-4 py-3 min-h-[44px] text-sm font-semibold uppercase tracking-wider transition
                      {{ $active ? 'bg-white/15 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}" style="border-radius:2px;">
                @if($active)
                <span class="absolute left-0 top-1/2 -translate-y-1/2 h-5 w-1" style="background:#C99A52;"></span>
                @endif
                <x-admin-icon :name="$link['icon']" class="w-5 h-5 shrink-0 {{ $active ? 'text-[#C99A52]' : '' }}" />
                {{ $link['label'] }}
            </a>
            @endforeach
        </nav>

        <div class="p-4 border-t border-white/10 space-y-3">
            <div class="flex gap-2">
                <a href="{{ route('locale.set', 'en') }}"
                   class="flex-1 text-center text-xs font-medium px-3 py-2 min-h-[40px] flex items-center justify-center transition {{ app()->getLocale() === 'en' ? 'bg-white/20 text-white' : 'text-white/60 hover:text-white hover:bg-white/10' }}" style="border-radius:2px;">EN</a>
                <a href="{{ route('locale.set', 'fr') }}"
                   class="flex-1 text-center text-xs font-medium px-3 py-2 min-h-[40px] flex items-center justify-center transition {{ app()->getLocale() === 'fr' ? 'bg-white/20 text-white' : 'text-white/60 hover:text-white hover:bg-white/10' }}" style="border-radius:2px;">FR</a>
            </div>

            @auth
                <div class="flex items-center gap-2.5 px-2 py-2">
                    <span class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white shrink-0" style="background:#3F7C8A;">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </span>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                        <p class="text-[11px] text-white/50 truncate">{{ auth()->user()->email }}</p>
                    </div>
                </div>
                @if(auth()->user()->hasRole(['director','manager','staff']))
                    <a href="{{ route('admin.dashboard') }}" @click="open=false" class="flex items-center gap-2.5 px-2 py-2 min-h-[40px] text-sm text-white/70 hover:text-white">
                        <x-admin-icon name="dashboard" class="w-4 h-4" /> {{ __('nav.admin') }}
                    </a>
                @else
                    <a href="{{ route('portal.dashboard') }}" @click="open=false" class="flex items-center gap-2.5 px-2 py-2 min-h-[40px] text-sm text-white/70 hover:text-white">
                        <x-admin-icon name="users" class="w-4 h-4" /> {{ __('nav.my_account') }}
                    </a>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-2.5 px-2 py-2 min-h-[40px] w-full text-left text-sm text-white/70 hover:text-white">
                        <x-admin-icon name="logout" class="w-4 h-4" /> {{ __('nav.logout') }}
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" @click="open=false" class="flex items-center gap-2.5 px-2 py-2 min-h-[40px] text-sm text-white/70 hover:text-white">
                    <x-admin-icon name="external" class="w-4 h-4" /> {{ __('nav.login') }}
                </a>
            @endauth

            <a href="{{ route('booking') }}" @click="open=false"
               class="block text-center px-4 py-3 min-h-[44px] text-white font-semibold uppercase tracking-wider transition hover:opacity-90"
               style="background-color:#D07A54;border-radius:2px;">{{ __('nav.book_now') }}</a>
        </div>
    </div>
</nav>
