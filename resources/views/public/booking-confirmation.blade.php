@extends('layouts.public')

@section('title', 'Booking Confirmed')

@section('content')
<section class="py-20 px-4">
    <div class="max-w-2xl mx-auto text-center">
        <div class="text-6xl mb-6">🎉</div>
        <h1 class="font-display text-4xl font-bold mb-4" style="color:#2E4636;">Booking Received!</h1>
        <p class="text-gray-600 mb-8">Thank you, <strong>{{ $booking->guest_name }}</strong>. We look forward to welcoming you at Byiza Lodge Ltd.</p>

        <div class="bg-white rounded-2xl p-8 shadow-md text-left mb-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="font-semibold text-lg" style="color:#2E4636;">Booking Details</h2>
                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase" style="background:#F1E9D7;color:#6E8C5A;">{{ $booking->reference }}</span>
            </div>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-gray-500">Room</span>
                    <span class="font-medium">{{ $booking->room->roomType->name }} — {{ $booking->room->name }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-gray-500">Check-in</span>
                    <span class="font-medium">{{ $booking->check_in->format('l, d M Y') }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-gray-500">Check-out</span>
                    <span class="font-medium">{{ $booking->check_out->format('l, d M Y') }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-gray-500">Nights</span>
                    <span class="font-medium">{{ $booking->nights }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-gray-500">Guests</span>
                    <span class="font-medium">{{ $booking->guests }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-gray-500">Includes</span>
                    <span class="font-medium text-green-700">✓ Dinner & Breakfast daily</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-gray-500">Total Amount</span>
                    <span class="font-bold text-base" style="color:#C9A24B;">{{ money($booking->total_amount, $booking->currency) }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-gray-500">Payment Method</span>
                    <span class="font-medium capitalize">{{ str_replace('_', ' ', $booking->payment_method ?? 'N/A') }}</span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-gray-500">Payment Status</span>
                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold capitalize {{ $booking->payment_status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                        {{ str_replace('_', ' ', $booking->payment_status) }}
                    </span>
                </div>
            </div>
        </div>

        @if($booking->payment_method === 'bank_transfer')
        <div class="rounded-2xl p-5 mb-6 text-sm text-left" style="background:#F1E9D7;border:1px solid #C9A24B;">
            <p class="font-semibold mb-2" style="color:#2E4636;">Complete Your Bank Transfer</p>
            <p>Please transfer <strong>{{ money($booking->total_amount, $booking->currency) }}</strong> to:</p>
            <p class="mt-1">Bank: <strong>Bank of Kigali</strong> | Account: <strong>TODO</strong></p>
            <p>Reference: <strong>{{ $booking->reference }}</strong></p>
            <p class="mt-2 text-gray-500">Send proof of payment to <a href="mailto:izubatreat@gmail.com" class="underline">izubatreat@gmail.com</a></p>
        </div>
        @endif

        <p class="text-sm text-gray-500 mb-6">A confirmation email has been sent to <strong>{{ $booking->guest_email }}</strong>.</p>

        <div class="flex gap-4 justify-center">
            <a href="{{ route('home') }}" class="px-6 py-3 rounded-xl border-2 font-semibold transition" style="border-color:#2E4636;color:#2E4636;">
                Back to Home
            </a>
            @auth
            <a href="{{ route('portal.booking', $booking->reference) }}" class="px-6 py-3 rounded-xl text-white font-semibold transition hover:opacity-90" style="background-color:#BF6B47;">
                View My Booking
            </a>
            @endauth
        </div>
    </div>
</section>
@endsection
