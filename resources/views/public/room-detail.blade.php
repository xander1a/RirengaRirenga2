@extends('layouts.public')

@section('title', $roomType->name)

@section('content')

<section class="px-4 py-24 sm:py-28" style="background-color:#1E3A4A;">
    <div class="max-w-5xl mx-auto">
        <h1 class="ed-title ed-title--light" style="font-size:clamp(2.5rem,6vw,4.25rem);">{{ $roomType->name }}</h1>
        <div class="ed-rule-gold mt-7"></div>
    </div>
</section>

<section class="py-24 px-4">
    <div class="max-w-6xl mx-auto grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
        <div class="ed-frame aspect-[4/3]">
            <x-icon-tile icon="bed" bg="linear-gradient(135deg, #3F7C8A22, #1E3A4A33)" color="#1E3A4A" />
        </div>
        <div>
            <div class="flex items-baseline justify-between gap-4 mb-5">
                <span class="ed-kicker">Up to {{ $roomType->max_guests }} guest(s)</span>
                <div class="text-right">
                    <p class="font-display text-3xl font-bold" style="color:#C99A52;">{{ money($roomType->price_per_night, $roomType->currency) }}</p>
                    <p class="text-xs text-gray-400">per night</p>
                </div>
            </div>
            <h2 class="ed-title" style="font-size:clamp(1.9rem,3.5vw,2.75rem);">{{ $roomType->name }}</h2>
            <p class="mt-5 text-gray-600 leading-relaxed">{{ $roomType->description }}</p>
            <div class="flex flex-wrap gap-2 mt-6 mb-8">
                @foreach($roomType->amenities ?? [] as $amenity)
                <span class="text-xs px-3 py-1.5 tracking-wide" style="background:#EFE9DC;color:#3F7C8A;border-radius:2px;">{{ $amenity }}</span>
                @endforeach
            </div>
            <a href="{{ route('booking', ['room_type_id' => $roomType->id]) }}" class="ed-btn ed-btn-solid">Book this room</a>
        </div>
    </div>
</section>

@endsection
