@extends('layouts.public')

@section('content')
<div class="py-12 px-4">
    <div class="max-w-4xl mx-auto">
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="font-display text-3xl font-bold" style="color:#1E3A4A;">My Account</h1>
                <p class="text-gray-500 mt-1">Welcome back, {{ $user->name }}</p>
            </div>
            <a href="{{ route('portal.profile') }}" class="text-sm px-4 py-2 rounded-xl border border-gray-200 hover:bg-gray-50">Edit Profile</a>
        </div>

        <h2 class="font-semibold text-lg mb-4" style="color:#1E3A4A;">My Bookings</h2>

        @if($bookings->count())
        <div class="space-y-4">
            @foreach($bookings as $b)
            <div class="bg-white rounded-2xl p-6 shadow-sm">
                <div class="flex flex-wrap justify-between gap-4">
                    <div>
                        <div class="flex gap-2 items-center mb-2">
                            <span class="font-mono text-xs px-2 py-0.5 rounded" style="background:#EFE9DC;color:#3F7C8A;">{{ $b->reference }}</span>
                            <span class="text-xs px-2 py-0.5 rounded-full capitalize {{ $b->status==='confirmed'?'bg-green-100 text-green-700':($b->status==='cancelled'?'bg-red-100 text-red-700':'bg-yellow-100 text-yellow-700') }}">{{ $b->status === 'cancelled' ? 'declined' : $b->status }}</span>
                        </div>
                        <p class="font-semibold" style="color:#1E3A4A;">{{ $b->room->roomType->name ?? 'Room' }}</p>
                        <p class="text-sm text-gray-500">{{ $b->check_in->format('d M Y') }} → {{ $b->check_out->format('d M Y') }} ({{ $b->nights }} nights)</p>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-lg" style="color:#C99A52;">{{ money($b->total_amount, $b->currency) }}</p>
                        <span class="text-xs px-2 py-0.5 rounded-full capitalize {{ in_array($b->payment_status,['paid','manual_confirmed'])?'bg-green-100 text-green-700':'bg-yellow-100 text-yellow-700' }}">
                            {{ str_replace('_',' ',$b->payment_status) }}
                        </span>
                        <div class="mt-2">
                            <a href="{{ route('portal.booking', $b->reference) }}" class="text-xs font-medium" style="color:#D07A54;">View Details →</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-12 bg-white rounded-2xl shadow-sm">
            <div class="text-5xl mb-4">🏨</div>
            <p class="text-gray-500 mb-4">You haven't made any bookings yet.</p>
            <a href="{{ route('booking') }}" class="inline-block px-6 py-3 rounded-xl text-white font-semibold" style="background-color:#D07A54;">Book Your Stay</a>
        </div>
        @endif
    </div>
</div>
@endsection
