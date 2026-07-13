@extends('layouts.admin')
@section('title', 'Website Images')

@section('content')
<p class="text-sm text-gray-500 mb-6 max-w-2xl">
    Upload photos for every image slot on the public website. Slots without a photo fall back to the default
    decorative look. Use bright, landscape photos — the recommended size is shown on each card.
</p>

<div class="grid sm:grid-cols-2 xl:grid-cols-3 gap-4 sm:gap-5">
    @foreach($slots as $key => [$label, $where, $size])
    @php $current = $settings['image.'.$key] ?? null; @endphp
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden flex flex-col"
         x-data="{ preview: null, pick(e) { const f = e.target.files[0]; this.preview = f ? URL.createObjectURL(f) : null; } }">
        <div class="h-40 bg-gray-100 relative">
            {{-- Live preview of the file about to be uploaded --}}
            <template x-if="preview">
                <div class="absolute inset-0 z-10">
                    <img :src="preview" alt="Preview" class="w-full h-full object-cover">
                    <span class="absolute top-2 left-2 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide text-white" style="background:#BF6B47;">Preview — not saved yet</span>
                </div>
            </template>

            @if($current)
            <img src="{{ Illuminate\Support\Facades\Storage::disk('public')->url($current) }}" alt="{{ $label }}" class="w-full h-full object-cover">
            <form action="{{ route('admin.site-images.destroy', $key) }}" method="POST" class="absolute top-2 right-2" x-show="!preview">
                @csrf @method('DELETE')
                <button type="button"
                        @click="$dispatch('confirm-action', { form: $el.closest('form'), title: 'Remove this image?', message: 'The default look will be shown instead.' })"
                        class="w-9 h-9 rounded-full bg-white/90 shadow flex items-center justify-center text-red-500 hover:bg-white transition" aria-label="Remove image">
                    <x-admin-icon name="trash" class="w-4 h-4" />
                </button>
            </form>
            @else
            <div class="w-full h-full flex flex-col items-center justify-center text-gray-300 gap-2">
                <x-admin-icon name="photo" class="w-8 h-8" />
                <span class="text-xs">No image yet</span>
            </div>
            @endif
        </div>
        <div class="p-4 flex-1 flex flex-col">
            <h3 class="text-sm font-semibold text-gray-800">{{ $label }}</h3>
            <p class="text-xs text-gray-400 mt-0.5 mb-3 flex-1">{{ $where }} · {{ $size }}</p>
            <form action="{{ route('admin.site-images.update', $key) }}" method="POST" enctype="multipart/form-data" class="flex items-center gap-2">
                @csrf
                <input type="file" name="image" accept="image/*" required @change="pick($event)"
                       class="flex-1 min-w-0 text-xs text-gray-500 file:mr-2 file:px-3 file:py-2 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:text-white file:cursor-pointer">
                <button type="submit" x-show="preview" x-cloak
                        class="px-3 py-2 rounded-lg text-white text-xs font-semibold shrink-0" style="background-color:#BF6B47;">
                    Upload
                </button>
            </form>
        </div>
    </div>
    @endforeach
</div>

@push('scripts')
<style>
    input[type="file"]::file-selector-button { background-color: #2E4636; }
</style>
@endpush
@endsection
