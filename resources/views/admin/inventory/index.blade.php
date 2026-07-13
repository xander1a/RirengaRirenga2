@extends('layouts.admin')
@section('title', 'Inventory')

@section('content')
{{-- Add Item --}}
<div class="bg-white rounded-2xl p-6 shadow-sm mb-6" x-data="{ open: false }">
    <button @click="open = !open" class="flex items-center gap-2 text-sm font-semibold min-h-[44px]" style="color:#BF6B47;">
        <x-admin-icon name="plus" class="w-4 h-4" /> Add Item
    </button>
    <div x-show="open" x-transition class="mt-4">
        <form action="{{ route('admin.inventory.store') }}" method="POST" class="grid sm:grid-cols-4 gap-4">
            @csrf
            <div><label class="block text-xs mb-1">Name</label><input type="text" name="name" required class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm"></div>
            <div><label class="block text-xs mb-1">Category</label><input type="text" name="category" class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm" placeholder="bar, food, linen..."></div>
            <div><label class="block text-xs mb-1">Unit</label><input type="text" name="unit" required value="pcs" class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm"></div>
            <div><label class="block text-xs mb-1">Qty</label><input type="number" name="quantity" min="0" step="0.01" required class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm"></div>
            <div><label class="block text-xs mb-1">Low Stock Threshold</label><input type="number" name="low_stock_threshold" min="0" step="0.01" required value="5" class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm"></div>
            <div><label class="block text-xs mb-1">Supplier</label><input type="text" name="supplier" class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm"></div>
            <div class="sm:col-span-2 flex items-end">
                <button type="submit" class="px-5 py-2 rounded-xl text-white text-sm font-semibold" style="background-color:#BF6B47;">Add</button>
            </div>
        </form>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto admin-scroll">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Item</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Category</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Qty</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Threshold</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Status</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($items as $item)
                <tr class="{{ $item->isLowStock() ? 'bg-red-50' : '' }}">
                    <td class="px-5 py-3 font-medium">{{ $item->name }}</td>
                    <td class="px-5 py-3 text-gray-500 capitalize">{{ $item->category ?? '—' }}</td>
                    <td class="px-5 py-3 font-mono">{{ $item->quantity }} {{ $item->unit }}</td>
                    <td class="px-5 py-3 text-gray-400 text-xs">{{ $item->low_stock_threshold }} {{ $item->unit }}</td>
                    <td class="px-5 py-3">
                        @if($item->isLowStock())
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs bg-red-100 text-red-700 font-semibold">
                            <x-admin-icon name="alert-triangle" class="w-3.5 h-3.5" /> Low Stock
                        </span>
                        @else
                        <span class="px-2 py-0.5 rounded-full text-xs bg-green-100 text-green-700">OK</span>
                        @endif
                    </td>
                    <td class="px-5 py-3">
                        <form action="{{ route('admin.inventory.update', $item) }}" method="POST" class="flex gap-2 items-center">
                            @csrf @method('PUT')
                            <input type="number" name="quantity" value="{{ $item->quantity }}" step="0.01" min="0"
                                   class="w-24 rounded-lg border border-gray-200 px-2 py-2 min-h-[40px] text-xs">
                            <input type="hidden" name="low_stock_threshold" value="{{ $item->low_stock_threshold }}">
                            <button type="submit" class="text-xs px-3 py-2 min-h-[40px] rounded-lg text-white font-semibold" style="background-color:#2E4636;">Update</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
