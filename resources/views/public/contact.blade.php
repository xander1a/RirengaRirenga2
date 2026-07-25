@extends('layouts.public')
@section('title', __('contact.title'))
@section('content')
<x-page-hero image="contact_hero" :title="__('contact.title')" kicker="Get in Touch" />

<section class="py-24 px-4">
    <div class="max-w-6xl mx-auto grid lg:grid-cols-2 gap-16">
        {{-- Contact Info --}}
        <div>
            <span class="ed-kicker">Reach us</span>
            <h2 class="ed-title mt-5" style="font-size:clamp(1.9rem,4vw,2.75rem);">Get in Touch</h2>

            <div class="mt-10 divide-y" style="border-top:1px solid rgba(34,32,29,0.14);border-color:rgba(34,32,29,0.14);">
                <div class="py-5">
                    <p class="text-[0.68rem] font-semibold uppercase tracking-[0.2em] text-gray-400 mb-1.5">{{ __('contact.address') }}</p>
                    <p class="text-gray-700">On a hilltop between the twin lakes of Ruhondo and Burera, overlooking the Virunga volcanoes — Northern Province, Rwanda</p>
                    <a href="https://maps.app.goo.gl/tdT1uAKM9XU2Dh9S7" target="_blank" rel="noopener" class="ed-arrow mt-3">
                        Open in Google Maps
                        <svg fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
                <div class="py-5">
                    <p class="text-[0.68rem] font-semibold uppercase tracking-[0.2em] text-gray-400 mb-1.5">{{ __('contact.phone') }}</p>
                    <a href="tel:+250787770750" class="text-gray-700 hover:text-[#D07A54]">0787 770 750</a>
                </div>
                <div class="py-5">
                    <p class="text-[0.68rem] font-semibold uppercase tracking-[0.2em] text-gray-400 mb-1.5">WhatsApp</p>
                    <a href="https://wa.me/250787770750" target="_blank" rel="noopener" class="text-gray-700 hover:text-[#D07A54]">+250 787 770 750</a>
                </div>
                <div class="py-5">
                    <p class="text-[0.68rem] font-semibold uppercase tracking-[0.2em] text-gray-400 mb-1.5">{{ __('contact.email_label') }}</p>
                    <a href="mailto:izubatreat@gmail.com" class="text-gray-700 hover:text-[#D07A54]">izubatreat@gmail.com</a>
                </div>
            </div>

            {{-- Map --}}
            <a href="https://maps.app.goo.gl/tdT1uAKM9XU2Dh9S7" target="_blank" rel="noopener"
               class="ed-frame group mt-8 block relative" style="height:200px;background:#1E3A4A;">
                <div class="absolute inset-0 opacity-20"
                     style="background-image: radial-gradient(circle, #C99A52 1px, transparent 1px); background-size: 22px 22px;"></div>
                <div class="relative z-10 h-full flex flex-col items-center justify-center text-center text-white px-4">
                    <span class="font-display text-lg font-bold">Find us on Google Maps</span>
                    <span class="text-white/60 text-sm mt-1">Ruhondo &amp; Burera lakes, Northern Rwanda</span>
                    <span class="ed-btn ed-btn-solid mt-4" style="padding:0.55rem 1.3rem;">Get directions</span>
                </div>
            </a>
        </div>

        {{-- Contact Form --}}
        <form action="{{ route('contact.send') }}" method="POST" class="p-8 space-y-5" style="background:#fff;border:1px solid rgba(34,32,29,0.12);border-radius:2px;">
            @csrf
            <div class="grid sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-[0.7rem] font-semibold uppercase tracking-wider text-gray-500 mb-1.5">{{ __('contact.name') }} *</label>
                    <input type="text" name="name" required value="{{ old('name') }}"
                           class="w-full border border-gray-200 px-4 py-3 focus:outline-none focus:border-[#3F7C8A]" style="border-radius:2px;">
                </div>
                <div>
                    <label class="block text-[0.7rem] font-semibold uppercase tracking-wider text-gray-500 mb-1.5">{{ __('contact.email') }} *</label>
                    <input type="email" name="email" required value="{{ old('email') }}"
                           class="w-full border border-gray-200 px-4 py-3 focus:outline-none focus:border-[#3F7C8A]" style="border-radius:2px;">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-[0.7rem] font-semibold uppercase tracking-wider text-gray-500 mb-1.5">{{ __('contact.subject') }}</label>
                    <input type="text" name="subject" value="{{ old('subject') }}"
                           class="w-full border border-gray-200 px-4 py-3 focus:outline-none focus:border-[#3F7C8A]" style="border-radius:2px;">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-[0.7rem] font-semibold uppercase tracking-wider text-gray-500 mb-1.5">{{ __('contact.message') }} *</label>
                    <textarea name="message" rows="5" required
                              class="w-full border border-gray-200 px-4 py-3 focus:outline-none focus:border-[#3F7C8A]" style="border-radius:2px;">{{ old('message') }}</textarea>
                </div>
            </div>
            @if($errors->any())
            <div class="text-sm text-red-600">{{ $errors->first() }}</div>
            @endif
            <button type="submit" class="ed-btn ed-btn-solid w-full">
                {{ __('contact.send') }}
            </button>
        </form>
    </div>
</section>
@endsection
