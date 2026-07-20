@extends('layouts.public')
@section('title', __('nav.services'))
@section('content')
<x-page-hero image="services_hero" :title="__('nav.services')" />
<section class="py-20 px-4">
    <div class="max-w-7xl mx-auto">
        <div class="grid md:grid-cols-3 gap-8">
            @foreach([
                ['🛏️','Accommodation','Five self-contained rooms ranging from cosy singles to spacious doubles and twin rooms. All rooms include daily dinner & breakfast, private bathroom, and forest views.'],
                ['🍽️','Dining','Our farm-to-table restaurant serves a changing seasonal menu celebrating Rwandan ingredients. Private dining and event catering available on request.'],
                ['🍸','Bar','Signature cocktails, local craft beers, curated wines, and a full spirits selection. Regular live music and themed evenings.'],
                ['🥾','Hiking','Guided and self-guided hiking experiences ranging from gentle forest loops to challenging summit trails. Cultural village walks also available.'],
                ['🚗','Airport Transfers','Private transfers between Kigali International Airport and Byiza Lodge Ltd. Bookable with your reservation.'],
                ['🎉','Events & Retreats','Private event hosting, corporate retreats, and wellness weekends. Contact us to discuss your event.'],
            ] as $s)
            <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-md transition-shadow">
                <div class="text-4xl mb-4">{{ $s[0] }}</div>
                <h3 class="font-display text-xl font-semibold mb-3" style="color:#2E4636;">{{ $s[1] }}</h3>
                <p class="text-gray-600 text-sm leading-relaxed">{{ $s[2] }}</p>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-12">
            <a href="{{ route('booking') }}" class="px-8 py-4 rounded-xl text-white font-semibold text-lg transition hover:opacity-90" style="background-color:#BF6B47;">
                Book Your Experience
            </a>
        </div>
    </div>
</section>
@endsection
