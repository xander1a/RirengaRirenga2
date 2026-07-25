@extends('layouts.public')
@section('title', __('nav.gallery'))
@section('content')
<x-page-hero image="gallery_hero" :title="__('nav.gallery')" kicker="In Pictures" />

<section class="py-24 px-4" x-data="{ filter: 'all', lightbox: null }" @keydown.escape.window="lightbox = null">
    <div class="max-w-7xl mx-auto">
        {{-- Filter Tabs (editorial text tabs) --}}
        <div class="flex flex-wrap gap-x-7 gap-y-3 justify-center mb-14 text-[0.72rem] font-semibold uppercase tracking-[0.16em]">
            @foreach(['all'=>'All','rooms'=>'Rooms','restaurant'=>'Restaurant','bar'=>'Bar','surroundings'=>'Surroundings'] as $key => $label)
            <button @click="filter = '{{ $key }}'"
                    class="relative pb-1.5 transition-colors"
                    :style="filter === '{{ $key }}' ? 'color:#1E3A4A;' : 'color:rgba(34,32,29,0.45);'">
                {{ $label }}
                <span class="absolute -bottom-0 left-0 right-0 h-0.5" style="background:#C99A52;" x-show="filter === '{{ $key }}'"></span>
            </button>
            @endforeach
        </div>

        @if($photos->count())
        <div class="columns-2 md:columns-3 lg:columns-4 gap-4 [column-fill:_balance]">
            @foreach($photos as $photo)
            <div x-show="filter === 'all' || filter === '{{ $photo->category }}'"
                 x-transition.opacity
                 @click="lightbox = { src: '{{ $photo->url }}', title: @js($photo->title ?? ucfirst($photo->category)) }"
                 class="ed-frame mb-4 break-inside-avoid group relative cursor-zoom-in"
                 style="background:#3F7C8A20;">
                <img src="{{ $photo->url }}" alt="{{ $photo->title ?? $photo->category }}"
                     class="w-full h-auto block group-hover:scale-[1.03] transition-transform duration-500"
                     loading="lazy">
                @if($photo->title)
                <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition flex items-end p-4 pointer-events-none" style="background:linear-gradient(to top, rgba(0,0,0,0.55), transparent);">
                    <span class="text-white text-sm font-medium">{{ $photo->title }}</span>
                </div>
                @endif
            </div>
            @endforeach
        </div>

        {{-- Lightbox --}}
        <div x-show="lightbox" x-cloak x-transition.opacity
             @click="lightbox = null"
             class="fixed inset-0 z-[80] bg-black/90 flex items-center justify-center p-4 sm:p-8 cursor-zoom-out">
            <button class="absolute top-4 right-4 text-white/70 hover:text-white p-2" aria-label="Close">
                <x-admin-icon name="x-mark" class="w-7 h-7" />
            </button>
            <figure class="max-w-5xl max-h-full text-center" @click.stop>
                <img :src="lightbox?.src" :alt="lightbox?.title" class="max-h-[82vh] w-auto max-w-full mx-auto shadow-2xl" style="border-radius:2px;">
                <figcaption class="mt-3 text-white/80 text-sm" x-text="lightbox?.title"></figcaption>
            </figure>
        </div>
        @else
        <div class="text-center py-16">
            <div class="text-6xl mb-4">📸</div>
            <p class="text-gray-500">Gallery photos coming soon. Check back later!</p>
        </div>
        @endif
    </div>
</section>
@endsection
