@extends('layouts.public')
@section('title', __('nav.careers'))
@section('content')
<x-page-hero image="careers_hero" :title="__('nav.careers')" subtitle="Join our team and be part of Rwanda's most exciting eco-lodge." />
<section class="py-16 px-4">
    <div class="max-w-4xl mx-auto space-y-8">
        @if($positions->count())
        @foreach($positions as $pos)
        <div class="bg-white rounded-2xl p-8 shadow-sm" x-data="{ open: false }">
            <div class="flex flex-wrap justify-between gap-4 cursor-pointer" @click="open = !open">
                <div>
                    <h2 class="font-display text-2xl font-bold" style="color:#2E4636;">{{ $pos->title }}</h2>
                    <div class="flex gap-3 mt-2">
                        @if($pos->department)<span class="text-xs px-2 py-1 rounded-full" style="background:#F1E9D7;color:#6E8C5A;">{{ $pos->department }}</span>@endif
                        <span class="text-xs px-2 py-1 rounded-full" style="background:#BF6B4720;color:#BF6B47;">{{ ucfirst(str_replace('_',' ',$pos->type)) }}</span>
                    </div>
                </div>
                <svg class="w-6 h-6 mt-2 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:#2E4636;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </div>
            <div x-show="open" x-transition class="mt-6">
                <p class="text-gray-600 mb-4">{{ $pos->description }}</p>
                @if($pos->requirements)
                <h4 class="font-semibold mb-2" style="color:#2E4636;">Requirements:</h4>
                <pre class="whitespace-pre-wrap text-sm text-gray-600 mb-6">{{ $pos->requirements }}</pre>
                @endif
                <form action="{{ route('careers.apply', $pos) }}" method="POST" enctype="multipart/form-data" class="border-t pt-6 space-y-4">
                    @csrf
                    <h4 class="font-semibold" style="color:#2E4636;">Apply for this position</h4>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div><label class="block text-sm mb-1">Full Name *</label><input type="text" name="name" required class="w-full rounded-xl border border-gray-200 px-4 py-2 text-sm focus:outline-none focus:ring-2"></div>
                        <div><label class="block text-sm mb-1">Email *</label><input type="email" name="email" required class="w-full rounded-xl border border-gray-200 px-4 py-2 text-sm focus:outline-none focus:ring-2"></div>
                        <div><label class="block text-sm mb-1">Phone</label><input type="tel" name="phone" class="w-full rounded-xl border border-gray-200 px-4 py-2 text-sm focus:outline-none focus:ring-2"></div>
                        <div><label class="block text-sm mb-1">CV / Resume (PDF, DOC)</label><input type="file" name="cv" accept=".pdf,.doc,.docx" class="w-full text-sm"></div>
                        <div class="sm:col-span-2"><label class="block text-sm mb-1">Cover Letter</label><textarea name="cover_letter" rows="4" class="w-full rounded-xl border border-gray-200 px-4 py-2 text-sm focus:outline-none focus:ring-2"></textarea></div>
                    </div>
                    <button type="submit" class="px-6 py-2 rounded-xl text-white text-sm font-semibold transition hover:opacity-90" style="background-color:#BF6B47;">Submit Application</button>
                </form>
            </div>
        </div>
        @endforeach
        @else
        <div class="text-center py-16">
            <div class="text-6xl mb-4">🔍</div>
            <p class="text-gray-500">No open positions right now. Check back soon!</p>
        </div>
        @endif
    </div>
</section>
@endsection
