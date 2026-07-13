@extends('layouts.admin')
@section('title', 'Booking '.$booking->reference)

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <a href="{{ route('admin.bookings.index') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-700">
        <x-admin-icon name="chevron-right" class="w-4 h-4 rotate-180" /> All Bookings
    </a>

    <div class="bg-white rounded-2xl p-8 shadow-sm">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h2 class="font-display text-2xl font-bold" style="color:#2E4636;">{{ $booking->reference }}</h2>
                <p class="text-sm text-gray-400">Created {{ $booking->created_at->format('d M Y H:i') }}</p>
            </div>
            <div class="text-right">
                <span class="px-3 py-1 rounded-full text-sm font-semibold capitalize {{ $booking->status==='confirmed'?'bg-green-100 text-green-700':($booking->status==='cancelled'?'bg-red-100 text-red-700':'bg-yellow-100 text-yellow-700') }}">
                    {{ $booking->status }}
                </span>
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-6 text-sm">
            <div class="space-y-3">
                <h3 class="font-semibold text-gray-700 uppercase text-xs tracking-wide">Guest</h3>
                <p><strong>{{ $booking->guest_name }}</strong></p>
                <p>{{ $booking->guest_email }}</p>
                <p>{{ $booking->guest_phone ?? 'No phone' }}</p>
            </div>
            <div class="space-y-3">
                <h3 class="font-semibold text-gray-700 uppercase text-xs tracking-wide">Stay</h3>
                <p>Room: <strong>{{ $booking->room->roomType->name ?? '—' }} ({{ $booking->room->name }})</strong></p>
                <p>Check-in: <strong>{{ $booking->check_in->format('d M Y') }}</strong></p>
                <p>Check-out: <strong>{{ $booking->check_out->format('d M Y') }}</strong></p>
                <p>Nights: <strong>{{ $booking->nights }}</strong> · Guests: <strong>{{ $booking->guests }}</strong></p>
            </div>
            <div class="space-y-3">
                <h3 class="font-semibold text-gray-700 uppercase text-xs tracking-wide">Payment</h3>
                <p>Total: <strong style="color:#C9A24B;">{{ frw($booking->total_amount, 2) }}</strong></p>
                <p>Method: <strong class="capitalize">{{ str_replace('_',' ',$booking->payment_method ?? 'N/A') }}</strong></p>
                <p>Status: <span class="px-2 py-0.5 rounded-full text-xs font-semibold capitalize {{ $booking->payment_status==='paid'||$booking->payment_status==='manual_confirmed'?'bg-green-100 text-green-700':'bg-yellow-100 text-yellow-700' }}">{{ str_replace('_',' ',$booking->payment_status) }}</span></p>
            </div>
            @if($booking->special_requests)
            <div>
                <h3 class="font-semibold text-gray-700 uppercase text-xs tracking-wide mb-2">Special Requests</h3>
                <p class="text-gray-600">{{ $booking->special_requests }}</p>
            </div>
            @endif
        </div>

        {{-- Actions --}}
        <div class="mt-8 pt-6 border-t border-gray-100 flex flex-wrap gap-3">
            <form action="{{ route('admin.bookings.status', $booking) }}" method="POST" class="flex gap-2">
                @csrf
                <select name="status" class="rounded-xl border border-gray-200 px-3 py-2 min-h-[44px] text-sm">
                    @foreach(['pending','confirmed','checked_in','checked_out','cancelled'] as $s)
                    <option value="{{ $s }}" {{ $booking->status===$s?'selected':'' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
                    @endforeach
                </select>
                <button type="submit" class="px-4 py-2.5 min-h-[44px] rounded-xl text-white text-sm font-semibold" style="background-color:#2E4636;">Update Status</button>
            </form>

            @if(!in_array($booking->payment_status, ['paid','manual_confirmed']))
            <form action="{{ route('admin.bookings.confirm-payment', $booking) }}" method="POST">
                @csrf
                <button type="button"
                        @click="$dispatch('confirm-action', { form: $el.closest('form'), title: 'Confirm payment manually?', message: 'This marks {{ $booking->reference }} as paid. Only do this once payment has actually been received.', danger: false, confirmLabel: 'Confirm Payment' })"
                        class="flex items-center gap-2 px-4 py-2.5 min-h-[44px] rounded-xl text-white text-sm font-semibold" style="background-color:#6E8C5A;">
                    <x-admin-icon name="check" class="w-4 h-4" /> Confirm Payment Manually
                </button>
            </form>
            @endif
        </div>
    </div>
</div>
@endsection
