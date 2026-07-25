@extends('layouts.public')

@section('title', 'Book Your Stay')

@section('content')

<x-page-hero image="booking_hero" title="Book Your Stay" kicker="Reservations" subtitle="All rooms include dinner & breakfast. Direct booking, best price guaranteed." />

<section class="py-24 px-4">
    <div class="max-w-4xl mx-auto">

        {{-- Step 1: Date + Guest Search --}}
        <div class="p-8 mb-10" style="background:#fff;border:1px solid rgba(34,32,29,0.12);border-radius:2px;">
            <div class="flex items-center gap-4 mb-7">
                <span class="ed-index">01</span>
                <h2 class="ed-title" style="font-size:1.5rem;">Select Dates &amp; Guests</h2>
            </div>
            <form method="GET" action="{{ route('booking') }}" class="grid sm:grid-cols-4 gap-4">
                <div>
                    <label class="block text-[0.7rem] font-semibold uppercase tracking-wider text-gray-500 mb-1.5">Check-in *</label>
                    <input type="date" name="check_in" required min="{{ date('Y-m-d') }}"
                           value="{{ $checkIn ?? '' }}"
                           class="w-full border border-gray-200 px-4 py-3 focus:outline-none focus:border-[#3F7C8A]" style="border-radius:2px;">
                </div>
                <div>
                    <label class="block text-[0.7rem] font-semibold uppercase tracking-wider text-gray-500 mb-1.5">Check-out *</label>
                    <input type="date" name="check_out" required
                           value="{{ $checkOut ?? '' }}"
                           class="w-full border border-gray-200 px-4 py-3 focus:outline-none focus:border-[#3F7C8A]" style="border-radius:2px;">
                </div>
                <div>
                    <label class="block text-[0.7rem] font-semibold uppercase tracking-wider text-gray-500 mb-1.5">Guests</label>
                    <select name="guests" class="w-full border border-gray-200 px-4 py-3 focus:outline-none focus:border-[#3F7C8A]" style="border-radius:2px;">
                        @for($i=1; $i<=10; $i++)
                        <option value="{{ $i }}" {{ ($guests??1)==$i?'selected':'' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="ed-btn ed-btn-solid w-full">
                        Check
                    </button>
                </div>
            </form>
        </div>

        {{-- Step 2: Available Rooms --}}
        @if($checkIn && $checkOut)
        <div>
            <div class="flex items-center gap-4 mb-7">
                <span class="ed-index">02</span>
                <h2 class="ed-title" style="font-size:1.5rem;">Choose Your Room</h2>
            </div>

            @if($availableRoomTypes->isEmpty())
            <div class="p-8 text-center" style="background:#D07A5410;border:1px solid #D07A54;border-radius:2px;">
                <p class="text-lg font-medium" style="color:#D07A54;">No rooms available for the selected dates.</p>
                <p class="text-gray-500 mt-2">Please try different dates or contact us directly.</p>
            </div>
            @else
            @php $nights = \Carbon\Carbon::parse($checkIn)->diffInDays($checkOut); @endphp

            <div class="divide-y" style="border-top:1px solid rgba(34,32,29,0.12);border-color:rgba(34,32,29,0.12);">
                @foreach($availableRoomTypes as $rt)
                <form method="POST" action="{{ route('booking.select-room') }}" class="py-8">
                    @csrf
                    <input type="hidden" name="check_in" value="{{ $checkIn }}">
                    <input type="hidden" name="check_out" value="{{ $checkOut }}">
                    <input type="hidden" name="guests" value="{{ $guests }}">
                    <input type="hidden" name="room_type_id" value="{{ $rt->id }}">

                    <div class="flex flex-col sm:flex-row justify-between gap-6">
                        <div class="flex-1">
                            <h3 class="ed-title" style="font-size:1.5rem;">{{ $rt->name }}</h3>
                            <p class="ed-kicker mt-2" style="color:rgba(34,32,29,0.4);">Up to {{ $rt->max_guests }} guest(s)</p>
                            <p class="text-sm text-gray-500 my-4 max-w-lg">{{ $rt->description }}</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach(array_slice($rt->amenities ?? [], 0, 4) as $a)
                                <span class="text-xs px-3 py-1.5 tracking-wide" style="background:#EFE9DC;color:#3F7C8A;border-radius:2px;">{{ $a }}</span>
                                @endforeach
                            </div>
                        </div>
                        <div class="text-right flex flex-col justify-between sm:min-w-40">
                            <div>
                                <p class="font-display text-2xl font-bold" style="color:#C99A52;">{{ money($rt->price_per_night, $rt->currency) }}<span class="text-sm text-gray-400 font-sans"> / night</span></p>
                                <p class="text-base font-semibold mt-1" style="color:#1E3A4A;">{{ money($rt->price_per_night * $nights, $rt->currency) }} <span class="text-xs text-gray-400 font-normal">total · {{ $nights }} nights</span></p>
                                <p class="text-xs text-gray-400 mt-1">Incl. dinner &amp; breakfast</p>
                            </div>
                            <button type="submit" class="ed-btn ed-btn-solid mt-4">
                                Select room
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
        <div class="mt-6 p-4 text-sm" style="background:#D07A5415;color:#D07A54;border-radius:2px;">
            {{ $errors->first() }}
        </div>
        @endif
    </div>
</section>

@endsection
