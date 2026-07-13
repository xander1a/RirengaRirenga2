@extends('layouts.public')

@section('title', __('nav.rooms'))

@section('content')

<x-page-hero image="rooms_hero" :title="__('nav.rooms')" subtitle="All rooms include dinner & breakfast. Choose your perfect retreat." />

<section class="py-16 px-4">
    <div class="max-w-7xl mx-auto space-y-12">
        @foreach($roomTypes as $rt)
        <div class="bg-white rounded-2xl overflow-hidden shadow-md lg:flex hover:shadow-xl transition-shadow duration-300" id="room-{{ $rt->code }}" data-reveal>
            @php $roomImg = $rt->image ? $rt->image_url : $rt->rooms->firstWhere('image')?->image_url; @endphp
            <div class="lg:w-2/5 min-h-64 overflow-hidden">
                @if($roomImg)
                <img src="{{ $roomImg }}" alt="{{ $rt->name }}" class="w-full h-full object-cover hover:scale-105 transition duration-500">
                @else
                <x-icon-tile icon="bed" bg="linear-gradient(135deg, #6E8C5A22, #2E463633)" color="#2E4636" />
                @endif
            </div>
            <div class="lg:w-3/5 p-8">
                <div class="flex flex-wrap justify-between items-start gap-4 mb-4">
                    <div>
                        <span class="text-xs px-3 py-1 rounded-full font-semibold uppercase tracking-wide" style="background:#F1E9D7;color:#6E8C5A;">{{ $rt->code }}</span>
                        <h2 class="font-display text-3xl font-bold mt-2" style="color:#2E4636;">{{ $rt->name }}</h2>
                    </div>
                    <div class="text-right">
                        <p class="text-3xl font-bold" style="color:#C9A24B;">{{ frw($rt->price_per_night) }}</p>
                        <p class="text-xs text-gray-400">per night · up to {{ $rt->max_guests }} guest(s)</p>
                    </div>
                </div>
                <p class="text-gray-600 leading-relaxed mb-6">{{ $rt->description }}</p>
                <div class="flex flex-wrap gap-2 mb-8">
                    @foreach($rt->amenities ?? [] as $amenity)
                    <span class="text-sm px-3 py-1 rounded-full" style="background:#F1E9D7;color:#6E8C5A;">✓ {{ $amenity }}</span>
                    @endforeach
                </div>
                <a href="{{ route('booking', ['room_type_id' => $rt->id]) }}"
                   class="inline-block px-8 py-3 rounded-xl text-white font-semibold transition hover:opacity-90"
                   style="background-color:#BF6B47;">Book This Room</a>
            </div>
        </div>
        @endforeach
    </div>
</section>

@endsection
