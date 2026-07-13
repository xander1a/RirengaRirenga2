@extends('layouts.admin')
@section('title', 'Rooms')

@section('content')
<div class="space-y-8">
    {{-- Room Types --}}
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="font-semibold text-gray-800">Room Types & Prices</h2>
        </div>
        <div class="overflow-x-auto admin-scroll">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Type</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Price/Night</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Max Guests</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Rooms</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Active</th>
                        <th class="px-5 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($roomTypes as $rt)
                    <tr>
                        <td class="px-5 py-3 font-medium">{{ $rt->name }}</td>
                        <td class="px-5 py-3" style="color:#C9A24B;font-weight:600;">{{ frw($rt->price_per_night, 2) }}</td>
                        <td class="px-5 py-3 text-gray-600">{{ $rt->max_guests }}</td>
                        <td class="px-5 py-3 text-gray-600">{{ $rt->rooms->count() }}</td>
                        <td class="px-5 py-3">
                            <span class="px-2 py-0.5 rounded-full text-xs {{ $rt->is_active?'bg-green-100 text-green-700':'bg-red-100 text-red-700' }}">
                                {{ $rt->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-5 py-3">
                            <a href="{{ route('admin.rooms.type.edit', $rt) }}"
                               class="inline-flex items-center gap-1.5 px-3 py-2 min-h-[40px] rounded-lg text-xs font-medium hover:bg-gray-100 transition" style="color:#BF6B47;">
                                <x-admin-icon name="pencil" class="w-3.5 h-3.5" /> Edit
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Physical Rooms --}}
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden" x-data="{ open: false }">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h2 class="font-semibold text-gray-800">Physical Rooms — Status</h2>
            <button @click="open = !open" class="flex items-center gap-2 text-sm font-semibold min-h-[44px]" style="color:#BF6B47;">
                <x-admin-icon name="plus" class="w-4 h-4" /> Add Room
            </button>
        </div>

        <div x-show="open" x-cloak x-transition class="px-6 py-5 border-b border-gray-100" style="background:#F9F6EF;">
            <form action="{{ route('admin.rooms.store') }}" method="POST" enctype="multipart/form-data" class="grid sm:grid-cols-3 gap-4">
                @csrf
                <div>
                    <label class="block text-xs mb-1">Room Type</label>
                    <select name="room_type_id" required class="w-full rounded-xl border border-gray-200 px-3 py-2.5 min-h-[44px] text-sm">
                        @foreach($roomTypes as $rt)
                        <option value="{{ $rt->id }}">{{ $rt->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs mb-1">Room Name</label>
                    <input type="text" name="name" required placeholder="e.g. Forest Suite" class="w-full rounded-xl border border-gray-200 px-3 py-2.5 min-h-[44px] text-sm">
                </div>
                <div>
                    <label class="block text-xs mb-1">Room Number</label>
                    <input type="text" name="room_number" required placeholder="e.g. 103" class="w-full rounded-xl border border-gray-200 px-3 py-2.5 min-h-[44px] text-sm">
                </div>
                <div>
                    <label class="block text-xs mb-1">Status</label>
                    <select name="status" class="w-full rounded-xl border border-gray-200 px-3 py-2.5 min-h-[44px] text-sm">
                        @foreach(['available','occupied','maintenance','cleaning'] as $s)
                        <option value="{{ $s }}">{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-xs mb-1">Photo</label>
                    <x-image-input name="image" />
                </div>
                <div class="sm:col-span-3 flex justify-end">
                    <button type="submit" class="px-6 py-2.5 min-h-[44px] rounded-xl text-white text-sm font-semibold" style="background-color:#BF6B47;">Add Room</button>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto admin-scroll">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Room</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Number</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Type</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Status</th>
                        <th class="px-5 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($rooms as $room)
                    <tr>
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg overflow-hidden shrink-0 bg-gray-100 flex items-center justify-center">
                                    @if($room->image_url)
                                    <img src="{{ $room->image_url }}" alt="{{ $room->name }}" class="w-full h-full object-cover">
                                    @else
                                    <x-admin-icon name="bed" class="w-4 h-4 text-gray-300" />
                                    @endif
                                </div>
                                <span class="font-medium">{{ $room->name }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-3 text-gray-600">{{ $room->room_number }}</td>
                        <td class="px-5 py-3 text-gray-600">{{ $room->roomType->name }}</td>
                        <td class="px-5 py-3">
                            <span class="px-2 py-0.5 rounded-full text-xs capitalize {{ match($room->status) {
                                'available'=>'bg-green-100 text-green-700',
                                'occupied'=>'bg-blue-100 text-blue-700',
                                'maintenance'=>'bg-red-100 text-red-700',
                                default=>'bg-yellow-100 text-yellow-700'
                            } }}">{{ $room->status }}</span>
                        </td>
                        <td class="px-5 py-3">
                            <div class="flex flex-wrap gap-2 items-center justify-end">
                                <form action="{{ route('admin.rooms.status', $room) }}" method="POST" class="flex gap-2 items-center">
                                    @csrf
                                    <select name="status" class="rounded-xl border border-gray-200 px-2 py-2 min-h-[40px] text-xs">
                                        @foreach(['available','occupied','maintenance','cleaning'] as $s)
                                        <option value="{{ $s }}" {{ $room->status===$s?'selected':'' }}>{{ ucfirst($s) }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="text-xs px-3 py-2 min-h-[40px] rounded-lg text-white font-semibold" style="background-color:#2E4636;">Update</button>
                                </form>
                                <form action="{{ route('admin.rooms.destroy', $room) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="button"
                                            @click="$dispatch('confirm-action', { form: $el.closest('form'), title: 'Delete this room?', message: '\'{{ addslashes($room->name) }}\' (#{{ $room->room_number }}) will be removed.' })"
                                            class="w-9 h-9 min-h-[40px] min-w-[40px] flex items-center justify-center rounded-lg text-red-500 hover:bg-red-50 hover:text-red-700 transition"
                                            aria-label="Delete {{ $room->name }}">
                                        <x-admin-icon name="trash" class="w-4 h-4" />
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
