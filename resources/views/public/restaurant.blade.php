@extends('layouts.public')

@section('title', __('nav.restaurant'))

@section('content')

<x-page-hero image="restaurant_hero" :title="__('nav.restaurant')" subtitle="Farm-to-table dining celebrating Rwandan ingredients. Breakfast & dinner included with every stay." />

{{-- Menu --}}
<section class="py-16 px-4">
    <div class="max-w-6xl mx-auto space-y-14">
        @foreach($categories as $cat)
        <div>
            <div class="text-center mb-8">
                <h2 class="font-display text-3xl font-bold" style="color:#2E4636;">{{ $cat->local_name }}</h2>
                <div class="mt-3 mx-auto h-1 w-14 rounded-full" style="background:#BF6B47;"></div>
            </div>

            <div class="space-y-8">
                @foreach($cat->items as $item)
                <div class="group bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow duration-300 sm:flex sm:items-stretch" data-reveal>
                    {{-- Photo --}}
                    <div class="sm:w-2/5 lg:w-1/3 h-56 sm:h-auto sm:min-h-[15rem] overflow-hidden shrink-0 {{ $loop->odd ? '' : 'sm:order-2' }}">
                        @if($item->image_url)
                        <img src="{{ $item->image_url }}" alt="{{ $item->local_name }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-700" loading="lazy">
                        @else
                        <x-icon-tile icon="dish" bg="linear-gradient(135deg, #6E8C5A18, #2E463625)" color="#6E8C5A" />
                        @endif
                    </div>

                    {{-- Details --}}
                    <div class="flex-1 p-6 sm:p-8 flex flex-col justify-center {{ $loop->odd ? '' : 'sm:order-1 sm:text-right' }}">
                        <div class="flex items-baseline gap-3 {{ $loop->odd ? '' : 'sm:flex-row-reverse' }}">
                            <h3 class="font-display text-xl lg:text-2xl font-semibold" style="color:#2B2A28;">{{ $item->local_name }}</h3>
                            <span class="flex-1 border-b border-dotted border-gray-300 hidden sm:block"></span>
                            <span class="font-bold text-lg whitespace-nowrap" style="color:#C9A24B;">{{ money($item->price, $item->currency) }}</span>
                        </div>
                        @if($item->local_description)
                        <p class="text-gray-500 mt-3 leading-relaxed max-w-xl {{ $loop->odd ? '' : 'sm:ml-auto' }}">{{ $item->local_description }}</p>
                        @endif
                        <div class="mt-4 h-0.5 w-10 rounded-full {{ $loop->odd ? '' : 'sm:ml-auto' }}" style="background:#BF6B4740;"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
</section>

{{-- Table Reservation --}}
<section id="reserve" class="py-20 px-4" style="background:#F1E9D7;">
    <div class="max-w-xl mx-auto">
        <div class="text-center mb-10">
            <h2 class="font-display text-3xl font-bold" style="color:#2E4636;">Reserve a Table</h2>
            <p class="text-gray-500 mt-2">We look forward to welcoming you. No reservation fee.</p>
        </div>
        <form action="{{ route('restaurant.reserve') }}" method="POST" class="bg-white rounded-2xl p-8 shadow-md space-y-5">
            @csrf
            <div class="grid sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium mb-1">Full Name *</label>
                    <input type="text" name="guest_name" required class="w-full rounded-xl border border-gray-200 px-4 py-3 focus:outline-none focus:ring-2" style="--tw-ring-color:#BF6B47;" value="{{ old('guest_name') }}">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Email *</label>
                    <input type="email" name="guest_email" required class="w-full rounded-xl border border-gray-200 px-4 py-3 focus:outline-none focus:ring-2" value="{{ old('guest_email') }}">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Phone</label>
                    <input type="tel" name="guest_phone" class="w-full rounded-xl border border-gray-200 px-4 py-3 focus:outline-none focus:ring-2" value="{{ old('guest_phone') }}">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Party Size *</label>
                    <input type="number" name="party_size" min="1" max="50" required class="w-full rounded-xl border border-gray-200 px-4 py-3 focus:outline-none focus:ring-2" value="{{ old('party_size', 2) }}">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Date *</label>
                    <input type="date" name="date" required min="{{ date('Y-m-d') }}" class="w-full rounded-xl border border-gray-200 px-4 py-3 focus:outline-none focus:ring-2" value="{{ old('date') }}">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Time *</label>
                    <input type="time" name="time" required class="w-full rounded-xl border border-gray-200 px-4 py-3 focus:outline-none focus:ring-2" value="{{ old('time') }}">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Special Requests</label>
                <textarea name="special_requests" rows="3" class="w-full rounded-xl border border-gray-200 px-4 py-3 focus:outline-none focus:ring-2">{{ old('special_requests') }}</textarea>
            </div>
            @if($errors->any())
            <div class="text-sm text-red-600">{{ $errors->first() }}</div>
            @endif
            <button type="submit" class="w-full py-3 rounded-xl text-white font-semibold transition hover:opacity-90" style="background-color:#BF6B47;">
                Request Reservation
            </button>
        </form>
    </div>
</section>

@endsection
