@extends('layouts.public')
@section('title', $blogPost->local_title)
@section('content')
<section class="py-16 px-4" style="background-color:#2E4636;">
    <div class="max-w-3xl mx-auto text-white">
        <a href="{{ route('blog') }}" class="text-white/60 hover:text-white text-sm mb-6 inline-block">← Back to Blog</a>
        <h1 class="font-display text-4xl lg:text-5xl font-bold">{{ $blogPost->local_title }}</h1>
        <p class="mt-4 text-white/60 text-sm">{{ $blogPost->published_at?->format('d M Y') }} &bull; {{ $blogPost->author?->name ?? 'BYIZA Team' }}</p>
    </div>
</section>
<section class="py-16 px-4">
    <div class="max-w-3xl mx-auto prose prose-lg max-w-none">
        {!! (app()->getLocale() === 'fr' && $blogPost->body_fr) ? $blogPost->body_fr : $blogPost->body !!}
    </div>
</section>
@endsection
