@extends('layouts.public')

@section('title', 'Home')

@section('content')

{{-- ===================== HERO ===================== --}}
@php $heroImg = site_image('home_hero'); @endphp
<section class="relative overflow-hidden flex items-center pt-24 pb-16 sm:pt-32 sm:pb-24 sm:min-h-[92vh]"
         @if($heroImg)
         style="background-image: linear-gradient(to right, rgba(30,58,74,0.86) 0%, rgba(30,58,74,0.55) 55%, rgba(30,58,74,0.35) 100%), url('{{ $heroImg }}'); background-size: cover; background-position: center;"
         @else
         style="background: linear-gradient(120deg, #1E3A4A 0%, #23485a 55%, #16303d 100%);"
         @endif>

    <div class="relative z-10 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl">
            <h1 class="ed-title ed-title--light" style="font-size:clamp(2.75rem,7vw,5.5rem);">
                {{ __('home.hero_title') }}
            </h1>
            <p class="mt-6 max-w-xl text-lg sm:text-xl leading-relaxed" style="color:rgba(255,255,255,0.85);font-weight:300;">
                {{ __('home.hero_subtitle') }}
            </p>
        </div>

        {{-- Booking search bar --}}
        <form action="{{ route('booking') }}" method="GET"
              class="mt-10 bg-white p-4 sm:p-5 grid sm:grid-cols-[1fr_1fr_auto_auto] gap-3 items-end text-left max-w-3xl"
              style="border-radius:2px;box-shadow:0 24px 60px -20px rgba(0,0,0,0.5);">
            <div>
                <label class="block text-[10px] font-semibold uppercase tracking-[0.16em] text-gray-400 mb-1.5">Check-in</label>
                <input type="date" name="check_in" min="{{ now()->toDateString() }}" value="{{ now()->toDateString() }}"
                       class="w-full border border-gray-200 px-3 py-2.5 min-h-[46px] text-sm text-gray-700 focus:outline-none focus:border-[#3F7C8A]" style="border-radius:2px;">
            </div>
            <div>
                <label class="block text-[10px] font-semibold uppercase tracking-[0.16em] text-gray-400 mb-1.5">Check-out</label>
                <input type="date" name="check_out" min="{{ now()->addDay()->toDateString() }}" value="{{ now()->addDay()->toDateString() }}"
                       class="w-full border border-gray-200 px-3 py-2.5 min-h-[46px] text-sm text-gray-700 focus:outline-none focus:border-[#3F7C8A]" style="border-radius:2px;">
            </div>
            <div>
                <label class="block text-[10px] font-semibold uppercase tracking-[0.16em] text-gray-400 mb-1.5">Guests</label>
                <select name="guests" class="border border-gray-200 px-3 py-2.5 min-h-[46px] text-sm text-gray-700 focus:outline-none focus:border-[#3F7C8A]" style="border-radius:2px;">
                    @foreach(range(1, 4) as $n)
                    <option value="{{ $n }}">{{ $n }} {{ Str::plural('guest', $n) }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="ed-btn ed-btn-solid min-h-[46px]">
                {{ __('home.hero_cta') }}
            </button>
        </form>
    </div>
</section>

{{-- ===================== INTRO ===================== --}}
<section class="py-24 px-4">
    <div class="max-w-7xl mx-auto grid lg:grid-cols-[1fr_1fr] gap-16 items-center">
        <div data-reveal>
            <h2 class="ed-title" style="font-size:clamp(2rem,4vw,3.25rem);">
                {{ __('home.intro_title') }}
            </h2>
            <p class="ed-lede mt-7">{{ __('home.intro_body') }}</p>
            <a href="{{ route('about') }}" class="ed-arrow mt-8">
                Learn more
                <svg fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
        <div class="grid grid-cols-2 gap-4" data-reveal>
            @foreach([
                ['key'=>'story_1','icon'=>'leaf','bg'=>'#3F7C8A26','color'=>'#1E3A4A','class'=>''],
                ['key'=>'story_2','icon'=>'bird','bg'=>'#D07A5422','color'=>'#D07A54','class'=>'mt-10'],
                ['key'=>'story_3','icon'=>'mountain','bg'=>'#C99A5222','color'=>'#9c7d36','class'=>'-mt-6'],
                ['key'=>'story_4','icon'=>'sprout','bg'=>'#1E3A4A22','color'=>'#1E3A4A','class'=>''],
            ] as $tile)
            <div class="ed-frame aspect-[4/5] {{ $tile['class'] }}">
                @if($src = site_image($tile['key']))
                <img src="{{ $src }}" alt="Rirenga" class="hover:scale-105 transition duration-700">
                @else
                <x-icon-tile :icon="$tile['icon']" :bg="$tile['bg']" :color="$tile['color']" />
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ===================== WHAT WE OFFER ===================== --}}
<section class="py-24 px-4" style="background-color:#1E3A4A;">
    <div class="max-w-7xl mx-auto">
        <div class="max-w-2xl mb-16">
            <h2 class="ed-title ed-title--light mt-5" style="font-size:clamp(2rem,4vw,3.25rem);">{{ __('home.amenities_title') }}</h2>
        </div>

        <div class="space-y-20 lg:space-y-28">
            @foreach([
                ['key'=>'offer_stay', 'icon'=>'bed', 'eyebrow'=>'Stay', 'title'=>__('home.amenity_stay'),
                 'desc'=>'5 self-contained rooms with private terraces, ensuite bathrooms, and sweeping city views. Every stay includes dinner & breakfast prepared with local ingredients.',
                 'cta'=>['label'=>'Explore Rooms', 'route'=>'rooms']],
                ['key'=>'offer_dining', 'icon'=>'dish', 'eyebrow'=>'Taste', 'title'=>__('home.amenity_food'),
                 'desc'=>'Farm-to-table restaurant, craft cocktail bar, and curated beverages from Rwanda and beyond — enjoyed indoors or on the terrace overlooking the hills.',
                 'cta'=>['label'=>'View the Menu', 'route'=>'restaurant']],
                ['key'=>'offer_hiking', 'icon'=>'sun', 'eyebrow'=>'Unwind', 'title'=>__('home.amenity_hike'),
                 'desc'=>'End your day on the terrace as the sun sinks over Kigali\'s hills — golden light, cool evening air, and a drink in hand. Our west-facing lounge is made for unforgettable sunsets.',
                 'cta'=>['label'=>'Plan Your Visit', 'route'=>'contact']],
            ] as $i => $offer)
            <div class="grid lg:grid-cols-2 gap-10 lg:gap-16 items-center" data-reveal>
                <div class="ed-frame relative aspect-[4/3] {{ $i % 2 === 1 ? 'lg:order-2' : '' }}">
                    @if($src = site_image($offer['key']))
                    <img src="{{ $src }}" alt="{{ $offer['title'] }}" class="hover:scale-105 transition duration-700">
                    @else
                    <x-icon-tile :icon="$offer['icon']" bg="rgba(255,255,255,0.08)" color="#C99A52" />
                    @endif
                </div>
                <div class="{{ $i % 2 === 1 ? 'lg:order-1' : '' }}">
                    <div class="flex items-center gap-4 mb-5">
                        <span class="ed-index">0{{ $i + 1 }}</span>
                        <span class="ed-kicker ed-kicker--light">{{ $offer['eyebrow'] }}</span>
                    </div>
                    <h3 class="ed-title ed-title--light" style="font-size:clamp(1.75rem,3vw,2.5rem);">{{ $offer['title'] }}</h3>
                    <p class="mt-5 leading-relaxed max-w-lg" style="color:rgba(255,255,255,0.7);">{{ $offer['desc'] }}</p>
                    <a href="{{ route($offer['cta']['route']) }}" class="ed-arrow ed-kicker--light mt-7" style="color:#C99A52;">
                        {{ $offer['cta']['label'] }}
                        <svg fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ===================== FEATURED ROOMS ===================== --}}
