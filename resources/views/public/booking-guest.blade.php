@extends('layouts.public')

@section('title', 'Your Details')

@section('content')
<section class="py-16 px-4" style="background-color:#2E4636;">
    <div class="max-w-7xl mx-auto text-center text-white">
        <h1 class="font-display text-4xl font-bold">Your Details</h1>
    </div>
</section>

<section class="py-16 px-4">
    <div class="max-w-2xl mx-auto">
        {{-- Summary --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm mb-6">
            <h3 class="font-semibold mb-3" style="color:#2E4636;">Booking Summary</h3>
            <div class="text-sm text-gray-600 space-y-1">
                <div class="flex justify-between"><span>Room:</span><span class="font-medium">{{ $roomType->name }}</span></div>
                <div class="flex justify-between"><span>Check-in:</span><span class="font-medium">{{ \Carbon\Carbon::parse($draft['check_in'])->format('d M Y') }}</span></div>
                <div class="flex justify-between"><span>Check-out:</span><span class="font-medium">{{ \Carbon\Carbon::parse($draft['check_out'])->format('d M Y') }}</span></div>
                <div class="flex justify-between"><span>Nights:</span><span class="font-medium">{{ $draft['nights'] }}</span></div>
                <div class="flex justify-between text-base font-bold mt-3 pt-3 border-t">
                    <span>Total:</span><span style="color:#C9A24B;">{{ frw($draft['total_amount'], 2) }}</span>
                </div>
                <p class="text-xs text-gray-400 mt-1">Incl. dinner & breakfast daily</p>
            </div>
        </div>

        <form action="{{ route('booking.guest-details.store') }}" method="POST" class="bg-white rounded-2xl p-8 shadow-md space-y-5">
            @csrf
            <div class="grid sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium mb-1">Full Name *</label>
                    <input type="text" name="guest_name" required value="{{ old('guest_name', auth()->user()?->name) }}"
                           class="w-full rounded-xl border border-gray-200 px-4 py-3 focus:outline-none focus:ring-2">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Email *</label>
                    <input type="email" name="guest_email" required value="{{ old('guest_email', auth()->user()?->email) }}"
                           class="w-full rounded-xl border border-gray-200 px-4 py-3 focus:outline-none focus:ring-2">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium mb-1">Phone (recommended for MoMo payment)</label>
                    <input type="tel" name="guest_phone" value="{{ old('guest_phone', auth()->user()?->phone) }}"
                           class="w-full rounded-xl border border-gray-200 px-4 py-3 focus:outline-none focus:ring-2">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium mb-1">Special Requests</label>
                    <textarea name="special_requests" rows="3"
                              class="w-full rounded-xl border border-gray-200 px-4 py-3 focus:outline-none focus:ring-2">{{ old('special_requests') }}</textarea>
                </div>
            </div>
            @if($errors->any())
            <div class="text-sm text-red-600">{{ $errors->first() }}</div>
            @endif
            <button type="submit" class="w-full py-3 rounded-xl text-white font-semibold transition hover:opacity-90" style="background-color:#BF6B47;">
                Continue to Payment →
            </button>
        </form>
    </div>
</section>
@endsection
