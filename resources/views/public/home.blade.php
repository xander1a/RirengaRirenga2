@extends('layouts.public')

@section('title', 'Home')

@section('content')

{{-- HERO --}}
@php $heroImg = site_image('home_hero'); @endphp
<section class="relative flex items-center justify-center overflow-hidden pt-32 pb-40 sm:min-h-[88vh]"
         @if($heroImg)
         style="background-image: linear-gradient(to bottom, rgba(26,46,34,0.45), rgba(26,46,34,0.65)), url('{{ $heroImg }}'); background-size: cover; background-position: center;"
         @else
         style="background: linear-gradient(135deg, #2E4636 0%, #3d5c48 50%, #1a2e22 100%);"
         @endif>
    @unless($heroImg)
    <div class="absolute inset-0 opacity-20"
         style="background-image: url(\"data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.4'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E\");"></div>
    @endunless

    <div class="relative z-10 text-center px-4 max-w-4xl mx-auto w-full">
        <p class="text-sm font-light tracking-[0.3em] uppercase mb-4" style="color:#C9A24B;">Rwanda · Eco-lodge</p>
        <h1 class="font-display text-4xl sm:text-6xl lg:text-7xl font-bold text-white leading-tight mb-6 drop-shadow">
            {{ __('home.hero_title') }}
        </h1>
        <p class="text-lg sm:text-xl text-white/85 max-w-2xl mx-auto mb-10 leading-relaxed">
            {{ __('home.hero_subtitle') }}
        </p>

        {{-- Booking search card (trip.com style) --}}
        <form action="{{ route('booking') }}" method="GET"
              class="bg-white rounded-2xl shadow-2xl p-4 sm:p-5 grid sm:grid-cols-[1fr_1fr_auto_auto] gap-3 items-end text-left max-w-3xl mx-auto">
            <div>
                <label class="block text-[11px] font-semibold uppercase tracking-wide text-gray-400 mb-1">Check-in</label>
                <input type="date" name="check_in" min="{{ now()->toDateString() }}" value="{{ now()->toDateString() }}"
                       class="w-full rounded-xl border border-gray-200 px-3 py-2.5 min-h-[46px] text-sm text-gray-700 focus:outline-none focus:border-[#6E8C5A]">
            </div>
            <div>
                <label class="block text-[11px] font-semibold uppercase tracking-wide text-gray-400 mb-1">Check-out</label>
                <input type="date" name="check_out" min="{{ now()->addDay()->toDateString() }}" value="{{ now()->addDay()->toDateString() }}"
                       class="w-full rounded-xl border border-gray-200 px-3 py-2.5 min-h-[46px] text-sm text-gray-700 focus:outline-none focus:border-[#6E8C5A]">
            </div>
            <div>
                <label class="block text-[11px] font-semibold uppercase tracking-wide text-gray-400 mb-1">Guests</label>
                <select name="guests" class="rounded-xl border border-gray-200 px-3 py-2.5 min-h-[46px] text-sm text-gray-700 focus:outline-none focus:border-[#6E8C5A]">
                    @foreach(range(1, 4) as $n)
                    <option value="{{ $n }}">{{ $n }} {{ Str::plural('guest', $n) }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit"
                    class="flex items-center justify-center gap-2 px-6 py-2.5 min-h-[46px] rounded-xl text-white font-semibold transition hover:opacity-90"
                    style="background-color:#BF6B47;">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 10.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z"/></svg>
                {{ __('home.hero_cta') }}
            </button>
        </form>
    </div>

    {{-- Scroll indicator --}}
    <div class="absolute bottom-6 left-1/2 -translate-x-1/2 text-white/50 animate-bounce hidden sm:block">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </div>
</section>

{{-- INTRO --}}
<section class="py-20 px-4">
    <div class="max-w-7xl mx-auto grid lg:grid-cols-2 gap-12 items-center">
        <div data-reveal>
            <p class="text-sm font-semibold uppercase tracking-widest mb-2" style="color:#BF6B47;">Our Story</p>
            <h2 class="font-display text-4xl lg:text-5xl font-bold mb-6" style="color:#2E4636;">
                {{ __('home.intro_title') }}
            </h2>
            <p class="text-lg leading-relaxed text-gray-600 mb-8">{{ __('home.intro_body') }}</p>
            <a href="{{ route('about') }}" class="inline-flex items-center gap-2 font-semibold hover:gap-3 transition-all" style="color:#BF6B47;">
                Learn Our Story
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
        <div class="grid grid-cols-2 gap-4" data-reveal>
            @foreach([
                ['key'=>'story_1','icon'=>'leaf','bg'=>'#6E8C5A26','color'=>'#2E4636','class'=>''],
                ['key'=>'story_2','icon'=>'bird','bg'=>'#BF6B4722','color'=>'#BF6B47','class'=>'mt-8'],
                ['key'=>'story_3','icon'=>'mountain','bg'=>'#C9A24B22','color'=>'#9c7d36','class'=>'-mt-4'],
                ['key'=>'story_4','icon'=>'sprout','bg'=>'#2E463622','color'=>'#2E4636','class'=>''],
            ] as $tile)
            <div class="aspect-square rounded-2xl overflow-hidden shadow-sm {{ $tile['class'] }}">
                @if($src = site_image($tile['key']))
                <img src="{{ $src }}" alt="Byiza Lodge Ltd" class="w-full h-full object-cover hover:scale-105 transition duration-500">
                @else
                <x-icon-tile :icon="$tile['icon']" :bg="$tile['bg']" :color="$tile['color']" />
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- WHAT WE OFFER --}}
<section class="py-20 px-4" style="background-color:#2E4636;">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-14">
            <p class="text-sm font-semibold uppercase tracking-widest mb-2" style="color:#C9A24B;">The Experience</p>
            <h2 class="font-display text-3xl lg:text-4xl font-bold text-white">{{ __('home.amenities_title') }}</h2>
        </div>

        <div class="space-y-14 lg:space-y-20">
            @foreach([
                ['key'=>'offer_stay', 'icon'=>'bed', 'eyebrow'=>'Stay', 'title'=>__('home.amenity_stay'),
                 'desc'=>'5 self-contained rooms with private terraces, ensuite bathrooms, and forest views. Every stay includes dinner & breakfast prepared with local ingredients.',
                 'cta'=>['label'=>'Explore Rooms', 'route'=>'rooms']],
                ['key'=>'offer_dining', 'icon'=>'dish', 'eyebrow'=>'Taste', 'title'=>__('home.amenity_food'),
                 'desc'=>'Farm-to-table restaurant, craft cocktail bar, and curated beverages from Rwanda and beyond — enjoyed indoors or on the terrace overlooking the hills.',
                 'cta'=>['label'=>'View the Menu', 'route'=>'restaurant']],
                ['key'=>'offer_hiking', 'icon'=>'mountain', 'eyebrow'=>'Explore', 'title'=>__('home.amenity_hike'),
                 'desc'=>'Guided trails ranging from easy forest walks to challenging summit hikes — all starting right from our doorstep, led by local guides who know every path.',
                 'cta'=>['label'=>'Plan Your Visit', 'route'=>'contact']],
            ] as $i => $offer)
            <div class="grid lg:grid-cols-2 gap-8 lg:gap-14 items-center" data-reveal>
                {{-- Image --}}
                <div class="relative rounded-3xl overflow-hidden shadow-xl aspect-[3/2] {{ $i % 2 === 1 ? 'lg:order-2' : '' }}">
                    @if($src = site_image($offer['key']))
                    <img src="{{ $src }}" alt="{{ $offer['title'] }}" class="w-full h-full object-cover hover:scale-105 transition duration-700">
                    @else
                    <x-icon-tile :icon="$offer['icon']" bg="rgba(255,255,255,0.08)" color="#C9A24B" />
                    @endif
                    <span class="absolute top-4 left-4 px-3 py-1 rounded-full text-[11px] font-semibold uppercase tracking-widest text-white pointer-events-none" style="background:rgba(46,70,54,0.75);backdrop-filter:blur(4px);">
                        {{ $offer['eyebrow'] }}
                    </span>
                </div>

                {{-- Text --}}
                <div class="{{ $i % 2 === 1 ? 'lg:order-1 lg:text-right' : '' }}">
                    <div class="w-12 h-12 rounded-2xl overflow-hidden mb-5 {{ $i % 2 === 1 ? 'lg:ml-auto' : '' }}">
                        <x-icon-tile :icon="$offer['icon']" bg="#C9A24B25" color="#C9A24B" />
                    </div>
                    <h3 class="font-display text-2xl lg:text-3xl font-bold text-white mb-4">{{ $offer['title'] }}</h3>
                    <p class="text-white/70 leading-relaxed mb-6 max-w-lg {{ $i % 2 === 1 ? 'lg:ml-auto' : '' }}">{{ $offer['desc'] }}</p>
                    <a href="{{ route($offer['cta']['route']) }}"
                       class="inline-flex items-center gap-2 font-semibold text-sm transition hover:gap-3"
                       style="color:#C9A24B;">
                        {{ $offer['cta']['label'] }}
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- FEATURED ROOMS --}}
<section class="py-20 px-4">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-12">
            <p class="text-sm font-semibold uppercase tracking-widest mb-2" style="color:#BF6B47;">Accommodation</p>
            <h2 class="font-display text-4xl lg:text-5xl font-bold mb-3" style="color:#2E4636;">{{ __('home.rooms_title') }}</h2>
            <p class="text-gray-500 max-w-xl mx-auto">{{ __('home.rooms_sub') }}</p>
        </div>

        <div class="space-y-14 lg:space-y-20">
            @foreach($featuredRooms as $i => $rt)
            @php $roomImg = $rt->image ? $rt->image_url : $rt->rooms->firstWhere('image')?->image_url; @endphp
            <div class="grid lg:grid-cols-2 gap-8 lg:gap-14 items-center" data-reveal>
                {{-- Image --}}
                <div class="relative rounded-3xl overflow-hidden shadow-xl aspect-[3/2] {{ $i % 2 === 1 ? 'lg:order-2' : '' }}">
                    @if($roomImg)
                    <img src="{{ $roomImg }}" alt="{{ $rt->name }}" class="w-full h-full object-cover hover:scale-105 transition duration-700">
                    @else
                    <x-icon-tile icon="bed" bg="linear-gradient(135deg, #6E8C5A22, #2E463633)" color="#2E4636" />
                    @endif
                    <span class="absolute top-4 {{ $i % 2 === 1 ? 'right-4' : 'left-4' }} px-4 py-1.5 rounded-full text-sm font-bold text-white shadow pointer-events-none" style="background:rgba(46,70,54,0.85);backdrop-filter:blur(4px);">
                        {{ money($rt->price_per_night, $rt->currency) }}<span class="text-[11px] font-normal text-white/70">/night</span>
                    </span>
                </div>

                {{-- Details --}}
                <div class="{{ $i % 2 === 1 ? 'lg:order-1 lg:text-right' : '' }}">
                    <p class="text-xs font-semibold uppercase tracking-widest mb-2" style="color:#BF6B47;">
                        Sleeps {{ $rt->max_guests }} · Dinner & breakfast included
                    </p>
                    <h3 class="font-display text-2xl lg:text-3xl font-bold mb-4" style="color:#2E4636;">{{ $rt->name }}</h3>
                    <p class="text-gray-600 leading-relaxed mb-5 max-w-lg {{ $i % 2 === 1 ? 'lg:ml-auto' : '' }}">{{ Str::limit($rt->description, 180) }}</p>
                    <div class="flex flex-wrap gap-2 mb-7 {{ $i % 2 === 1 ? 'lg:justify-end' : '' }}">
                        @foreach(array_slice($rt->amenities ?? [], 0, 4) as $amenity)
                        <span class="text-xs px-3 py-1.5 rounded-full" style="background:#F1E9D7;color:#6E8C5A;">✓ {{ $amenity }}</span>
                        @endforeach
                    </div>
                    <div class="flex flex-wrap gap-3 {{ $i % 2 === 1 ? 'lg:justify-end' : '' }}">
                        <a href="{{ route('booking', ['room_type' => $rt->id]) }}"
                           class="px-7 py-3 rounded-xl text-white text-sm font-semibold transition hover:opacity-90"
                           style="background-color:#BF6B47;">Book This Room</a>
                        <a href="{{ route('rooms') }}#room-{{ $rt->code }}"
                           class="px-7 py-3 rounded-xl border-2 text-sm font-semibold transition hover:bg-forest hover:text-white"
                           style="border-color:#2E4636;color:#2E4636;">Details</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-10">
            <a href="{{ route('rooms') }}" class="inline-block px-8 py-3 rounded-xl border-2 font-semibold transition hover:text-white hover:bg-forest" style="border-color:#2E4636;color:#2E4636;">
                View All Rooms
            </a>
        </div>
    </div>
