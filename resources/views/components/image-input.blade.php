@props(['name' => 'image', 'required' => false, 'current' => null])

{{-- File input with a live thumbnail preview of the image about to be uploaded --}}
<div x-data="{ preview: null, pick(e) { const f = e.target.files[0]; this.preview = f ? URL.createObjectURL(f) : null; } }">
    <input type="file" name="{{ $name }}" accept="image/*" @change="pick($event)" {{ $required ? 'required' : '' }}
           {{ $attributes->merge(['class' => 'w-full text-sm text-gray-500 rounded-xl border border-gray-200 p-1.5 file:mr-3 file:px-4 file:py-2 file:rounded-lg file:border file:border-solid file:border-[#1E3A4A] file:bg-[#1E3A4A] file:text-white file:text-xs file:font-semibold file:cursor-pointer hover:file:opacity-90']) }}>

    <div class="mt-2 flex items-center gap-3" x-show="preview || {{ $current ? 'true' : 'false' }}">
        @if($current)
        <div x-show="!preview" class="flex items-center gap-2">
            <img src="{{ $current }}" alt="Current image" class="w-16 h-16 rounded-lg object-cover border border-gray-200">
            <span class="text-xs text-gray-400">Current</span>
        </div>
        @endif
        <template x-if="preview">
            <div class="flex items-center gap-2">
                <img :src="preview" alt="Preview" class="w-16 h-16 rounded-lg object-cover border-2" style="border-color:#D07A54;">
                <span class="text-xs font-semibold" style="color:#D07A54;">New — will replace on save</span>
            </div>
        </template>
    </div>
</div>
