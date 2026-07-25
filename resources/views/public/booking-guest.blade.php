@extends('layouts.public')

@section('title', 'Your Details')

@section('content')
<section class="px-4 py-20 sm:py-24" style="background-color:#1E3A4A;">
    <div class="max-w-2xl mx-auto">
        <h1 class="ed-title ed-title--light" style="font-size:clamp(2.25rem,5vw,3.25rem);">Your Details</h1>
    </div>
</section>

<section class="py-24 px-4">
    <div class="max-w-2xl mx-auto">
        {{-- Summary --}}
        <div class="p-7 mb-8" style="background:#EFE9DC;border-radius:2px;">
            <h3 class="ed-kicker mb-4">Booking Summary</h3>
            <div class="text-sm text-gray-700 space-y-2">
                <div class="flex justify-between"><span class="text-gray-500">Room</span><span class="font-medium">{{ $roomType->name }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Check-in</span><span class="font-medium">{{ \Carbon\Carbon::parse($draft['check_in'])->format('d M Y') }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Check-out</span><span class="font-medium">{{ \Carbon\Carbon::parse($draft['check_out'])->format('d M Y') }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Nights</span><span class="font-medium">{{ $draft['nights'] }}</span></div>
                <div class="flex justify-between text-base font-bold mt-3 pt-3" style="border-top:1px solid rgba(34,32,29,0.15);">
                    <span>Total</span><span class="font-display" style="color:#C99A52;">{{ money($draft['total_amount'], $draft['currency'] ?? 'RWF') }}</span>
                </div>
                <p class="text-xs text-gray-400 mt-1">Incl. dinner &amp; breakfast daily</p>
            </div>
        </div>

        <form action="{{ route('booking.guest-details.store') }}" method="POST" class="p-8 space-y-5" style="background:#fff;border:1px solid rgba(34,32,29,0.12);border-radius:2px;">
            @csrf
            <div class="grid sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-[0.7rem] font-semibold uppercase tracking-wider text-gray-500 mb-1.5">Full Name *</label>
                    <input type="text" name="guest_name" required value="{{ old('guest_name', auth()->user()?->name) }}"
                           class="w-full border border-gray-200 px-4 py-3 focus:outline-none focus:border-[#3F7C8A]" style="border-radius:2px;">
                </div>
                <div>
                    <label class="block text-[0.7rem] font-semibold uppercase tracking-wider text-gray-500 mb-1.5">Email *</label>
                    <input type="email" name="guest_email" required value="{{ old('guest_email', auth()->user()?->email) }}"
                           class="w-full border border-gray-200 px-4 py-3 focus:outline-none focus:border-[#3F7C8A]" style="border-radius:2px;">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-[0.7rem] font-semibold uppercase tracking-wider text-gray-500 mb-1.5">Phone (recommended for MoMo payment)</label>
                    <input type="tel" name="guest_phone" value="{{ old('guest_phone', auth()->user()?->phone) }}"
                           class="w-full border border-gray-200 px-4 py-3 focus:outline-none focus:border-[#3F7C8A]" style="border-radius:2px;">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-[0.7rem] font-semibold uppercase tracking-wider text-gray-500 mb-1.5">Special Requests</label>
                    <textarea name="special_requests" rows="3"
                              class="w-full border border-gray-200 px-4 py-3 focus:outline-none focus:border-[#3F7C8A]" style="border-radius:2px;">{{ old('special_requests') }}</textarea>
                </div>
            </div>
            @if($errors->any())
            <div class="text-sm text-red-600">{{ $errors->first() }}</div>
            @endif
            <button type="submit" class="ed-btn ed-btn-solid w-full">
                Continue to Payment
            </button>
        </form>
    </div>
</section>
@endsection
