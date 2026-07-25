@extends('layouts.public')

@section('title', __('nav.rooms'))

@section('content')

<x-page-hero image="rooms_hero" :title="__('nav.rooms')" kicker="Accommodation" subtitle="All rooms include dinner & breakfast. Choose your perfect retreat." />

<section class="py-24 px-4">
    <div class="max-w-7xl mx-auto space-y-24 lg:space-y-32">
        @foreach($roomTypes as $i => $rt)
        @php $roomImg = $rt->image ? $rt->image_url : $rt->rooms->firstWhere('image')?->image_url; @endphp
        <div class="grid lg:grid-cols-2 gap-10 lg:gap-16 items-center" id="room-{{ $rt->code }}" data-reveal>
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
                <div class="flex items-center gap-4 mb-4">
                    <span class="ed-index">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                    <span class="ed-kicker">{{ $rt->code }} &middot; Sleeps {{ $rt->max_guests }}</span>
                </div>
                <h2 class="ed-title" style="font-size:clamp(1.9rem,3.5vw,2.75rem);">{{ $rt->name }}</h2>
                <p class="mt-5 text-gray-600 leading-relaxed max-w-lg">{{ $rt->description }}</p>
                <div class="flex flex-wrap gap-2 mt-6 mb-8">
                    @foreach($rt->amenities ?? [] as $amenity)
                    <span class="text-xs px-3 py-1.5 tracking-wide" style="background:#EFE9DC;color:#3F7C8A;border-radius:2px;">{{ $amenity }}</span>
                    @endforeach
                </div>
                <a href="{{ route('booking', ['room_type_id' => $rt->id]) }}" class="ed-btn ed-btn-solid">Book this room</a>
            </div>
        </div>
        @endforeach
    </div>
</section>

@endsection
