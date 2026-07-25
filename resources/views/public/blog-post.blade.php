@extends('layouts.public')
@section('title', $blogPost->local_title)
@section('content')
<section class="relative px-4 overflow-hidden {{ $blogPost->image_url ? 'py-28 sm:py-36' : 'py-20 sm:py-24' }}"
         @if($blogPost->image_url)
         style="background-image: linear-gradient(to right, rgba(30,58,74,0.85), rgba(30,58,74,0.5)), url('{{ $blogPost->image_url }}'); background-size: cover; background-position: center;"
         @else
         style="background-color:#1E3A4A;"
         @endif>
    <div class="max-w-3xl mx-auto text-white relative z-10">
        <a href="{{ route('blog') }}" class="ed-arrow ed-kicker--light mb-6" style="color:rgba(255,255,255,0.7);">
            <svg fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24" style="transform:rotate(180deg);"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            Back to Journal
        </a>
        <h1 class="ed-title ed-title--light" style="font-size:clamp(2.25rem,5vw,3.75rem);">{{ $blogPost->local_title }}</h1>
        <p class="mt-4 text-sm" style="color:rgba(255,255,255,0.6);">{{ $blogPost->published_at?->format('d M Y') }} &middot; {{ $blogPost->author?->name ?? 'Rirenga Team' }}</p>
        <div class="ed-rule-gold mt-7"></div>
    </div>
</section>
<section class="py-20 px-4">
    <div class="max-w-2xl mx-auto prose prose-lg max-w-none ed-dropcap">
        {!! (app()->getLocale() === 'fr' && $blogPost->body_fr) ? $blogPost->body_fr : $blogPost->body !!}
    </div>
</section>
@endsection
