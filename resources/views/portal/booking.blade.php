@extends('layouts.public')

@section('content')
<div class="py-12 px-4">
    <div class="max-w-2xl mx-auto">
        <a href="{{ route('portal.dashboard') }}" class="text-sm text-gray-500 hover:text-gray-700 mb-6 inline-block">← My Account</a>
        <div class="bg-white rounded-2xl p-8 shadow-sm">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h1 class="font-display text-2xl font-bold" style="color:#2E4636;">{{ $booking->reference }}</h1>
                    <p class="text-sm text-gray-400 mt-1">Booked {{ $booking->created_at->format('d M Y') }}</p>
                </div>
                <span class="px-3 py-1 rounded-full text-sm font-semibold capitalize {{ $booking->status==='confirmed'?'bg-green-100 text-green-700':($booking->status==='cancelled'?'bg-red-100 text-red-700':'bg-yellow-100 text-yellow-700') }}">
                    {{ $booking->status }}
                </span>
            </div>
            <div class="space-y-3 text-sm">
                @foreach([
                    ['Room', $booking->room->roomType->name.' — '.$booking->room->name],
                    ['Check-in', $booking->check_in->format('l, d M Y')],
                    ['Check-out', $booking->check_out->format('l, d M Y')],
                    ['Nights', $booking->nights],
                    ['Guests', $booking->guests],
                    ['Includes', '✓ Dinner & Breakfast daily'],
                ] as [$label, $val])
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-gray-500">{{ $label }}</span>
                    <span class="font-medium">{{ $val }}</span>
                </div>
                @endforeach
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-gray-500">Total</span>
                    <span class="font-bold text-base" style="color:#C9A24B;">{{ frw($booking->total_amount, 2) }}</span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-gray-500">Payment Status</span>
                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold capitalize {{ in_array($booking->payment_status,['paid','manual_confirmed'])?'bg-green-100 text-green-700':'bg-yellow-100 text-yellow-700' }}">
                        {{ str_replace('_',' ',$booking->payment_status) }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
