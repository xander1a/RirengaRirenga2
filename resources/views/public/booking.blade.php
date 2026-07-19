@extends('layouts.public')

@section('title', 'Book Your Stay')

@section('content')

<x-page-hero image="booking_hero" title="Book Your Stay" subtitle="All rooms include dinner & breakfast. Direct booking, best price guaranteed." />

<section class="py-16 px-4">
    <div class="max-w-4xl mx-auto">

        {{-- Step 1: Date + Guest Search --}}
        <div class="bg-white rounded-2xl p-8 shadow-md mb-8">
            <h2 class="font-display text-2xl font-semibold mb-6" style="color:#2E4636;">1. Select Dates & Guests</h2>
            <form method="GET" action="{{ route('booking') }}" class="grid sm:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Check-in *</label>
                    <input type="date" name="check_in" required min="{{ date('Y-m-d') }}"
                           value="{{ $checkIn ?? '' }}"
                           class="w-full rounded-xl border border-gray-200 px-4 py-3 focus:outline-none focus:ring-2">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Check-out *</label>
                    <input type="date" name="check_out" required
                           value="{{ $checkOut ?? '' }}"
                           class="w-full rounded-xl border border-gray-200 px-4 py-3 focus:outline-none focus:ring-2">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Guests</label>
                    <select name="guests" class="w-full rounded-xl border border-gray-200 px-4 py-3 focus:outline-none focus:ring-2">
                        @for($i=1; $i<=10; $i++)
                        <option value="{{ $i }}" {{ ($guests??1)==$i?'selected':'' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full py-3 rounded-xl text-white font-semibold transition hover:opacity-90" style="background-color:#BF6B47;">
                        Check Availability
                    </button>
                </div>
            </form>
        </div>

        {{-- Step 2: Available Rooms --}}
        @if($checkIn && $checkOut)
        <div>
            <h2 class="font-display text-2xl font-semibold mb-6" style="color:#2E4636;">2. Choose Your Room</h2>

            @if($availableRoomTypes->isEmpty())
            <div class="rounded-2xl p-8 text-center" style="background:#BF6B4710;border:1px solid #BF6B47;">
                <p class="text-lg font-medium" style="color:#BF6B47;">No rooms available for the selected dates.</p>
                <p class="text-gray-500 mt-2">Please try different dates or contact us directly.</p>
            </div>
            @else
            @php $nights = \Carbon\Carbon::parse($checkIn)->diffInDays($checkOut); @endphp

            <div class="space-y-6">
                @foreach($availableRoomTypes as $rt)
                <form method="POST" action="{{ route('booking.select-room') }}" class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                    @csrf
                    <input type="hidden" name="check_in" value="{{ $checkIn }}">
                    <input type="hidden" name="check_out" value="{{ $checkOut }}">
                    <input type="hidden" name="guests" value="{{ $guests }}">
                    <input type="hidden" name="room_type_id" value="{{ $rt->id }}">

                    <div class="p-6 flex flex-col sm:flex-row justify-between gap-6">
                        <div class="flex-1">
                            <div class="flex gap-3 items-start mb-3">
                                <span class="text-3xl">🌿</span>
                                <div>
                                    <h3 class="font-display text-xl font-semibold" style="color:#2E4636;">{{ $rt->name }}</h3>
                                    <p class="text-xs text-gray-400">Up to {{ $rt->max_guests }} guest(s)</p>
                                </div>
                            </div>
                            <p class="text-sm text-gray-500 mb-3">{{ $rt->description }}</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach(array_slice($rt->amenities ?? [], 0, 4) as $a)
                                <span class="text-xs px-2 py-1 rounded-full" style="background:#F1E9D7;color:#6E8C5A;">✓ {{ $a }}</span>
                                @endforeach
                            </div>
                        </div>
                        <div class="text-right flex flex-col justify-between min-w-32">
                            <div>
                                <p class="text-2xl font-bold" style="color:#C9A24B;">{{ money($rt->price_per_night, $rt->currency) }}<span class="text-sm text-gray-400">/night</span></p>
                                <p class="text-lg font-semibold mt-1" style="color:#2E4636;">{{ money($rt->price_per_night * $nights, $rt->currency) }} <span class="text-xs text-gray-400">total ({{ $nights }} nights)</span></p>
                                <p class="text-xs text-gray-400 mt-1">Incl. dinner & breakfast</p>
                            </div>
                            <button type="submit" class="mt-4 px-6 py-2 rounded-xl text-white text-sm font-semibold transition hover:opacity-90" style="background-color:#BF6B47;">
                                Select Room
                            </button>
                        </div>
                    </div>
                </form>
                @endforeach
            </div>
            @endif
        </div>
        @endif

        @if($errors->any())
        <div class="mt-4 rounded-xl p-4 text-sm" style="background:#BF6B4715;color:#BF6B47;">
            {{ $errors->first() }}
        </div>
        @endif
    </div>
</section>

@endsection
