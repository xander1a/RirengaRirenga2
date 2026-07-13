@extends('layouts.public')
@section('title', __('nav.gallery'))
@section('content')
<x-page-hero image="gallery_hero" :title="__('nav.gallery')" />

<section class="py-16 px-4" x-data="{ filter: 'all', lightbox: null }" @keydown.escape.window="lightbox = null">
    <div class="max-w-7xl mx-auto">
        {{-- Filter Tabs --}}
        <div class="flex flex-wrap gap-3 justify-center mb-10">
            @foreach(['all'=>'All','rooms'=>'Rooms','restaurant'=>'Restaurant','bar'=>'Bar','surroundings'=>'Surroundings'] as $key => $label)
            <button @click="filter = '{{ $key }}'"
                    :class="filter === '{{ $key }}' ? 'text-white' : 'text-gray-600 bg-white border border-gray-200'"
                    :style="filter === '{{ $key }}' ? 'background-color:#2E4636;' : ''"
                    class="px-5 py-2 rounded-xl text-sm font-medium transition">
                {{ $label }}
            </button>
            @endforeach
        </div>

        @if($photos->count())
        {{-- Masonry: photos keep their natural aspect ratio, nothing gets cropped --}}
        <div class="columns-2 md:columns-3 lg:columns-4 gap-4 [column-fill:_balance]">
            @foreach($photos as $photo)
            <div x-show="filter === 'all' || filter === '{{ $photo->category }}'"
                 x-transition.opacity
                 @click="lightbox = { src: '{{ $photo->url }}', title: @js($photo->title ?? ucfirst($photo->category)) }"
                 class="mb-4 break-inside-avoid rounded-xl overflow-hidden group relative cursor-zoom-in shadow-sm hover:shadow-md transition-shadow"
                 style="background:#6E8C5A20;">
                <img src="{{ $photo->url }}" alt="{{ $photo->title ?? $photo->category }}"
                     class="w-full h-auto block group-hover:scale-[1.03] transition-transform duration-300"
                     loading="lazy">
                @if($photo->title)
                <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition flex items-end p-3 pointer-events-none">
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
                <img :src="lightbox?.src" :alt="lightbox?.title" class="max-h-[82vh] w-auto max-w-full mx-auto rounded-lg shadow-2xl">
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
