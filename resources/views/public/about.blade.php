@extends('layouts.public')
@section('title', __('nav.about'))
@section('content')
<x-page-hero image="about_hero" :title="__('nav.about')" kicker="Our Story" />

<section class="py-24 px-4">
    <div class="max-w-6xl mx-auto">
        <div class="grid lg:grid-cols-[1.4fr_1fr] gap-16 items-center mb-24">
            <div>
                <div class="flex items-center gap-4 mb-6">
                    <span class="ed-index">01</span>
                    <span class="ed-kicker">Our Story</span>
                </div>
                <h2 class="ed-title" style="font-size:clamp(2rem,4.5vw,3.25rem);">Born from a Love of <em>Rwanda's</em> Wild Places</h2>
                <p class="ed-lede mt-8 ed-dropcap"><strong>Rirenga</strong> is situated in the Kingdom of the Gorillas, on a hilltop between the twin lakes of Ruhondo and Burera, overlooking the Virunga volcanoes.</p>
                <p class="mt-5 text-gray-600 leading-relaxed">Rirenga was founded with a simple belief: that the most memorable travel experiences come from deep connection — to nature, to community, and to culture. Our lodge is designed to leave the lightest possible footprint while giving guests an unforgettable sense of place.</p>
                <p class="mt-5 text-gray-600 leading-relaxed">Every detail — from locally sourced food to community-guided hikes — reflects our commitment to sustainable, meaningful hospitality.</p>
            </div>
            <div class="text-center text-8xl select-none">🏔️🌿</div>
        </div>

        <div class="grid md:grid-cols-3 gap-px" style="background:rgba(34,32,29,0.12);">
            @foreach([
                ['🌱','Sustainability','We are committed to eco-friendly practices across all operations — from renewable energy to zero-waste initiatives.'],
                ['🤝','Community','We work closely with local communities, employing local staff and sourcing ingredients from nearby farms.'],
                ['🦜','Wildlife','Located within reach of Rwanda\'s incredible wildlife, we promote conservation through responsible tourism.'],
            ] as $n => $v)
            <div class="p-8" style="background:#EFE9DC;">
                <div class="flex items-baseline gap-3 mb-4">
                    <span class="ed-index">0{{ $n + 1 }}</span>
                    <span class="text-3xl">{{ $v[0] }}</span>
                </div>
                <h3 class="font-display text-xl font-bold mb-3" style="color:#1E3A4A;">{{ $v[1] }}</h3>
                <p class="text-sm text-gray-600 leading-relaxed">{{ $v[2] }}</p>
            </div>
            @endforeach
        </div>

        <div class="mt-16 px-8 py-14 text-center" style="background:#1E3A4A;">
            <span class="ed-kicker ed-kicker--light ed-kicker--center">📍 Location</span>
            <p class="mt-4 text-white/75 max-w-xl mx-auto">Rwanda — exact location details provided upon booking confirmation.</p>
            <p class="text-white/75 mt-1">Accessible by road from Kigali International Airport.</p>
        </div>
    </div>
</section>
@endsection
