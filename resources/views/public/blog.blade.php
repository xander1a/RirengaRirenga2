@extends('layouts.public')
@section('title', __('nav.blog'))
@section('content')
<x-page-hero image="blog_hero" :title="__('nav.blog')" kicker="Stories &amp; Journal" />
<section class="py-24 px-4">
    <div class="max-w-7xl mx-auto">
        @if($posts->count())
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-14">
            @foreach($posts as $post)
            <a href="{{ route('blog.show', $post) }}" class="group flex flex-col">
                <div class="ed-frame aspect-[3/2] mb-5" style="background:#3F7C8A20;">
                    @if($post->image_url)
                    <img src="{{ $post->image_url }}" alt="{{ $post->local_title }}" class="group-hover:scale-105 transition duration-700" loading="lazy">
                    @else
                    <x-icon-tile icon="newspaper" bg="#3F7C8A18" color="#3F7C8A" />
                    @endif
                </div>
                <p class="text-[0.68rem] uppercase tracking-[0.16em] text-gray-400 mb-2">{{ $post->published_at?->format('d M Y') }} &middot; {{ $post->author?->name ?? 'Rirenga Team' }}</p>
                <h2 class="font-display text-xl font-bold leading-snug transition group-hover:text-[#D07A54] mb-2" style="color:#1E3A4A;">
                    {{ app()->getLocale() === 'fr' && $post->title_fr ? $post->title_fr : $post->title }}
                </h2>
                <p class="text-sm text-gray-500 line-clamp-3">{{ strip_tags(app()->getLocale() === 'fr' && $post->excerpt_fr ? $post->excerpt_fr : ($post->excerpt ?? '')) }}</p>
                <span class="ed-arrow mt-4" style="font-size:0.72rem;">
                    {{ __('home.read_more') }}
                    <svg fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </span>
            </a>
            @endforeach
        </div>
        <div class="mt-16 flex justify-center">{{ $posts->links() }}</div>
        @else
        <div class="text-center py-16">
            <div class="text-6xl mb-4">📝</div>
            <p class="text-gray-500">No posts yet. Check back soon!</p>
        </div>
        @endif
    </div>
</section>
@endsection
