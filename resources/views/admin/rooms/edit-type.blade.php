@extends('layouts.admin')
@section('title', 'Edit Room Type: '.$roomType->name)

@section('content')
<div class="max-w-2xl mx-auto">
    <a href="{{ route('admin.rooms.index') }}" class="text-sm text-gray-500 hover:text-gray-700 mb-4 inline-block">← Back to Rooms</a>
    <div class="bg-white rounded-2xl p-8 shadow-sm">
        <h2 class="font-display text-2xl font-bold mb-6" style="color:#2E4636;">{{ $roomType->name }}</h2>
        <form action="{{ route('admin.rooms.type.update', $roomType) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            <div class="grid sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium mb-1">Name</label>
                    <input type="text" name="name" required value="{{ $roomType->name }}" class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm focus:outline-none focus:ring-2">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Price per Night</label>
                    <div class="flex gap-2">
                        <input type="number" name="price_per_night" step="0.01" required value="{{ $roomType->price_per_night }}" class="flex-1 min-w-0 rounded-xl border border-gray-200 px-4 py-3 text-sm focus:outline-none focus:ring-2">
                        <select name="currency" class="rounded-xl border border-gray-200 px-3 py-3 text-sm shrink-0">
                            <option value="RWF" {{ ($roomType->currency ?? 'RWF') === 'RWF' ? 'selected' : '' }}>RWF</option>
                            <option value="USD" {{ ($roomType->currency ?? 'RWF') === 'USD' ? 'selected' : '' }}>USD</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Max Guests</label>
                    <input type="number" name="max_guests" min="1" required value="{{ $roomType->max_guests }}" class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm focus:outline-none focus:ring-2">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Cover Image</label>
                    <x-image-input name="image" :current="$roomType->image ? $roomType->image_url : null" />
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium mb-1">Description</label>
                    <textarea name="description" rows="3" class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm focus:outline-none focus:ring-2">{{ $roomType->description }}</textarea>
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium mb-1">Amenities (one per line)</label>
                    <textarea name="amenities" rows="5" class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm font-mono focus:outline-none focus:ring-2">{{ implode("\n", $roomType->amenities ?? []) }}</textarea>
                </div>
                <div>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="is_active" value="1" {{ $roomType->is_active ? 'checked' : '' }}>
                        <span class="text-sm font-medium">Active (visible on website)</span>
                    </label>
                </div>
            </div>
            <div class="flex gap-4">
                <button type="submit" class="px-6 py-3 rounded-xl text-white font-semibold transition hover:opacity-90" style="background-color:#BF6B47;">Save Changes</button>
                <a href="{{ route('admin.rooms.index') }}" class="px-6 py-3 rounded-xl border border-gray-200 text-gray-700 text-sm hover:bg-gray-50">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
