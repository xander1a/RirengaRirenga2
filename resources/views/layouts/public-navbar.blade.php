<nav x-data="{ open: false, scrolled: false }" x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 50)"
     @keydown.escape.window="open = false"
     :class="scrolled ? 'shadow-lg' : ''"
     class="sticky top-0 z-50 transition-shadow duration-300"
     style="background-color:#2E4636;">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16 lg:h-20">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center shrink-0">
                <span class="font-display text-xl font-bold text-white tracking-wide">Byiza Lodge</span>
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

            {{-- Desktop Nav --}}
            <div class="hidden lg:flex items-center text-xs font-medium">
                @foreach($navLinks as $link)
                @php $active = ($link['exact'] ?? false) ? request()->routeIs($link['route']) : request()->routeIs($link['route'].'*'); @endphp
                <a href="{{ route($link['route']) }}"
                   class="relative flex items-center gap-1 px-2 py-1.5 rounded-lg whitespace-nowrap transition {{ $active ? 'bg-white/10 text-white' : 'text-white/75 hover:text-white hover:bg-white/5' }}">
                    <x-admin-icon :name="$link['icon']" class="w-3.5 h-3.5 shrink-0" style="{{ $active ? 'color:#C9A24B;' : '' }}" />
                    {{ $link['label'] }}
                    @if($active)
                    <span class="absolute -bottom-0.5 left-2 right-2 h-0.5 rounded-full" style="background:#C9A24B;"></span>
                    @endif
                </a>
                @endforeach
            </div>

            {{-- Right: Lang, Auth, Book --}}
            <div class="hidden lg:flex items-center gap-1.5 text-xs whitespace-nowrap">
                {{-- Language switcher --}}
                <div class="flex items-center rounded-lg overflow-hidden border border-white/15 text-[11px]">
                    <a href="{{ route('locale.set', 'en') }}"
                       class="px-2 py-1 transition {{ app()->getLocale() === 'en' ? 'bg-white/20 text-white font-semibold' : 'text-white/60 hover:text-white' }}">EN</a>
                    <a href="{{ route('locale.set', 'fr') }}"
                       class="px-2 py-1 transition {{ app()->getLocale() === 'fr' ? 'bg-white/20 text-white font-semibold' : 'text-white/60 hover:text-white' }}">FR</a>
                </div>

                @auth
                    <div class="relative" x-data="{ userMenu: false }" @keydown.escape.window="userMenu = false">
                        <button @click="userMenu = !userMenu"
                                class="flex items-center gap-1.5 pl-1 pr-2 py-1 rounded-full transition hover:bg-white/10"
                                :class="userMenu ? 'bg-white/10' : ''" :aria-expanded="userMenu">
                            <span class="w-6 h-6 rounded-full flex items-center justify-center text-[11px] font-bold text-white shrink-0" style="background:#6E8C5A;">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </span>
                            <span class="text-white font-medium max-w-[110px] truncate">{{ Str::before(auth()->user()->name, ' ') }}</span>
                            <x-admin-icon name="chevron-right" class="w-3 h-3 text-white/50 rotate-90 transition" x-bind:class="userMenu ? '-rotate-90' : 'rotate-90'" />
                        </button>

                        <div x-show="userMenu" x-cloak @click.outside="userMenu = false"
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             class="absolute right-0 mt-2 w-52 bg-white rounded-xl shadow-lg border border-gray-100 py-1.5 z-50 text-gray-700 text-sm">
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
                    <a href="{{ route('login') }}" class="px-2 py-1.5 rounded-lg text-white/75 hover:text-white hover:bg-white/5 transition">{{ __('nav.login') }}</a>
                @endauth

                <a href="{{ route('booking') }}"
                   class="ml-1 px-3.5 py-1.5 rounded-full text-white text-xs font-semibold transition hover:opacity-90"
                   style="background-color:#BF6B47;">{{ __('nav.book_now') }}</a>
            </div>

            {{-- Mobile menu button --}}
            <button @click="open = true" class="lg:hidden text-white p-2 -mr-2 focus:outline-none" aria-label="Open menu">
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
         style="background-color:#2E4636;">

        <div class="flex items-center justify-between p-5 border-b border-white/10">
            <span class="font-display text-lg font-bold text-white tracking-wide">Byiza <span class="font-sans text-xs font-normal text-white/50 align-middle">Lodge Ltd</span></span>
            <button @click="open = false" class="text-white/70 hover:text-white p-2 -mr-2" aria-label="Close menu">
                <x-admin-icon name="x-mark" class="w-5 h-5" />
            </button>
        </div>

        <nav class="flex-1 overflow-y-auto sidebar-scroll p-4 space-y-1">
            @foreach($navLinks as $link)
            @php $active = ($link['exact'] ?? false) ? request()->routeIs($link['route']) : request()->routeIs($link['route'].'*'); @endphp
            <a href="{{ route($link['route']) }}" @click="open=false"
               class="relative flex items-center gap-3 px-4 py-3 min-h-[44px] rounded-xl text-sm font-medium transition
                      {{ $active ? 'bg-white/15 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                @if($active)
                <span class="absolute left-0 top-1/2 -translate-y-1/2 h-5 w-1 rounded-r-full" style="background:#C9A24B;"></span>
                @endif
                <x-admin-icon :name="$link['icon']" class="w-5 h-5 shrink-0 {{ $active ? 'text-[#C9A24B]' : '' }}" />
                {{ $link['label'] }}
            </a>
            @endforeach
        </nav>

        <div class="p-4 border-t border-white/10 space-y-3">
            <div class="flex gap-2">
                <a href="{{ route('locale.set', 'en') }}"
                   class="flex-1 text-center text-xs font-medium px-3 py-2 min-h-[40px] flex items-center justify-center rounded-lg transition {{ app()->getLocale() === 'en' ? 'bg-white/20 text-white' : 'text-white/60 hover:text-white hover:bg-white/10' }}">EN</a>
                <a href="{{ route('locale.set', 'fr') }}"
                   class="flex-1 text-center text-xs font-medium px-3 py-2 min-h-[40px] flex items-center justify-center rounded-lg transition {{ app()->getLocale() === 'fr' ? 'bg-white/20 text-white' : 'text-white/60 hover:text-white hover:bg-white/10' }}">FR</a>
            </div>

            @auth
                <div class="flex items-center gap-2.5 px-2 py-2">
                    <span class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white shrink-0" style="background:#6E8C5A;">
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
               class="block text-center px-4 py-3 min-h-[44px] rounded-xl text-white font-semibold transition hover:opacity-90"
               style="background-color:#BF6B47;">{{ __('nav.book_now') }}</a>
        </div>
    </div>
</nav>
