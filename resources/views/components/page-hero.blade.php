@props(['image' => null, 'title', 'subtitle' => null])

@php $url = site_image($image); @endphp
<section class="relative px-4 overflow-hidden {{ $url ? 'py-24 sm:py-32' : 'py-16' }}"
         @if($url)
         style="background-image: linear-gradient(to bottom, rgba(32,51,31,0.55), rgba(46,70,54,0.75)), url('{{ $url }}'); background-size: cover; background-position: center;"
         @else
         style="background-color:#2E4636;"
         @endif>
    <div class="max-w-7xl mx-auto text-center text-white relative z-10">
        <h1 class="font-display text-4xl sm:text-5xl font-bold drop-shadow">{{ $title }}</h1>
        @if($subtitle)
        <p class="mt-3 text-white/80 max-w-2xl mx-auto">{{ $subtitle }}</p>
        @endif
        <div class="mt-5 mx-auto h-1 w-16 rounded-full" style="background:#C9A24B;"></div>
    </div>
</section>
