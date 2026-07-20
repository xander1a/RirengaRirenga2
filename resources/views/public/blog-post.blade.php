@extends('layouts.public')
@section('title', $blogPost->local_title)
@section('content')
<section class="relative py-16 px-4 overflow-hidden {{ $blogPost->image_url ? 'py-24 sm:py-32' : '' }}"
         @if($blogPost->image_url)
         style="background-image: linear-gradient(to bottom, rgba(32,51,31,0.6), rgba(46,70,54,0.8)), url('{{ $blogPost->image_url }}'); background-size: cover; background-position: center;"
         @else
         style="background-color:#2E4636;"
         @endif>
    <div class="max-w-3xl mx-auto text-white relative z-10">
        <a href="{{ route('blog') }}" class="text-white/60 hover:text-white text-sm mb-6 inline-block">← Back to Blog</a>
        <h1 class="font-display text-4xl lg:text-5xl font-bold drop-shadow">{{ $blogPost->local_title }}</h1>
        <p class="mt-4 text-white/60 text-sm">{{ $blogPost->published_at?->format('d M Y') }} &bull; {{ $blogPost->author?->name ?? 'Byiza Lodge Team' }}</p>
    </div>
</section>
<section class="py-16 px-4">
    <div class="max-w-3xl mx-auto prose prose-lg max-w-none">
        {!! (app()->getLocale() === 'fr' && $blogPost->body_fr) ? $blogPost->body_fr : $blogPost->body !!}
    </div>
</section>
@endsection
