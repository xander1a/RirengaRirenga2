@extends('layouts.public')
@section('title', __('nav.services'))
@section('content')
<x-page-hero image="services_hero" :title="__('nav.services')" kicker="What We Offer" />
<section class="py-24 px-4">
    <div class="max-w-7xl mx-auto">
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-px" style="background:rgba(34,32,29,0.12);">
            @foreach([
                ['🛏️','Accommodation','Five self-contained rooms ranging from cosy singles to spacious doubles and twin rooms. All rooms include daily dinner & breakfast, private bathroom, and sweeping city views.'],
                ['🍽️','Dining','Our farm-to-table restaurant serves a changing seasonal menu celebrating Rwandan ingredients. Private dining and event catering available on request.'],
                ['🍸','Bar','Signature cocktails, local craft beers, curated wines, and a full spirits selection. Regular live music and themed evenings.'],
                ['🌇','Sunset Terrace','Wind down on our west-facing terrace and lounge as the sun sets over Kigali — the perfect end to the day with a drink in hand and the city glowing below.'],
                ['🚗','Airport Transfers','Private transfers between Kigali International Airport and Rirenga. Bookable with your reservation.'],
                ['🎉','Events & Retreats','Private event hosting, corporate retreats, and wellness weekends. Contact us to discuss your event.'],
            ] as $n => $s)
            <div class="p-8" style="background:#EFE9DC;">
                <div class="flex items-baseline gap-3 mb-4">
                    <span class="ed-index">{{ str_pad($n + 1, 2, '0', STR_PAD_LEFT) }}</span>
                    <span class="text-3xl">{{ $s[0] }}</span>
                </div>
                <h3 class="font-display text-xl font-bold mb-3" style="color:#1E3A4A;">{{ $s[1] }}</h3>
                <p class="text-gray-600 text-sm leading-relaxed">{{ $s[2] }}</p>
            </div>
            @endforeach
        </div>
        <div class="mt-16 text-center">
            <a href="{{ route('booking') }}" class="ed-btn ed-btn-solid">Book your experience</a>
        </div>
    </div>
</section>
@endsection
