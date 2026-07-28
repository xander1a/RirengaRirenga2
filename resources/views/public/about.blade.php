@extends('layouts.public')
@section('title', __('nav.about'))
@section('content')
<x-page-hero image="about_hero" :title="__('nav.about')" />

<section class="py-24 px-4">
    <div class="max-w-6xl mx-auto">
        <div class="grid lg:grid-cols-[1.4fr_1fr] gap-16 items-center mb-24">
            <div>
                <h2 class="ed-title" style="font-size:clamp(2rem,4.5vw,3.25rem);">A Modern Lodge in the Heart of <em>Kigali</em></h2>
                <p class="ed-lede mt-8 ed-dropcap"><strong>Rirenga</strong> sits on the green hills of Kigali, a modern eco-lodge with sweeping city views that turn golden as the sun sets each evening.</p>
                <p class="mt-5 text-gray-600 leading-relaxed">Rirenga was founded with a simple belief: that the most memorable stays come from thoughtful design, warm hospitality, and a genuine sense of place. Our lodge blends contemporary comfort with sustainable practice, right in the city.</p>
                <p class="mt-5 text-gray-600 leading-relaxed">Every detail — from locally sourced food to our west-facing sunset terrace — reflects our commitment to modern, meaningful hospitality.</p>
            </div>
            <div class="text-center text-8xl select-none">🌇🏙️</div>
        </div>

        <div class="grid md:grid-cols-3 gap-px" style="background:rgba(34,32,29,0.12);">
            @foreach([
                ['🌱','Sustainability','We are committed to eco-friendly practices across all operations — from renewable energy to zero-waste initiatives.'],
                ['🤝','Community','We work closely with local communities, employing local staff and sourcing ingredients from nearby farms.'],
                ['🌇','Sunset Views','Our west-facing terrace and lounge are built for the end of the day — watch the sun set over Kigali\'s hills.'],
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
            <p class="mt-4 text-white/75 max-w-xl mx-auto">Kigali, Rwanda — exact location details provided upon booking confirmation.</p>
            <p class="text-white/75 mt-1">A short drive from Kigali International Airport.</p>
        </div>
    </div>
</section>
@endsection
