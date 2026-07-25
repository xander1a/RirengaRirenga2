@extends('layouts.public')
@section('title', __('nav.careers'))
@section('content')
<x-page-hero image="careers_hero" :title="__('nav.careers')" kicker="Join Us" subtitle="Join our team and be part of Rwanda's most exciting eco-lodge." />
<section class="py-24 px-4">
    <div class="max-w-4xl mx-auto">
        @if($positions->count())
        <div class="divide-y" style="border-top:1px solid rgba(34,32,29,0.14);border-color:rgba(34,32,29,0.14);">
        @foreach($positions as $pos)
        <div class="py-8" x-data="{ open: false }">
            <div class="flex flex-wrap justify-between gap-4 cursor-pointer" @click="open = !open">
                <div>
                    <h2 class="ed-title" style="font-size:clamp(1.4rem,2.6vw,1.9rem);">{{ $pos->title }}</h2>
                    <div class="flex gap-2 mt-3">
                        @if($pos->department)<span class="text-xs px-3 py-1 tracking-wide" style="background:#EFE9DC;color:#3F7C8A;border-radius:2px;">{{ $pos->department }}</span>@endif
                        <span class="text-xs px-3 py-1 tracking-wide" style="background:#D07A5420;color:#D07A54;border-radius:2px;">{{ ucfirst(str_replace('_',' ',$pos->type)) }}</span>
                    </div>
                </div>
                <svg class="w-6 h-6 mt-2 transition-transform shrink-0" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:#1E3A4A;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M19 9l-7 7-7-7"/>
                </svg>
            </div>
            <div x-show="open" x-transition x-cloak class="mt-7">
                <p class="text-gray-600 leading-relaxed mb-5">{{ $pos->description }}</p>
                @if($pos->requirements)
                <h4 class="ed-kicker mb-3">Requirements</h4>
                <pre class="whitespace-pre-wrap text-sm text-gray-600 mb-8" style="font-family:inherit;">{{ $pos->requirements }}</pre>
                @endif
                <form action="{{ route('careers.apply', $pos) }}" method="POST" enctype="multipart/form-data" class="pt-7 space-y-5" style="border-top:1px solid rgba(34,32,29,0.12);">
                    @csrf
                    <h4 class="ed-kicker">Apply for this position</h4>
                    <div class="grid sm:grid-cols-2 gap-5">
                        <div><label class="block text-[0.7rem] font-semibold uppercase tracking-wider text-gray-500 mb-1.5">Full Name *</label><input type="text" name="name" required class="w-full border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:border-[#3F7C8A]" style="border-radius:2px;"></div>
                        <div><label class="block text-[0.7rem] font-semibold uppercase tracking-wider text-gray-500 mb-1.5">Email *</label><input type="email" name="email" required class="w-full border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:border-[#3F7C8A]" style="border-radius:2px;"></div>
                        <div><label class="block text-[0.7rem] font-semibold uppercase tracking-wider text-gray-500 mb-1.5">Phone</label><input type="tel" name="phone" class="w-full border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:border-[#3F7C8A]" style="border-radius:2px;"></div>
                        <div><label class="block text-[0.7rem] font-semibold uppercase tracking-wider text-gray-500 mb-1.5">CV / Resume (PDF, DOC)</label><input type="file" name="cv" accept=".pdf,.doc,.docx" class="w-full text-sm"></div>
                        <div class="sm:col-span-2"><label class="block text-[0.7rem] font-semibold uppercase tracking-wider text-gray-500 mb-1.5">Cover Letter</label><textarea name="cover_letter" rows="4" class="w-full border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:border-[#3F7C8A]" style="border-radius:2px;"></textarea></div>
                    </div>
                    <button type="submit" class="ed-btn ed-btn-solid">Submit Application</button>
                </form>
            </div>
        </div>
        @endforeach
        </div>
        @else
        <div class="text-center py-16">
            <div class="text-6xl mb-4">🔍</div>
            <p class="text-gray-500">No open positions right now. Check back soon!</p>
        </div>
        @endif
    </div>
</section>
@endsection