</section>

{{-- RESTAURANT TEASER --}}
<section class="py-20 px-4" style="background: linear-gradient(to right, #F1E9D7, #e8dcc8);">
    <div class="max-w-7xl mx-auto grid lg:grid-cols-2 gap-12 items-center">
        <div class="grid grid-cols-2 gap-4" data-reveal>
            <div class="aspect-[4/5] rounded-2xl overflow-hidden shadow-sm">
                @if($restaurantImage?->image_url)
                <img src="{{ $restaurantImage->image_url }}" alt="{{ $restaurantImage->name }}" class="w-full h-full object-cover">
                @else
                <x-icon-tile icon="dish" bg="#BF6B4720" color="#BF6B47" />
                @endif
            </div>
            <div class="aspect-[4/5] rounded-2xl overflow-hidden mt-8 shadow-sm">
                @if($src = site_image('dining_2'))
                <img src="{{ $src }}" alt="Dining at Byiza Lodge" class="w-full h-full object-cover">
                @else
                <x-icon-tile icon="wine" bg="#2E463620" color="#2E4636" />
                @endif
            </div>
        </div>
        <div>
            <p class="text-sm font-semibold uppercase tracking-widest mb-2" style="color:#BF6B47;">Dining</p>
            <h2 class="font-display text-4xl font-bold mb-4" style="color:#2E4636;">{{ __('home.restaurant_title') }}</h2>
            <p class="text-gray-600 leading-relaxed mb-6">{{ __('home.restaurant_body') }}</p>
            <div class="flex gap-4">
                <a href="{{ route('restaurant') }}" class="px-6 py-3 rounded-xl text-white font-semibold transition hover:opacity-90" style="background-color:#BF6B47;">View Menu</a>
                <a href="{{ route('restaurant') }}#reserve" class="px-6 py-3 rounded-xl border-2 font-semibold transition hover:bg-forest hover:text-white" style="border-color:#2E4636;color:#2E4636;">Reserve a Table</a>
            </div>
        </div>
    </div>