<section class="py-24 px-4">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-wrap items-end justify-between gap-6 mb-16">
            <div class="max-w-xl">
                <span class="ed-kicker">Accommodation</span>
                <h2 class="ed-title mt-5" style="font-size:clamp(2rem,4vw,3.25rem);">{{ __('home.rooms_title') }}</h2>
                <p class="ed-lede mt-5">{{ __('home.rooms_sub') }}</p>
            </div>
            <a href="{{ route('rooms') }}" class="ed-arrow">
                View all rooms
                <svg fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>

        <div class="space-y-20 lg:space-y-28">
            @foreach($featuredRooms as $i => $rt)
            @php $roomImg = $rt->image ? $rt->image_url : $rt->rooms->firstWhere('image')?->image_url; @endphp
            <div class="grid lg:grid-cols-2 gap-10 lg:gap-16 items-center" data-reveal>
                <div class="ed-frame relative aspect-[4/3] {{ $i % 2 === 1 ? 'lg:order-2' : '' }}">
                    @if($roomImg)
                    <img src="{{ $roomImg }}" alt="{{ $rt->name }}" class="hover:scale-105 transition duration-700">
                    @else
                    <x-icon-tile icon="bed" bg="linear-gradient(135deg, #3F7C8A22, #1E3A4A33)" color="#1E3A4A" />
                    @endif
                    <span class="absolute top-0 {{ $i % 2 === 1 ? 'right-0' : 'left-0' }} px-4 py-2 text-sm font-semibold text-white" style="background:#1E3A4A;">
                        {{ money($rt->price_per_night, $rt->currency) }}<span class="text-[11px] font-normal" style="color:rgba(255,255,255,0.7);"> / night</span>
                    </span>
                </div>
                <div class="{{ $i % 2 === 1 ? 'lg:order-1' : '' }}">
                    <span class="ed-kicker">Sleeps {{ $rt->max_guests }} &middot; Half-board</span>
                    <h3 class="ed-title mt-5" style="font-size:clamp(1.75rem,3vw,2.5rem);">{{ $rt->name }}</h3>
                    <p class="mt-5 text-gray-600 leading-relaxed max-w-lg">{{ Str::limit($rt->description, 180) }}</p>
                    <div class="flex flex-wrap gap-2 mt-6 mb-8">
                        @foreach(array_slice($rt->amenities ?? [], 0, 4) as $amenity)
                        <span class="text-xs px-3 py-1.5 tracking-wide" style="background:#EFE9DC;color:#3F7C8A;border-radius:2px;">{{ $amenity }}</span>
                        @endforeach
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('booking', ['room_type' => $rt->id]) }}" class="ed-btn ed-btn-solid">Book this room</a>
                        <a href="{{ route('rooms') }}#room-{{ $rt->code }}" class="ed-btn ed-btn-outline">Details</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ===================== RESTAURANT TEASER ===================== --}}
