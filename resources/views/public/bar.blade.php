@extends('layouts.public')

@section('title', __('nav.bar'))

@section('content')

<x-page-hero image="bar_hero" :title="__('nav.bar')" subtitle="Signature cocktails, curated wines, and live events under the stars." />

{{-- Beverage Menu --}}
<section class="py-16 px-4">
    <div class="max-w-6xl mx-auto space-y-14">
        @foreach($categories as $cat)
        <div>
            <div class="text-center mb-8">
                <h2 class="font-display text-3xl font-bold" style="color:#2E4636;">{{ $cat->local_name }}</h2>
                <div class="mt-3 mx-auto h-1 w-14 rounded-full" style="background:#C9A24B;"></div>
            </div>

            <div class="space-y-8">
                @foreach($cat->items as $item)
                <div class="group bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow duration-300 sm:flex sm:items-stretch" data-reveal>
                    {{-- Photo --}}
                    <div class="sm:w-2/5 lg:w-1/3 h-56 sm:h-auto sm:min-h-[15rem] overflow-hidden shrink-0 {{ $loop->odd ? '' : 'sm:order-2' }}">
                        @if($item->image_url)
                        <img src="{{ $item->image_url }}" alt="{{ $item->local_name }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-700" loading="lazy">
                        @else
                        <x-icon-tile icon="cocktail" bg="linear-gradient(135deg, #C9A24B18, #2E463625)" color="#C9A24B" />
                        @endif
                    </div>

                    {{-- Details --}}
                    <div class="flex-1 p-6 sm:p-8 flex flex-col justify-center {{ $loop->odd ? '' : 'sm:order-1 sm:text-right' }}">
                        <div class="flex items-baseline gap-3 {{ $loop->odd ? '' : 'sm:flex-row-reverse' }}">
                            <h3 class="font-display text-xl lg:text-2xl font-semibold" style="color:#2B2A28;">{{ $item->local_name }}</h3>
                            <span class="flex-1 border-b border-dotted border-gray-300 hidden sm:block"></span>
                            <span class="font-bold text-lg whitespace-nowrap" style="color:#C9A24B;">{{ money($item->price, $item->currency) }}</span>
                        </div>
                        @if($item->local_description)
                        <p class="text-gray-500 mt-3 leading-relaxed max-w-xl {{ $loop->odd ? '' : 'sm:ml-auto' }}">{{ $item->local_description }}</p>
                        @endif
                        <div class="mt-4 h-0.5 w-10 rounded-full {{ $loop->odd ? '' : 'sm:ml-auto' }}" style="background:#C9A24B40;"></div>
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
<section class="py-16 px-4" style="background-color:#2E4636;">
    <div class="max-w-7xl mx-auto">
        <h2 class="font-display text-3xl font-bold text-white text-center mb-10">Upcoming Events</h2>
        <div class="grid md:grid-cols-2 gap-6">
            @foreach($events as $event)
            <div class="rounded-2xl p-6" style="background:rgba(255,255,255,0.08);">
                <p class="text-xs mb-1" style="color:#C9A24B;">{{ $event->starts_at->format('D, d M Y · H:i') }}</p>
                <h3 class="font-display text-xl font-semibold text-white mb-2">{{ $event->local_title }}</h3>
                @if($event->description)
                <p class="text-white/60 text-sm">{{ $event->description }}</p>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Promotions --}}
@if($promotions->count())
<section class="py-16 px-4">
    <div class="max-w-7xl mx-auto">
        <h2 class="font-display text-3xl font-bold text-center mb-10" style="color:#2E4636;">Current Promotions</h2>
        <div class="grid md:grid-cols-2 gap-6">
            @foreach($promotions as $promo)
            <div class="rounded-2xl p-6 border-2" style="border-color:#C9A24B;background:#C9A24B10;">
                <h3 class="font-display text-xl font-semibold mb-2" style="color:#2E4636;">{{ $promo->title }}</h3>
                <p class="text-gray-600 text-sm">{{ $promo->description }}</p>
                @if($promo->valid_until)
                <p class="text-xs text-gray-400 mt-2">Valid until {{ $promo->valid_until->format('d M Y') }}</p>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- VIP Reservations --}}
<section id="vip" class="py-20 px-4" style="background:#F1E9D7;">
    <div class="max-w-xl mx-auto">
        <div class="text-center mb-10">
            <span class="text-xs px-3 py-1 rounded-full font-bold uppercase tracking-widest text-white mb-3 inline-block" style="background:#C9A24B;">VIP</span>
            <h2 class="font-display text-3xl font-bold" style="color:#2E4636;">VIP Reservations</h2>
            <p class="text-gray-500 mt-2">Reserve your exclusive table at the bar. We'll arrange everything.</p>
        </div>
        <form action="{{ route('bar.vip-reserve') }}" method="POST" class="bg-white rounded-2xl p-8 shadow-md space-y-5">
            @csrf
            <div class="grid sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium mb-1">Full Name *</label>
                    <input type="text" name="guest_name" required class="w-full rounded-xl border border-gray-200 px-4 py-3 focus:outline-none focus:ring-2" value="{{ old('guest_name') }}">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Email *</label>
                    <input type="email" name="guest_email" required class="w-full rounded-xl border border-gray-200 px-4 py-3 focus:outline-none focus:ring-2" value="{{ old('guest_email') }}">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Phone</label>
                    <input type="tel" name="guest_phone" class="w-full rounded-xl border border-gray-200 px-4 py-3 focus:outline-none focus:ring-2">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Party Size *</label>
                    <input type="number" name="party_size" min="1" required class="w-full rounded-xl border border-gray-200 px-4 py-3 focus:outline-none focus:ring-2" value="{{ old('party_size', 2) }}">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Date *</label>
                    <input type="date" name="date" required min="{{ date('Y-m-d') }}" class="w-full rounded-xl border border-gray-200 px-4 py-3 focus:outline-none focus:ring-2">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Time *</label>
                    <input type="time" name="time" required class="w-full rounded-xl border border-gray-200 px-4 py-3 focus:outline-none focus:ring-2">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Special Requests</label>
                <textarea name="requests" rows="3" class="w-full rounded-xl border border-gray-200 px-4 py-3 focus:outline-none focus:ring-2">{{ old('requests') }}</textarea>
            </div>
            <button type="submit" class="w-full py-3 rounded-xl text-white font-semibold transition hover:opacity-90" style="background-color:#C9A24B;">
                Submit VIP Request
            </button>
        </form>
    </div>
</section>

@endsection
