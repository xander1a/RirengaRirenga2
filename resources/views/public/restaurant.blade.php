@extends('layouts.public')

@section('title', __('nav.restaurant'))

@section('content')

<x-page-hero image="restaurant_hero" :title="__('nav.restaurant')" kicker="Farm-to-table" subtitle="Farm-to-table dining celebrating Rwandan ingredients. Breakfast & dinner included with every stay." />

{{-- Menu --}}
<section class="py-24 px-4">
    <div class="max-w-4xl mx-auto space-y-20">
        @foreach($categories as $cat)
        <div>
            <div class="flex items-center gap-4 mb-8">
                <h2 class="ed-title" style="font-size:clamp(1.6rem,3vw,2.25rem);">{{ $cat->local_name }}</h2>
                <span class="flex-1 ed-rule"></span>
            </div>

            <div class="divide-y" style="border-color:rgba(34,32,29,0.1);">
                @foreach($cat->items as $item)
                <div class="group flex gap-5 py-6" data-reveal>
                    @if($item->image_url)
                    <div class="ed-frame w-24 h-24 shrink-0 hidden sm:block">
                        <img src="{{ $item->image_url }}" alt="{{ $item->local_name }}" class="group-hover:scale-105 transition duration-700" loading="lazy">
                    </div>
                    @endif
                    <div class="flex-1 min-w-0">
                        <div class="flex items-baseline gap-3">
                            <h3 class="font-display text-xl font-bold" style="color:#22201D;">{{ $item->local_name }}</h3>
                            <span class="flex-1 border-b border-dotted border-gray-300"></span>
                            <span class="font-display font-bold text-lg whitespace-nowrap" style="color:#C99A52;">{{ money($item->price, $item->currency) }}</span>
                        </div>
                        @if($item->local_description)
                        <p class="text-gray-500 mt-2 leading-relaxed">{{ $item->local_description }}</p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
</section>

{{-- Table Reservation --}}
<section id="reserve" class="py-24 px-4" style="background:#1E3A4A;">
    <div class="max-w-xl mx-auto">
        <div class="mb-10">
            <span class="ed-kicker ed-kicker--light">Reservations</span>
            <h2 class="ed-title ed-title--light mt-4" style="font-size:clamp(1.9rem,4vw,2.75rem);">Reserve a Table</h2>
            <p class="mt-3" style="color:rgba(255,255,255,0.65);">We look forward to welcoming you. No reservation fee.</p>
        </div>
        <form action="{{ route('restaurant.reserve') }}" method="POST" class="p-8 space-y-5" style="background:#fff;border-radius:2px;">
            @csrf
            <div class="grid sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-[0.7rem] font-semibold uppercase tracking-wider text-gray-500 mb-1.5">Full Name *</label>
                    <input type="text" name="guest_name" required class="w-full border border-gray-200 px-4 py-3 focus:outline-none focus:border-[#3F7C8A]" style="border-radius:2px;" value="{{ old('guest_name') }}">
                </div>
                <div>
                    <label class="block text-[0.7rem] font-semibold uppercase tracking-wider text-gray-500 mb-1.5">Email *</label>
                    <input type="email" name="guest_email" required class="w-full border border-gray-200 px-4 py-3 focus:outline-none focus:border-[#3F7C8A]" style="border-radius:2px;" value="{{ old('guest_email') }}">
                </div>
                <div>
                    <label class="block text-[0.7rem] font-semibold uppercase tracking-wider text-gray-500 mb-1.5">Phone</label>
                    <input type="tel" name="guest_phone" class="w-full border border-gray-200 px-4 py-3 focus:outline-none focus:border-[#3F7C8A]" style="border-radius:2px;" value="{{ old('guest_phone') }}">
                </div>
                <div>
                    <label class="block text-[0.7rem] font-semibold uppercase tracking-wider text-gray-500 mb-1.5">Party Size *</label>
                    <input type="number" name="party_size" min="1" max="50" required class="w-full border border-gray-200 px-4 py-3 focus:outline-none focus:border-[#3F7C8A]" style="border-radius:2px;" value="{{ old('party_size', 2) }}">
                </div>
                <div>
                    <label class="block text-[0.7rem] font-semibold uppercase tracking-wider text-gray-500 mb-1.5">Date *</label>
                    <input type="date" name="date" required min="{{ date('Y-m-d') }}" class="w-full border border-gray-200 px-4 py-3 focus:outline-none focus:border-[#3F7C8A]" style="border-radius:2px;" value="{{ old('date') }}">
                </div>
                <div>
                    <label class="block text-[0.7rem] font-semibold uppercase tracking-wider text-gray-500 mb-1.5">Time *</label>
                    <input type="time" name="time" required class="w-full border border-gray-200 px-4 py-3 focus:outline-none focus:border-[#3F7C8A]" style="border-radius:2px;" value="{{ old('time') }}">
                </div>
            </div>
            <div>
                <label class="block text-[0.7rem] font-semibold uppercase tracking-wider text-gray-500 mb-1.5">Special Requests</label>
                <textarea name="special_requests" rows="3" class="w-full border border-gray-200 px-4 py-3 focus:outline-none focus:border-[#3F7C8A]" style="border-radius:2px;">{{ old('special_requests') }}</textarea>
            </div>
            @if($errors->any())
            <div class="text-sm text-red-600">{{ $errors->first() }}</div>
            @endif
            <button type="submit" class="ed-btn ed-btn-solid w-full">
                Request Reservation
            </button>
        </form>
    </div>
</section>

@endsection
