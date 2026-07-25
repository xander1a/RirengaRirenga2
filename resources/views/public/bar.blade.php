@extends('layouts.public')

@section('title', __('nav.bar'))

@section('content')

<x-page-hero image="bar_hero" :title="__('nav.bar')" kicker="Bar &amp; Events" subtitle="Signature cocktails, curated wines, and live events under the stars." />

{{-- Beverage Menu --}}
<section class="py-24 px-4">
    <div class="max-w-4xl mx-auto space-y-20">
        @foreach($categories as $cat)
        <div>
            <div class="flex items-center gap-4 mb-8">
                <h2 class="ed-title" style="font-size:clamp(1.6rem,3vw,2.25rem);">{{ $cat->local_name }}</h2>
                <span class="flex-1 ed-rule"></span>
            </div>

            <div class="divide-y" style="border-color:rgba(34,32,29,0.1);">
                @foreach($cat->items as $item)
                <div class="group flex gap-5 py-6" data-reveal>
                    @if($item->image_url)
                    <div class="ed-frame w-24 h-24 shrink-0 hidden sm:block">
                        <img src="{{ $item->image_url }}" alt="{{ $item->local_name }}" class="group-hover:scale-105 transition duration-700" loading="lazy">
                    </div>
                    @endif
                    <div class="flex-1 min-w-0">
                        <div class="flex items-baseline gap-3">
                            <h3 class="font-display text-xl font-bold" style="color:#22201D;">{{ $item->local_name }}</h3>
                            <span class="flex-1 border-b border-dotted border-gray-300"></span>
                            <span class="font-display font-bold text-lg whitespace-nowrap" style="color:#C99A52;">{{ money($item->price, $item->currency) }}</span>
                        </div>
                        @if($item->local_description)
                        <p class="text-gray-500 mt-2 leading-relaxed">{{ $item->local_description }}</p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
</section>

{{-- Events --}}
@if($events->count())
<section class="py-24 px-4" style="background-color:#1E3A4A;">
    <div class="max-w-7xl mx-auto">
        <div class="mb-12">
            <span class="ed-kicker ed-kicker--light">What's on</span>
            <h2 class="ed-title ed-title--light mt-4" style="font-size:clamp(1.9rem,4vw,2.75rem);">Upcoming Events</h2>
        </div>
        <div class="grid md:grid-cols-2 gap-px" style="background:rgba(255,255,255,0.12);">
            @foreach($events as $event)
            <div class="p-7" style="background:#1E3A4A;">
                <p class="text-[0.68rem] uppercase tracking-[0.16em] mb-2" style="color:#C99A52;">{{ $event->starts_at->format('D, d M Y · H:i') }}</p>
                <h3 class="font-display text-xl font-bold text-white mb-2">{{ $event->local_title }}</h3>
                @if($event->description)
                <p class="text-white/60 text-sm leading-relaxed">{{ $event->description }}</p>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Promotions --}}
@if($promotions->count())
<section class="py-24 px-4">
    <div class="max-w-7xl mx-auto">
        <div class="mb-12">
            <span class="ed-kicker">Offers</span>
            <h2 class="ed-title mt-4" style="font-size:clamp(1.9rem,4vw,2.75rem);">Current Promotions</h2>
        </div>
        <div class="grid md:grid-cols-2 gap-6">
            @foreach($promotions as $promo)
            <div class="p-7" style="border:1px solid #C99A52;background:#C99A5210;border-radius:2px;">
                <h3 class="font-display text-xl font-bold mb-2" style="color:#1E3A4A;">{{ $promo->title }}</h3>
                <p class="text-gray-600 text-sm leading-relaxed">{{ $promo->description }}</p>
                @if($promo->valid_until)
                <p class="text-xs text-gray-400 mt-3">Valid until {{ $promo->valid_until->format('d M Y') }}</p>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- VIP Reservations --}}
<section id="vip" class="py-24 px-4" style="background:#EFE9DC;">
    <div class="max-w-xl mx-auto">
        <div class="mb-10">
            <span class="ed-kicker" style="color:#C99A52;">VIP</span>
            <h2 class="ed-title mt-4" style="font-size:clamp(1.9rem,4vw,2.75rem);">VIP Reservations</h2>
            <p class="mt-3 text-gray-500">Reserve your exclusive table at the bar. We'll arrange everything.</p>
        </div>
        <form action="{{ route('bar.vip-reserve') }}" method="POST" class="p-8 space-y-5" style="background:#fff;border:1px solid rgba(34,32,29,0.12);border-radius:2px;">
            @csrf
            <div class="grid sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-[0.7rem] font-semibold uppercase tracking-wider text-gray-500 mb-1.5">Full Name *</label>
                    <input type="text" name="guest_name" required class="w-full border border-gray-200 px-4 py-3 focus:outline-none focus:border-[#3F7C8A]" style="border-radius:2px;" value="{{ old('guest_name') }}">
                </div>
                <div>
                    <label class="block text-[0.7rem] font-semibold uppercase tracking-wider text-gray-500 mb-1.5">Email *</label>
                    <input type="email" name="guest_email" required class="w-full border border-gray-200 px-4 py-3 focus:outline-none focus:border-[#3F7C8A]" style="border-radius:2px;" value="{{ old('guest_email') }}">
                </div>
                <div>
                    <label class="block text-[0.7rem] font-semibold uppercase tracking-wider text-gray-500 mb-1.5">Phone</label>
                    <input type="tel" name="guest_phone" class="w-full border border-gray-200 px-4 py-3 focus:outline-none focus:border-[#3F7C8A]" style="border-radius:2px;">
                </div>
                <div>
                    <label class="block text-[0.7rem] font-semibold uppercase tracking-wider text-gray-500 mb-1.5">Party Size *</label>
                    <input type="number" name="party_size" min="1" required class="w-full border border-gray-200 px-4 py-3 focus:outline-none focus:border-[#3F7C8A]" style="border-radius:2px;" value="{{ old('party_size', 2) }}">
                </div>
                <div>
                    <label class="block text-[0.7rem] font-semibold uppercase tracking-wider text-gray-500 mb-1.5">Date *</label>
                    <input type="date" name="date" required min="{{ date('Y-m-d') }}" class="w-full border border-gray-200 px-4 py-3 focus:outline-none focus:border-[#3F7C8A]" style="border-radius:2px;">
                </div>
                <div>
                    <label class="block text-[0.7rem] font-semibold uppercase tracking-wider text-gray-500 mb-1.5">Time *</label>
                    <input type="time" name="time" required class="w-full border border-gray-200 px-4 py-3 focus:outline-none focus:border-[#3F7C8A]" style="border-radius:2px;">
                </div>
            </div>
            <div>
                <label class="block text-[0.7rem] font-semibold uppercase tracking-wider text-gray-500 mb-1.5">Special Requests</label>
                <textarea name="requests" rows="3" class="w-full border border-gray-200 px-4 py-3 focus:outline-none focus:border-[#3F7C8A]" style="border-radius:2px;">{{ old('requests') }}</textarea>
            </div>
            <button type="submit" class="ed-btn w-full" style="background:#C99A52;color:#1E3A4A;">
                Submit VIP Request
            </button>
        </form>
    </div>
</section>

@endsection