</section>

{{-- BAR TEASER --}}
<section class="py-20 px-4" style="background-color:#2E4636;">
    <div class="max-w-7xl mx-auto grid lg:grid-cols-2 gap-12 items-center">
        <div>
            <p class="text-sm font-semibold uppercase tracking-widest mb-2" style="color:#C9A24B;">Bar & Events</p>
            <h2 class="font-display text-4xl font-bold text-white mb-4">{{ __('home.bar_title') }}</h2>
            <p class="text-white/70 leading-relaxed mb-6">{{ __('home.bar_body') }}</p>
            <a href="{{ route('bar') }}" class="px-6 py-3 rounded-xl text-white font-semibold transition hover:opacity-90" style="background-color:#C9A24B;">Explore the Bar</a>
        </div>
        <div class="grid grid-cols-2 gap-4" data-reveal>
            <div class="aspect-[4/5] rounded-2xl overflow-hidden mt-8 shadow-sm">
                @if($src = site_image('bar_1'))
                <img src="{{ $src }}" alt="Bar at Byiza Lodge" class="w-full h-full object-cover">
                @else
                <x-icon-tile icon="cocktail" bg="rgba(255,255,255,0.08)" color="#C9A24B" />
                @endif
            </div>
            <div class="aspect-[4/5] rounded-2xl overflow-hidden shadow-sm">
                @if($barImage?->image_url)
                <img src="{{ $barImage->image_url }}" alt="{{ $barImage->name }}" class="w-full h-full object-cover">
                @else
                <x-icon-tile icon="music" bg="rgba(255,255,255,0.08)" color="#ffffff" />
                @endif
            </div>
        </div>
    </div>