<section class="py-24 px-4" style="background-color:#EFE9DC;">
    <div class="max-w-7xl mx-auto grid lg:grid-cols-2 gap-16 items-center">
        <div class="grid grid-cols-2 gap-4" data-reveal>
            <div class="ed-frame aspect-[4/5]">
                @if($restaurantImage?->image_url)
                <img src="{{ $restaurantImage->image_url }}" alt="{{ $restaurantImage->name }}">
                @else
                <x-icon-tile icon="dish" bg="#D07A5420" color="#D07A54" />
                @endif
            </div>
            <div class="ed-frame aspect-[4/5] mt-10">
                @if($src = site_image('dining_2'))
                <img src="{{ $src }}" alt="Dining at Rirenga">
                @else
                <x-icon-tile icon="wine" bg="#1E3A4A20" color="#1E3A4A" />
                @endif
            </div>
        </div>
        <div data-reveal>
            <span class="ed-kicker">Dining</span>
            <h2 class="ed-title mt-5" style="font-size:clamp(2rem,4vw,3rem);">{{ __('home.restaurant_title') }}</h2>
            <p class="mt-6 text-gray-600 leading-relaxed max-w-lg">{{ __('home.restaurant_body') }}</p>
            <div class="flex flex-wrap gap-3 mt-8">
                <a href="{{ route('restaurant') }}" class="ed-btn ed-btn-solid">View menu</a>
                <a href="{{ route('restaurant') }}#reserve" class="ed-btn ed-btn-outline">Reserve a table</a>
            </div>
        </div>
    </div>
</section>

{{-- ===================== BAR TEASER ===================== --}}
<section class="py-24 px-4" style="background-color:#1E3A4A;">
    <div class="max-w-7xl mx-auto grid lg:grid-cols-2 gap-16 items-center">
        <div data-reveal>
            <span class="ed-kicker ed-kicker--light">Bar &amp; Events</span>
            <h2 class="ed-title ed-title--light mt-5" style="font-size:clamp(2rem,4vw,3rem);">{{ __('home.bar_title') }}</h2>
            <p class="mt-6 leading-relaxed max-w-lg" style="color:rgba(255,255,255,0.7);">{{ __('home.bar_body') }}</p>
            <a href="{{ route('bar') }}" class="ed-btn mt-8" style="background:#C99A52;color:#1E3A4A;">Explore the bar</a>
        </div>
        <div class="grid grid-cols-2 gap-4" data-reveal>
            <div class="ed-frame aspect-[4/5] mt-10">
                @if($src = site_image('bar_1'))
                <img src="{{ $src }}" alt="Bar at Rirenga">
                @else
                <x-icon-tile icon="cocktail" bg="rgba(255,255,255,0.08)" color="#C99A52" />
                @endif
            </div>
            <div class="ed-frame aspect-[4/5]">
                @if($barImage?->image_url)
                <img src="{{ $barImage->image_url }}" alt="{{ $barImage->name }}">
                @else
                <x-icon-tile icon="music" bg="rgba(255,255,255,0.08)" color="#ffffff" />
                @endif
            </div>
        </div>
    </div>
