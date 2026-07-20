@extends('layouts.public')
@section('title', __('nav.about'))
@section('content')
<x-page-hero image="about_hero" :title="__('nav.about')" />
<section class="py-20 px-4">
    <div class="max-w-4xl mx-auto">
        <div class="grid lg:grid-cols-2 gap-12 items-center mb-16">
            <div>
                <p class="text-sm font-semibold uppercase tracking-widest mb-2" style="color:#BF6B47;">Our Story</p>
                <h2 class="font-display text-4xl font-bold mb-6" style="color:#2E4636;">Born from a Love of Rwanda's Wild Places</h2>
                <p class="text-gray-600 leading-relaxed mb-4"><strong>Byiza</strong> means <em>beautiful</em> in Kinyarwanda, Rwanda's national language. Byiza Lodge is situated in the Kingdom of the Gorillas, on a hilltop between the twin lakes of Ruhondo and Burera, overlooking the Virunga volcanoes.</p>
                <p class="text-gray-600 leading-relaxed mb-4">Byiza Lodge Ltd was founded with a simple belief: that the most memorable travel experiences come from deep connection — to nature, to community, and to culture. Our lodge is designed to leave the lightest possible footprint while giving guests an unforgettable sense of place.</p>
                <p class="text-gray-600 leading-relaxed">Every detail — from locally sourced food to community-guided hikes — reflects our commitment to sustainable, meaningful hospitality.</p>
            </div>
            <div class="text-center text-8xl">🏔️🌿</div>
        </div>
        <div class="grid md:grid-cols-3 gap-8 mt-12">
            @foreach([
                ['🌱','Sustainability','We are committed to eco-friendly practices across all operations — from renewable energy to zero-waste initiatives.'],
                ['🤝','Community','We work closely with local communities, employing local staff and sourcing ingredients from nearby farms.'],
                ['🦜','Wildlife','Located within reach of Rwanda\'s incredible wildlife, we promote conservation through responsible tourism.'],
            ] as $v)
            <div class="rounded-2xl p-6 text-center" style="background:#F1E9D7;">
                <div class="text-4xl mb-3">{{ $v[0] }}</div>
                <h3 class="font-display text-xl font-semibold mb-2" style="color:#2E4636;">{{ $v[1] }}</h3>
                <p class="text-sm text-gray-600">{{ $v[2] }}</p>
            </div>
            @endforeach
        </div>
        <div class="mt-16 rounded-2xl overflow-hidden" style="background:#2E4636;padding:2rem;">
            <div class="text-center text-white">
                <h3 class="font-display text-2xl font-bold mb-2">📍 Location</h3>
                <p class="text-white/70">Rwanda — exact location details provided upon booking confirmation.</p>
                <p class="text-white/70 mt-1">Accessible by road from Kigali International Airport (~TODO hours).</p>
            </div>
        </div>
    </div>
</section>
@endsection