</section>

{{-- BLOG --}}
@if($latestPosts->count())
<section class="py-20 px-4">
    <div class="max-w-6xl mx-auto">
        <div class="flex flex-wrap items-end justify-between gap-4 mb-10">
            <div>
                <p class="text-sm font-semibold uppercase tracking-widest mb-2" style="color:#BF6B47;">Stories & News</p>
                <h2 class="font-display text-4xl font-bold" style="color:#2E4636;">{{ __('home.blog_title') }}</h2>
            </div>
            <a href="{{ route('blog') }}" class="inline-flex items-center gap-2 font-semibold text-sm transition hover:gap-3" style="color:#BF6B47;">
                All Stories
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>

        @php $featured = $latestPosts->first(); $rest = $latestPosts->slice(1); @endphp
        <div class="grid lg:grid-cols-2 gap-8 items-stretch">
            {{-- Featured post --}}
            <a href="{{ route('blog.show', $featured) }}" class="group relative rounded-3xl overflow-hidden shadow-md hover:shadow-xl transition-shadow min-h-[22rem]" data-reveal>
                @if($featured->image_url)
                <img src="{{ $featured->image_url }}" alt="{{ $featured->local_title }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition duration-700">
                @else
                <div class="absolute inset-0"><x-icon-tile icon="newspaper" bg="linear-gradient(135deg, #2E4636, #3d5c48)" color="#C9A24B" /></div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-black/25 to-transparent"></div>
                <div class="absolute bottom-0 inset-x-0 p-7">
                    <p class="text-xs text-white/70 mb-2">{{ $featured->published_at?->format('d M Y') }}</p>
                    <h3 class="font-display text-2xl font-bold text-white mb-2 group-hover:underline decoration-2 underline-offset-4" style="text-decoration-color:#C9A24B;">
                        {{ $featured->local_title }}
                    </h3>
                    <p class="text-sm text-white/80 max-w-md">{{ Str::limit($featured->excerpt ?? '', 110) }}</p>
                </div>
            </a>

            {{-- Other posts --}}
            <div class="flex flex-col gap-6">
                @forelse($rest as $post)
                <a href="{{ route('blog.show', $post) }}" class="group flex gap-5 items-center bg-white rounded-2xl p-4 shadow-sm hover:shadow-md transition-shadow flex-1" data-reveal>
                    <div class="w-28 h-24 sm:w-36 sm:h-28 rounded-xl overflow-hidden shrink-0">
                        @if($post->image_url)
                        <img src="{{ $post->image_url }}" alt="{{ $post->local_title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        @else
                        <x-icon-tile icon="newspaper" bg="#6E8C5A18" color="#6E8C5A" />
                        @endif
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs text-gray-400 mb-1">{{ $post->published_at?->format('d M Y') }}</p>
                        <h3 class="font-display text-lg font-semibold leading-snug mb-1 group-hover:text-terracotta transition" style="color:#2E4636;">
                            {{ $post->local_title }}
                        </h3>
                        <p class="text-sm text-gray-500 line-clamp-2">{{ Str::limit($post->excerpt ?? '', 100) }}</p>
                    </div>
                </a>
                @empty
                <div class="flex-1 rounded-2xl border-2 border-dashed border-gray-200 flex items-center justify-center p-8 text-center">
                    <p class="text-sm text-gray-400">More stories coming soon.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</section>
@endif

{{-- CTA --}}
<section class="py-20 px-4 text-center" style="background: linear-gradient(135deg, #BF6B47, #a85a39);">
    <div class="max-w-2xl mx-auto">
        <h2 class="font-display text-4xl font-bold text-white mb-4">{{ __('home.cta_title') }}</h2>
        <p class="text-white/80 mb-8 text-lg">{{ __('home.cta_body') }}</p>
        <a href="{{ route('booking') }}"
           class="inline-block px-10 py-4 rounded-xl bg-white font-bold text-lg transition hover:scale-105 transform"
           style="color:#BF6B47;">
            {{ __('home.cta_button') }}
        </a>
    </div>
</section>

@endsection
