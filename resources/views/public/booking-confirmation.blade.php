@extends('layouts.public')

@section('title', 'Booking Confirmed')

@section('content')
<section class="px-4 py-20 sm:py-24 text-center" style="background-color:#1E3A4A;">
    <div class="max-w-2xl mx-auto">
        <div class="text-6xl mb-6">🎉</div>
        <h1 class="ed-title ed-title--light" style="font-size:clamp(2.25rem,5vw,3.25rem);">Booking Received</h1>
        <p class="mt-5" style="color:rgba(255,255,255,0.75);">Thank you, <strong class="text-white">{{ $booking->guest_name }}</strong>. We look forward to welcoming you at Rirenga.</p>
    </div>
</section>

<section class="py-24 px-4">
    <div class="max-w-2xl mx-auto">
        <div class="p-8 text-left mb-8" style="background:#fff;border:1px solid rgba(34,32,29,0.12);border-radius:2px;">
            <div class="flex justify-between items-center mb-6">
                <h2 class="ed-kicker">Booking Details</h2>
                <span class="px-3 py-1 text-xs font-bold uppercase tracking-wide" style="background:#EFE9DC;color:#3F7C8A;border-radius:2px;">{{ $booking->reference }}</span>
            </div>
            <div class="text-sm divide-y" style="border-color:rgba(34,32,29,0.08);">
                <div class="flex justify-between py-2.5"><span class="text-gray-500">Room</span><span class="font-medium">{{ $booking->room->roomType->name }} — {{ $booking->room->name }}</span></div>
                <div class="flex justify-between py-2.5"><span class="text-gray-500">Check-in</span><span class="font-medium">{{ $booking->check_in->format('l, d M Y') }}</span></div>
                <div class="flex justify-between py-2.5"><span class="text-gray-500">Check-out</span><span class="font-medium">{{ $booking->check_out->format('l, d M Y') }}</span></div>
                <div class="flex justify-between py-2.5"><span class="text-gray-500">Nights</span><span class="font-medium">{{ $booking->nights }}</span></div>
                <div class="flex justify-between py-2.5"><span class="text-gray-500">Guests</span><span class="font-medium">{{ $booking->guests }}</span></div>
                <div class="flex justify-between py-2.5"><span class="text-gray-500">Includes</span><span class="font-medium text-green-700">✓ Dinner &amp; Breakfast daily</span></div>
                <div class="flex justify-between py-2.5"><span class="text-gray-500">Total Amount</span><span class="font-display font-bold text-base" style="color:#C99A52;">{{ money($booking->total_amount, $booking->currency) }}</span></div>
                <div class="flex justify-between py-2.5"><span class="text-gray-500">Payment Method</span><span class="font-medium capitalize">{{ str_replace('_', ' ', $booking->payment_method ?? 'N/A') }}</span></div>
                <div class="flex justify-between py-2.5">
                    <span class="text-gray-500">Payment Status</span>
                    <span class="px-2 py-0.5 text-xs font-semibold capitalize {{ $booking->payment_status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}" style="border-radius:2px;">
                        {{ str_replace('_', ' ', $booking->payment_status) }}
                    </span>
                </div>
            </div>
        </div>

        @if($booking->payment_method === 'bank_transfer')
        <div class="p-5 mb-6 text-sm text-left" style="background:#EFE9DC;border:1px solid #C99A52;border-radius:2px;">
            <p class="ed-kicker mb-3">Complete Your Bank Transfer</p>
            <p>Please transfer <strong>{{ money($booking->total_amount, $booking->currency) }}</strong> to:</p>
            <p class="mt-1">Bank: <strong>Bank of Kigali</strong> | Account: <strong>TODO</strong></p>
            <p>Reference: <strong>{{ $booking->reference }}</strong></p>
            <p class="mt-2 text-gray-500">Send proof of payment to <a href="mailto:izubatreat@gmail.com" class="underline">izubatreat@gmail.com</a></p>
        </div>
        @endif

        <p class="text-sm text-gray-500 mb-8 text-center">A confirmation email has been sent to <strong>{{ $booking->guest_email }}</strong>.</p>

        <div class="flex flex-wrap gap-4 justify-center">
            <a href="{{ route('home') }}" class="ed-btn ed-btn-outline">Back to Home</a>
            @auth
            <a href="{{ route('portal.booking', $booking->reference) }}" class="ed-btn ed-btn-solid">View My Booking</a>
            @endauth
        </div>
    </div>
</section>
@endsection
