@extends('layouts.admin')
@section('title', 'Transactions')

@section('content')

{{-- Summary --}}
<div class="grid grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5 mb-8">
    <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm">
        <div class="w-11 h-11 rounded-xl flex items-center justify-center mb-3" style="background:#3F7C8A18;">
            <x-admin-icon name="banknotes" class="w-5 h-5" style="color:#3F7C8A;" />
        </div>
        <p class="text-2xl font-bold" style="color:#3F7C8A;">{{ frw($totals['completed'], 2) }}</p>
        <p class="text-xs text-gray-500 mt-1">Total Completed</p>
    </div>
    <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm">
        <div class="w-11 h-11 rounded-xl flex items-center justify-center mb-3" style="background:#C99A5218;">
            <x-admin-icon name="calendar" class="w-5 h-5" style="color:#C99A52;" />
        </div>
        <p class="text-2xl font-bold" style="color:#C99A52;">{{ $totals['pending'] }}</p>
        <p class="text-xs text-gray-500 mt-1">Pending / Processing</p>
    </div>
    <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm col-span-2 lg:col-span-1">
        <div class="w-11 h-11 rounded-xl flex items-center justify-center mb-3" style="background:#D07A5418;">
            <x-admin-icon name="alert-triangle" class="w-5 h-5" style="color:#D07A54;" />
        </div>
        <p class="text-2xl font-bold" style="color:#D07A54;">{{ $totals['failed'] }}</p>
        <p class="text-xs text-gray-500 mt-1">Failed</p>
    </div>
</div>

{{-- Filters --}}
<form method="GET" class="flex flex-wrap gap-3 mb-6">
    <input type="text" name="search" placeholder="Reference / Guest" value="{{ request('search') }}"
           class="rounded-xl border border-gray-200 px-4 py-2.5 min-h-[44px] text-sm focus:outline-none focus:border-[#3F7C8A] focus:ring-[#3F7C8A]">
    <select name="gateway" class="rounded-xl border border-gray-200 px-4 py-2.5 min-h-[44px] text-sm">
        <option value="">All gateways</option>
        @foreach(['paypack','momo','bank_transfer','card','pay_on_arrival'] as $g)
        <option value="{{ $g }}" {{ request('gateway')===$g?'selected':'' }}>{{ ucfirst(str_replace('_',' ',$g)) }}</option>
        @endforeach
    </select>
    <select name="status" class="rounded-xl border border-gray-200 px-4 py-2.5 min-h-[44px] text-sm">
        <option value="">All statuses</option>
        @foreach(['pending','processing','completed','failed','refunded'] as $s)
        <option value="{{ $s }}" {{ request('status')===$s?'selected':'' }}>{{ ucfirst($s) }}</option>
        @endforeach
    </select>
    <button type="submit" class="px-4 py-2.5 min-h-[44px] rounded-xl text-white text-sm font-semibold" style="background-color:#1E3A4A;">Filter</button>
</form>

<div class="bg-white rounded-2xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto admin-scroll">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Reference</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Booking</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Gateway</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Amount</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Status</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Paid At</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($transactions as $tx)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3 font-mono text-xs">{{ $tx->gateway_reference ?? '—' }}</td>
                    <td class="px-5 py-3">
                        @if($tx->booking)
                        <a href="{{ route('admin.bookings.show', $tx->booking) }}" class="font-medium hover:underline" style="color:#D07A54;">{{ $tx->booking->reference }}</a>
                        <div class="text-xs text-gray-400">{{ $tx->booking->guest_name }}</div>
                        @else
                        <span class="text-gray-400">—</span>
                        @endif
                    </td>
                    <td class="px-5 py-3 capitalize text-gray-600">{{ str_replace('_',' ',$tx->gateway) }}</td>
                    <td class="px-5 py-3 font-semibold">{{ money($tx->amount, $tx->currency) }}</td>
                    <td class="px-5 py-3">
                        <span class="px-2 py-0.5 rounded-full text-xs font-semibold capitalize {{ match($tx->status) {
                            'completed' => 'bg-green-100 text-green-700',
                            'processing' => 'bg-blue-100 text-blue-700',
                            'failed' => 'bg-red-100 text-red-700',
                            'refunded' => 'bg-purple-100 text-purple-700',
                            default => 'bg-yellow-100 text-yellow-700',
                        } }}">{{ $tx->status }}</span>
                    </td>
                    <td class="px-5 py-3 text-gray-500">{{ $tx->paid_at?->format('d M Y H:i') ?? '—' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-5 py-16 text-center text-gray-400">
                        <div class="w-14 h-14 mx-auto mb-3 rounded-full bg-gray-100 flex items-center justify-center">
                            <x-admin-icon name="banknotes" class="w-6 h-6 text-gray-400" />
                        </div>
                        No transactions found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-5 py-4 border-t border-gray-100">{{ $transactions->links() }}</div>
</div>
@endsection
