@extends('layouts.admin')
@section('title', 'Reports')

@section('content')
<div class="flex flex-wrap gap-4 mb-6 items-end">
    <form method="GET" class="flex flex-wrap gap-3 items-end">
        <div>
            <label class="block text-xs mb-1">From</label>
            <input type="date" name="from" value="{{ $from }}" class="rounded-xl border border-gray-200 px-3 py-2.5 min-h-[44px] text-sm">
        </div>
        <div>
            <label class="block text-xs mb-1">To</label>
            <input type="date" name="to" value="{{ $to }}" class="rounded-xl border border-gray-200 px-3 py-2.5 min-h-[44px] text-sm">
        </div>
        <button type="submit" class="px-4 py-2.5 min-h-[44px] rounded-xl text-white text-sm font-semibold" style="background-color:#1E3A4A;">Apply</button>
        <a href="{{ route('admin.reports.export', ['from'=>$from,'to'=>$to]) }}" class="flex items-center gap-2 px-4 py-2.5 min-h-[44px] rounded-xl border border-gray-200 bg-white text-sm hover:bg-gray-50">
            <x-admin-icon name="archive" class="w-4 h-4" /> Export CSV
        </a>
    </form>
</div>

{{-- Summary Cards --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5 mb-8">
    @foreach([
        ['icon'=>'calendar', 'value'=>$totalBookings, 'label'=>'Total Bookings', 'color'=>'#1E3A4A'],
        ['icon'=>'banknotes', 'value'=>frw($totalRevenue), 'label'=>'Revenue (paid only)', 'color'=>'#C99A52'],
        ['icon'=>'building', 'value'=>$occupancyRate.'%', 'label'=>'Occupancy Rate', 'color'=>'#3F7C8A'],
        ['icon'=>'alert-triangle', 'value'=>$bookings->where('payment_status','pending')->count(), 'label'=>'Pending Payments', 'color'=>'#D07A54'],
    ] as $m)
    <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm">
        <div class="w-11 h-11 rounded-xl flex items-center justify-center mb-3" style="background:{{ $m['color'] }}18;">
            <x-admin-icon :name="$m['icon']" class="w-5 h-5" style="color:{{ $m['color'] }};" />
        </div>
        <p class="text-2xl font-bold" style="color:{{ $m['color'] }};">{{ $m['value'] }}</p>
        <p class="text-xs text-gray-500 mt-1">{{ $m['label'] }}</p>
    </div>
    @endforeach
</div>

{{-- By Payment Method --}}
@if($byPaymentMethod->count())
<div class="bg-white rounded-2xl shadow-sm p-6 mb-8">
    <h3 class="font-semibold mb-4" style="color:#1E3A4A;">Revenue by Payment Method</h3>
    <div class="space-y-3">
        @foreach($byPaymentMethod as $method => $data)
        <div class="flex justify-between items-center py-2 border-b border-gray-100 text-sm">
            <span class="capitalize font-medium">{{ str_replace('_',' ',$method) }}</span>
            <div class="text-right">
                <span class="font-bold" style="color:#C99A52;">{{ frw($data['total'],2) }}</span>
                <span class="text-gray-400 ml-2">({{ $data['count'] }} bookings)</span>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

{{-- Booking List --}}
<div class="bg-white rounded-2xl shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100">
        <h3 class="font-semibold" style="color:#1E3A4A;">Bookings in Period</h3>
    </div>
    <div class="overflow-x-auto admin-scroll">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Ref</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Guest</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Room</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Check-in</th>
                    <th class="px-5 py-3 text-right text-xs font-semibold uppercase text-gray-500">Total</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Payment</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($bookings as $b)
                <tr>
                    <td class="px-5 py-3 font-mono text-xs">{{ $b->reference }}</td>
                    <td class="px-5 py-3">{{ $b->guest_name }}</td>
                    <td class="px-5 py-3 text-gray-500">{{ $b->room->roomType->name ?? '—' }}</td>
                    <td class="px-5 py-3 text-gray-500">{{ $b->check_in->format('d M Y') }}</td>
                    <td class="px-5 py-3 text-right font-semibold">{{ money($b->total_amount, $b->currency) }}</td>
                    <td class="px-5 py-3">
                        <span class="px-2 py-0.5 rounded-full text-xs capitalize {{ in_array($b->payment_status,['paid','manual_confirmed'])?'bg-green-100 text-green-700':($b->payment_status==='failed'?'bg-red-100 text-red-700':'bg-yellow-100 text-yellow-700') }}">
                            {{ str_replace('_',' ',$b->payment_status) }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
