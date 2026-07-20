@extends('layouts.public')
@section('title', __('nav.blog'))
@section('content')
<x-page-hero image="blog_hero" :title="__('nav.blog')" />
<section class="py-16 px-4">
    <div class="max-w-7xl mx-auto">
        @if($posts->count())
        <div class="grid md:grid-cols-3 gap-8">
            @foreach($posts as $post)
            <a href="{{ route('blog.show', $post) }}" class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow">
                <div class="h-48 overflow-hidden" style="background:#6E8C5A20;">
                    @if($post->image_url)
                    <img src="{{ $post->image_url }}" alt="{{ $post->local_title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" loading="lazy">
                    @else
                    <x-icon-tile icon="newspaper" bg="#6E8C5A18" color="#6E8C5A" />
                    @endif
                </div>
                <div class="p-6">
                    <p class="text-xs text-gray-400 mb-2">{{ $post->published_at?->format('d M Y') }} &bull; {{ $post->author?->name ?? 'Byiza Lodge Team' }}</p>
                    <h2 class="font-display text-xl font-semibold group-hover:opacity-80 transition mb-3" style="color:#2E4636;">
                        {{ app()->getLocale() === 'fr' && $post->title_fr ? $post->title_fr : $post->title }}
                    </h2>
                    <p class="text-sm text-gray-500 line-clamp-3">{{ strip_tags(app()->getLocale() === 'fr' && $post->excerpt_fr ? $post->excerpt_fr : ($post->excerpt ?? '')) }}</p>
                    <p class="mt-4 text-sm font-semibold" style="color:#BF6B47;">{{ __('home.read_more') }} →</p>
                </div>
            </a>
            @endforeach
        </div>
        <div class="mt-10 flex justify-center">{{ $posts->links() }}</div>
        @else
        <div class="text-center py-16">
            <div class="text-6xl mb-4">📝</div>
            <p class="text-gray-500">No posts yet. Check back soon!</p>
        </div>
        @endif
    </div>
</section>
@endsection
