@extends('layouts.admin')
@section('title', 'Bookings')

@section('content')
<div class="flex flex-wrap gap-4 mb-6 justify-between items-center">
    <form method="GET" class="flex flex-wrap gap-3">
        <input type="text" name="search" placeholder="Reference / Guest / Email" value="{{ request('search') }}"
               class="rounded-xl border border-gray-200 px-4 py-2.5 min-h-[44px] text-sm focus:outline-none focus:border-[#6E8C5A] focus:ring-[#6E8C5A]">
        <select name="status" class="rounded-xl border border-gray-200 px-4 py-2.5 min-h-[44px] text-sm">
            <option value="">All statuses</option>
            @foreach(['pending','confirmed','cancelled','checked_in','checked_out'] as $s)
            <option value="{{ $s }}" {{ request('status')===$s?'selected':'' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
            @endforeach
        </select>
        <select name="payment_status" class="rounded-xl border border-gray-200 px-4 py-2.5 min-h-[44px] text-sm">
            <option value="">All payments</option>
            @foreach(['pending','paid','failed','manual_confirmed'] as $p)
            <option value="{{ $p }}" {{ request('payment_status')===$p?'selected':'' }}>{{ ucfirst(str_replace('_',' ',$p)) }}</option>
            @endforeach
        </select>
        <button type="submit" class="px-4 py-2.5 min-h-[44px] rounded-xl text-white text-sm font-semibold" style="background-color:#2E4636;">Filter</button>
    </form>
    <a href="{{ route('admin.bookings.export', request()->all()) }}" class="flex items-center gap-2 px-4 py-2.5 min-h-[44px] rounded-xl text-sm font-medium border border-gray-200 bg-white hover:bg-gray-50">
        <x-admin-icon name="archive" class="w-4 h-4" /> Export CSV
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto admin-scroll">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Ref</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Guest</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Room</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Check-in</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Check-out</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Total</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Status</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Payment</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($bookings as $b)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3 font-mono text-xs">{{ $b->reference }}</td>
                    <td class="px-5 py-3">
                        <div class="font-medium">{{ $b->guest_name }}</div>
                        <div class="text-xs text-gray-400">{{ $b->guest_email }}</div>
                    </td>
                    <td class="px-5 py-3 text-gray-600">{{ $b->room->roomType->name ?? '—' }}</td>
                    <td class="px-5 py-3 text-gray-600">{{ $b->check_in->format('d M Y') }}</td>
                    <td class="px-5 py-3 text-gray-600">{{ $b->check_out->format('d M Y') }}</td>
                    <td class="px-5 py-3 font-semibold">{{ money($b->total_amount, $b->currency) }}</td>
                    <td class="px-5 py-3">
                        <span class="px-2 py-0.5 rounded-full text-xs font-semibold capitalize {{ $b->status==='confirmed'?'bg-green-100 text-green-700':($b->status==='pending'?'bg-yellow-100 text-yellow-700':($b->status==='cancelled'?'bg-red-100 text-red-700':'bg-blue-100 text-blue-700')) }}">
                            {{ $b->status }}
                        </span>
                    </td>
                    <td class="px-5 py-3">
                        <span class="px-2 py-0.5 rounded-full text-xs font-semibold capitalize {{ $b->payment_status==='paid'||$b->payment_status==='manual_confirmed'?'bg-green-100 text-green-700':($b->payment_status==='failed'?'bg-red-100 text-red-700':'bg-yellow-100 text-yellow-700') }}">
                            {{ str_replace('_',' ',$b->payment_status) }}
                        </span>
                    </td>
                    <td class="px-5 py-3">
                        <a href="{{ route('admin.bookings.show', $b) }}" class="inline-flex items-center gap-1 text-xs font-medium min-h-[44px]" style="color:#BF6B47;">
                            View <x-admin-icon name="chevron-right" class="w-3.5 h-3.5" />
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="px-5 py-4 border-t border-gray-100">{{ $bookings->links() }}</div>
</div>
@endsection
