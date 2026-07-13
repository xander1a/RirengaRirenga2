@extends('layouts.admin')
@section('title', 'Gallery')

@section('content')
{{-- Upload Form --}}
<div class="bg-white rounded-2xl p-6 shadow-sm mb-8">
    <h2 class="font-semibold mb-4" style="color:#2E4636;">Upload Photo</h2>
    <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-wrap gap-4 items-end">
        @csrf
        <div>
            <label class="block text-xs mb-1">Photo *</label>
            <x-image-input name="photo" :required="true" />
        </div>
        <div>
            <label class="block text-xs mb-1">Category *</label>
            <select name="category" required class="rounded-xl border border-gray-200 px-3 py-2 text-sm">
                <option value="rooms">Rooms</option>
                <option value="restaurant">Restaurant</option>
                <option value="bar">Bar</option>
                <option value="surroundings">Surroundings</option>
            </select>
        </div>
        <div>
            <label class="block text-xs mb-1">Title (optional)</label>
            <input type="text" name="title" class="rounded-xl border border-gray-200 px-3 py-2 text-sm w-48">
        </div>
        <button type="submit" class="px-5 py-2 rounded-xl text-white text-sm font-semibold" style="background-color:#BF6B47;">Upload</button>
    </form>
</div>

{{-- Photo Grid --}}
<div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
    @foreach($photos as $photo)
    <div class="relative group rounded-xl overflow-hidden aspect-square">
        <img src="{{ $photo->url }}" alt="{{ $photo->title ?? $photo->category }}" class="w-full h-full object-cover">
        <form action="{{ route('admin.gallery.destroy', $photo) }}" method="POST" class="absolute top-2 right-2">
            @csrf @method('DELETE')
            <button type="button"
                    @click="$dispatch('confirm-action', { form: $el.closest('form'), title: 'Delete this photo?', message: 'It will be permanently removed from the gallery.' })"
                    class="w-9 h-9 rounded-full bg-black/55 hover:bg-red-600 text-white flex items-center justify-center transition opacity-80 group-hover:opacity-100"
                    aria-label="Delete photo">
                <x-admin-icon name="trash" class="w-4 h-4" />
            </button>
        </form>
        <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/60 to-transparent px-2 py-1.5">
            <p class="text-white text-xs capitalize">{{ $photo->category }}</p>
        </div>
    </div>
    @endforeach
    @if($photos->isEmpty())
    <div class="col-span-full text-center py-16 text-gray-400">
        <div class="w-14 h-14 mx-auto mb-3 rounded-full bg-gray-100 flex items-center justify-center">
            <x-admin-icon name="photo" class="w-6 h-6 text-gray-400" />
        </div>
        <p>No photos yet. Upload the first one!</p>
    </div>
    @endif
</div>
@endsection