</section>

{{-- ===================== BLOG ===================== --}}
@if($latestPosts->count())
<section class="py-24 px-4">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-wrap items-end justify-between gap-6 mb-12">
            <div>
                <h2 class="ed-title mt-5" style="font-size:clamp(2rem,4vw,3rem);">{{ __('home.blog_title') }}</h2>
            </div>
            <a href="{{ route('blog') }}" class="ed-arrow">
                All stories
                <svg fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>

        @php $featured = $latestPosts->first(); $rest = $latestPosts->slice(1); @endphp
        <div class="grid lg:grid-cols-2 gap-8 items-stretch">
            <a href="{{ route('blog.show', $featured) }}" class="ed-frame group relative min-h-[24rem]" data-reveal>
                @if($featured->image_url)
                <img src="{{ $featured->image_url }}" alt="{{ $featured->local_title }}" class="absolute inset-0 group-hover:scale-105 transition duration-700">
                @else
                <div class="absolute inset-0"><x-icon-tile icon="newspaper" bg="linear-gradient(135deg, #1E3A4A, #23485a)" color="#C99A52" /></div>
                @endif
                <div class="absolute inset-0" style="background:linear-gradient(to top, rgba(0,0,0,0.8), rgba(0,0,0,0.2) 55%, transparent);"></div>
                <div class="absolute bottom-0 inset-x-0 p-8">
                    <p class="text-xs uppercase tracking-[0.16em] mb-3" style="color:rgba(255,255,255,0.65);">{{ $featured->published_at?->format('d M Y') }}</p>
                    <h3 class="ed-title ed-title--light" style="font-size:1.7rem;">{{ $featured->local_title }}</h3>
                    <p class="mt-3 text-sm max-w-md" style="color:rgba(255,255,255,0.8);">{{ Str::limit($featured->excerpt ?? '', 110) }}</p>
                </div>
            </a>

            <div class="flex flex-col divide-y" style="border-top:1px solid rgba(34,32,29,0.12);border-color:rgba(34,32,29,0.12);">
                @forelse($rest as $post)
                <a href="{{ route('blog.show', $post) }}" class="group flex gap-5 items-center py-5 flex-1" data-reveal>
                    <div class="ed-frame w-32 h-24 shrink-0">
                        @if($post->image_url)
                        <img src="{{ $post->image_url }}" alt="{{ $post->local_title }}" class="group-hover:scale-105 transition duration-500">
                        @else
                        <x-icon-tile icon="newspaper" bg="#3F7C8A18" color="#3F7C8A" />
                        @endif
                    </div>
                    <div class="min-w-0">
                        <p class="text-[0.68rem] uppercase tracking-[0.16em] text-gray-400 mb-1.5">{{ $post->published_at?->format('d M Y') }}</p>
                        <h3 class="font-display text-lg font-bold leading-snug transition group-hover:text-[#D07A54]" style="color:#1E3A4A;">
                            {{ $post->local_title }}
                        </h3>
                        <p class="text-sm text-gray-500 line-clamp-2 mt-1">{{ Str::limit($post->excerpt ?? '', 100) }}</p>
                    </div>
                </a>
                @empty
                <div class="flex-1 flex items-center justify-center p-8 text-center">
                    <p class="text-sm text-gray-400">More stories coming soon.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</section>
@endif

{{-- ===================== CTA ===================== --}}
<section class="py-24 px-4 relative overflow-hidden" style="background-color:#D07A54;">
    <div class="max-w-3xl mx-auto text-center relative z-10">
        <span class="ed-kicker ed-kicker--center" style="color:rgba(255,255,255,0.85);">Reserve your stay</span>
        <h2 class="ed-title ed-title--light mt-5" style="font-size:clamp(2.25rem,5vw,3.5rem);">{{ __('home.cta_title') }}</h2>
        <p class="mt-6 text-lg" style="color:rgba(255,255,255,0.9);font-weight:300;">{{ __('home.cta_body') }}</p>
        <a href="{{ route('booking') }}" class="ed-btn mt-9" style="background:#fff;color:#D07A54;">
            {{ __('home.cta_button') }}
        </a>
    </div>
</section>

@endsection
