@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
{{-- Key Metrics --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-6">
    @foreach([
        ['label'=>'Check-ins Today', 'value'=>$checkInsToday, 'icon'=>'plane-arrival', 'color'=>'#6E8C5A'],
        ['label'=>'Check-outs Today', 'value'=>$checkOutsToday, 'icon'=>'plane-departure', 'color'=>'#C9A24B'],
        ['label'=>'Occupancy Rate', 'value'=>$occupancyRate.'%', 'icon'=>'building', 'color'=>'#2E4636'],
        ['label'=>'Monthly Revenue', 'value'=>frw($monthlyRevenue), 'icon'=>'banknotes', 'color'=>'#BF6B47'],
    ] as $m)
    <div class="bg-white rounded-xl p-4 shadow-sm">
        <div class="w-9 h-9 rounded-lg flex items-center justify-center mb-2.5" style="background:{{ $m['color'] }}18;">
            <x-admin-icon :name="$m['icon']" class="w-4 h-4" style="color:{{ $m['color'] }};" />
        </div>
        <p class="text-lg font-bold leading-tight" style="color:{{ $m['color'] }};">{{ $m['value'] }}</p>
        <p class="text-xs text-gray-500 mt-0.5">{{ $m['label'] }}</p>
    </div>
    @endforeach
</div>

{{-- Alerts --}}
<div class="grid lg:grid-cols-2 gap-4 mb-6">
    @if($pendingPayments > 0)
    <div class="rounded-xl p-4 flex gap-3 items-center" style="background:#C9A24B12;border:1px solid #C9A24B40;">
        <div class="w-9 h-9 rounded-full flex items-center justify-center shrink-0" style="background:#C9A24B22;">
            <x-admin-icon name="alert-triangle" class="w-4 h-4" style="color:#C9A24B;" />
        </div>
        <div>
            <p class="text-sm font-semibold" style="color:#a9852f;">{{ $pendingPayments }} pending payment(s)</p>
            <a href="{{ route('admin.bookings.index', ['payment_status'=>'pending']) }}" class="text-xs font-medium underline" style="color:#C9A24B;">Review now</a>
        </div>
    </div>
    @endif
    @if($lowStockItems->count())
    <div class="rounded-xl p-4" style="background:#BF6B4712;border:1px solid #BF6B4740;">
        <div class="flex gap-3 items-center mb-2.5">
            <div class="w-9 h-9 rounded-full flex items-center justify-center shrink-0" style="background:#BF6B4722;">
                <x-admin-icon name="archive" class="w-4 h-4" style="color:#BF6B47;" />
            </div>
            <p class="text-sm font-semibold" style="color:#BF6B47;">{{ $lowStockItems->count() }} low-stock item(s)</p>
        </div>
        <ul class="text-xs text-gray-600 space-y-1">
            @foreach($lowStockItems->take(3) as $item)
            <li>• {{ $item->name }}: <strong>{{ $item->quantity }} {{ $item->unit }}</strong> (threshold: {{ $item->low_stock_threshold }})</li>
            @endforeach
        </ul>
        <a href="{{ route('admin.inventory.index') }}" class="text-xs font-medium underline mt-2 inline-block" style="color:#BF6B47;">View inventory</a>
    </div>
    @endif
</div>

{{-- Recent Bookings --}}
<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="px-5 py-3 border-b border-gray-100 flex justify-between items-center">
        <h2 class="text-sm font-semibold text-gray-800">Recent Bookings</h2>
        <a href="{{ route('admin.bookings.index') }}" class="text-xs font-medium" style="color:#BF6B47;">View all →</a>
    </div>
    <div class="overflow-x-auto admin-scroll">
        <table class="w-full text-xs">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-5 py-2.5 text-left text-[11px] font-semibold uppercase text-gray-500">Reference</th>
                    <th class="px-5 py-2.5 text-left text-[11px] font-semibold uppercase text-gray-500">Guest</th>
                    <th class="px-5 py-2.5 text-left text-[11px] font-semibold uppercase text-gray-500">Room</th>
                    <th class="px-5 py-2.5 text-left text-[11px] font-semibold uppercase text-gray-500">Check-in</th>
                    <th class="px-5 py-2.5 text-left text-[11px] font-semibold uppercase text-gray-500">Total</th>
                    <th class="px-5 py-2.5 text-left text-[11px] font-semibold uppercase text-gray-500">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($recentBookings as $b)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-2.5">
                        <a href="{{ route('admin.bookings.show', $b) }}" class="font-mono text-[11px] hover:underline" style="color:#BF6B47;">{{ $b->reference }}</a>
                    </td>
                    <td class="px-5 py-2.5">{{ $b->guest_name }}</td>
                    <td class="px-5 py-2.5 text-gray-500">{{ $b->room->roomType->name ?? '—' }}</td>
                    <td class="px-5 py-2.5 text-gray-500">{{ $b->check_in->format('d M Y') }}</td>
                    <td class="px-5 py-2.5 font-semibold">{{ money($b->total_amount, $b->currency) }}</td>
                    <td class="px-5 py-2.5">
                        <span class="px-2 py-0.5 rounded-full text-[11px] font-semibold capitalize
                            {{ $b->status === 'confirmed' ? 'bg-green-100 text-green-700' :
                               ($b->status === 'pending' ? 'bg-yellow-100 text-yellow-700' :
                               ($b->status === 'cancelled' ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700')) }}">
                            {{ $b->status }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
