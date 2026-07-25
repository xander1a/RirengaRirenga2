@props(['image' => null, 'title', 'subtitle' => null, 'kicker' => 'Rirenga Eco-Lodge'])

@php $url = site_image($image); @endphp
<section class="relative px-4 overflow-hidden {{ $url ? 'py-28 sm:py-36' : 'py-20 sm:py-24' }}"
         @if($url)
         style="background-image: linear-gradient(to right, rgba(30,58,74,0.82), rgba(30,58,74,0.45)), url('{{ $url }}'); background-size: cover; background-position: center;"
         @else
         style="background-color:#1E3A4A;"
         @endif>
    <div class="max-w-7xl mx-auto relative z-10">
        <div class="max-w-2xl">
            <h1 class="ed-title ed-title--light" style="font-size:clamp(2.5rem,6vw,4.25rem);">{{ $title }}</h1>
            @if($subtitle)
            <p class="mt-5 text-lg leading-relaxed max-w-xl" style="color:rgba(255,255,255,0.8);font-weight:300;">{{ $subtitle }}</p>
            @endif
            <div class="ed-rule-gold mt-7"></div>
        </div>
    </div>
</section>
