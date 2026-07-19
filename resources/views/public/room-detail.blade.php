@extends('layouts.public')

@section('title', $roomType->name)

@section('content')

<section class="py-16 px-4" style="background-color:#2E4636;">
    <div class="max-w-5xl mx-auto text-center text-white">
        <p class="text-sm uppercase tracking-widest mb-2 text-white/60">{{ $roomType->code }}</p>
        <h1 class="font-display text-5xl font-bold">{{ $roomType->name }}</h1>
    </div>
</section>

<section class="py-16 px-4">
    <div class="max-w-5xl mx-auto bg-white rounded-2xl overflow-hidden shadow-md lg:flex">
        <div class="lg:w-2/5 min-h-64 overflow-hidden">
            <x-icon-tile icon="bed" bg="linear-gradient(135deg, #6E8C5A22, #2E463633)" color="#2E4636" />
        </div>
        <div class="lg:w-3/5 p-8">
            <div class="flex flex-wrap justify-between items-start gap-4 mb-4">
                <div>
                    <span class="text-xs px-3 py-1 rounded-full font-semibold uppercase tracking-wide" style="background:#F1E9D7;color:#6E8C5A;">{{ $roomType->code }}</span>
                    <h2 class="font-display text-3xl font-bold mt-2" style="color:#2E4636;">{{ $roomType->name }}</h2>
                </div>
                <div class="text-right">
                    <p class="text-3xl font-bold" style="color:#C9A24B;">{{ money($roomType->price_per_night, $roomType->currency) }}</p>
                    <p class="text-xs text-gray-400">per night · up to {{ $roomType->max_guests }} guest(s)</p>
                </div>
            </div>
            <p class="text-gray-600 leading-relaxed mb-6">{{ $roomType->description }}</p>
            <div class="flex flex-wrap gap-2 mb-8">
                @foreach($roomType->amenities ?? [] as $amenity)
                <span class="text-sm px-3 py-1 rounded-full" style="background:#F1E9D7;color:#6E8C5A;">✓ {{ $amenity }}</span>
                @endforeach
            </div>
            <a href="{{ route('booking', ['room_type_id' => $roomType->id]) }}"
               class="inline-block px-8 py-3 rounded-xl text-white font-semibold transition hover:opacity-90"
               style="background-color:#BF6B47;">Book This Room</a>
        </div>
    </div>
</section>

@endsection
