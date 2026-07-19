@extends('layouts.public')
@section('title', __('contact.title'))
@section('content')
<x-page-hero image="contact_hero" :title="__('contact.title')" />
<section class="py-16 px-4">
    <div class="max-w-6xl mx-auto grid lg:grid-cols-2 gap-12">
        {{-- Contact Info --}}
        <div>
            <h2 class="font-display text-3xl font-bold mb-6" style="color:#2E4636;">Get in Touch</h2>
            <div class="space-y-5 text-gray-600">
                <div class="flex gap-4 items-start">
                    <span class="text-2xl">📍</span>
                    <div>
                        <p class="font-semibold">{{ __('contact.address') }}</p>
                        <p class="text-sm mt-1">Rwanda (exact address provided on booking confirmation)</p>
                    </div>
                </div>
                <div class="flex gap-4 items-start">
                    <span class="text-2xl">📞</span>
                    <div>
                        <p class="font-semibold">{{ __('contact.phone') }}</p>
                        <a href="tel:+250787770750" class="text-sm mt-1 hover:underline" style="color:#BF6B47;">0787 770 750</a>
                    </div>
                </div>
                <div class="flex gap-4 items-start">
                    <span class="text-2xl">💬</span>
                    <div>
                        <p class="font-semibold">WhatsApp</p>
                        <a href="https://wa.me/250787770750" target="_blank" rel="noopener" class="text-sm mt-1 hover:underline" style="color:#BF6B47;">+250 787 770 750</a>
                    </div>
                </div>
                <div class="flex gap-4 items-start">
                    <span class="text-2xl">✉️</span>
                    <div>
                        <p class="font-semibold">{{ __('contact.email_label') }}</p>
                        <a href="mailto:izubatreat@gmail.com" class="text-sm mt-1 hover:underline" style="color:#BF6B47;">izubatreat@gmail.com</a>
                    </div>
                </div>
            </div>
            {{-- Map placeholder --}}
            <div class="mt-8 rounded-2xl overflow-hidden flex items-center justify-center text-4xl" style="background:#6E8C5A20;height:200px;">
                🗺️ <span class="ml-3 text-lg text-gray-500">Map embed — TODO: add Google Maps embed</span>
            </div>
        </div>

        {{-- Contact Form --}}
        <form action="{{ route('contact.send') }}" method="POST" class="bg-white rounded-2xl p-8 shadow-md space-y-5">
            @csrf
            <div class="grid sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium mb-1">{{ __('contact.name') }} *</label>
                    <input type="text" name="name" required value="{{ old('name') }}"
                           class="w-full rounded-xl border border-gray-200 px-4 py-3 focus:outline-none focus:ring-2">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">{{ __('contact.email') }} *</label>
                    <input type="email" name="email" required value="{{ old('email') }}"
                           class="w-full rounded-xl border border-gray-200 px-4 py-3 focus:outline-none focus:ring-2">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium mb-1">{{ __('contact.subject') }}</label>
                    <input type="text" name="subject" value="{{ old('subject') }}"
                           class="w-full rounded-xl border border-gray-200 px-4 py-3 focus:outline-none focus:ring-2">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium mb-1">{{ __('contact.message') }} *</label>
                    <textarea name="message" rows="5" required
                              class="w-full rounded-xl border border-gray-200 px-4 py-3 focus:outline-none focus:ring-2">{{ old('message') }}</textarea>
                </div>
            </div>
            @if($errors->any())
            <div class="text-sm text-red-600">{{ $errors->first() }}</div>
            @endif
            <button type="submit" class="w-full py-3 rounded-xl text-white font-semibold transition hover:opacity-90" style="background-color:#BF6B47;">
                {{ __('contact.send') }}
            </button>
        </form>
    </div>
</section>
@endsection
