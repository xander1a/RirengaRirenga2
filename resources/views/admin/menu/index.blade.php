@extends('layouts.admin')
@section('title', 'Menu — '.ucfirst($type))

@section('content')
<div class="flex gap-3 mb-6">
    <a href="{{ route('admin.menu.index', 'restaurant') }}" class="flex items-center gap-2 px-4 py-2.5 min-h-[44px] rounded-xl text-sm font-medium transition {{ $type==='restaurant'?'text-white':'bg-white border border-gray-200 text-gray-700 hover:bg-gray-50' }}" style="{{ $type==='restaurant'?'background-color:#2E4636;':'' }}">
        <x-admin-icon name="utensils" class="w-4 h-4" /> Restaurant
    </a>
    <a href="{{ route('admin.menu.index', 'bar') }}" class="flex items-center gap-2 px-4 py-2.5 min-h-[44px] rounded-xl text-sm font-medium transition {{ $type==='bar'?'text-white':'bg-white border border-gray-200 text-gray-700 hover:bg-gray-50' }}" style="{{ $type==='bar'?'background-color:#2E4636;':'' }}">
        <x-admin-icon name="archive" class="w-4 h-4" /> Bar
    </a>
</div>

{{-- Categories --}}
<div class="bg-white rounded-2xl p-6 shadow-sm mb-6" x-data="{ open: false }">
    <div class="flex items-center justify-between">
        <h2 class="font-semibold text-sm" style="color:#2E4636;">Categories</h2>
        <button @click="open = !open" class="flex items-center gap-2 text-sm font-semibold min-h-[44px]" style="color:#BF6B47;">
            <x-admin-icon name="plus" class="w-4 h-4" /> Add Category
        </button>
    </div>

    <div x-show="open" x-transition class="mt-4 pb-4 border-b border-gray-100">
        <form action="{{ route('admin.menu.category.store') }}" method="POST" class="grid sm:grid-cols-4 gap-4">
            @csrf
            <input type="hidden" name="type" value="{{ $type }}">
            <div>
                <label class="block text-xs mb-1">Name (EN)</label>
                <input type="text" name="name" required class="w-full rounded-xl border border-gray-200 px-3 py-2.5 min-h-[44px] text-sm">
            </div>
            <div>
                <label class="block text-xs mb-1">Name (FR)</label>
                <input type="text" name="name_fr" class="w-full rounded-xl border border-gray-200 px-3 py-2.5 min-h-[44px] text-sm">
            </div>
            <div>
                <label class="block text-xs mb-1">Sort Order</label>
                <input type="number" name="sort_order" min="0" value="0" class="w-full rounded-xl border border-gray-200 px-3 py-2.5 min-h-[44px] text-sm">
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full py-2.5 min-h-[44px] rounded-xl text-white text-sm font-semibold" style="background-color:#BF6B47;">Add</button>
            </div>
        </form>
    </div>

    <div class="mt-4 flex flex-wrap gap-2">
        @forelse($categories as $cat)
        <div x-data="{ editing: false }" class="relative">
            <div class="flex items-center gap-2 pl-3 pr-1.5 py-1.5 min-h-[40px] rounded-full text-sm" style="background:#2E463610;color:#2E4636;">
                <span>{{ $cat->name }}</span>
                @if(!$cat->is_active)
                <span class="text-xs text-gray-400">(hidden)</span>
                @endif
                <button @click="editing = !editing" class="w-7 h-7 flex items-center justify-center rounded-full hover:bg-white/60 transition" aria-label="Edit {{ $cat->name }}">
                    <x-admin-icon name="pencil" class="w-3.5 h-3.5" />
                </button>
                <form action="{{ route('admin.menu.category.destroy', $cat) }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="button"
                            @click="$dispatch('confirm-action', { form: $el.closest('form'), title: 'Delete this category?', message: '\'{{ addslashes($cat->name) }}\' and all its menu items will be removed.' })"
                            class="w-7 h-7 flex items-center justify-center rounded-full hover:bg-red-100 text-red-500 transition" aria-label="Delete {{ $cat->name }}">
                        <x-admin-icon name="trash" class="w-3.5 h-3.5" />
                    </button>
                </form>
            </div>

            <div x-show="editing" x-cloak x-transition @click.outside="editing = false"
                 class="absolute z-10 mt-2 w-72 bg-white rounded-xl shadow-lg border border-gray-100 p-4">
                <form action="{{ route('admin.menu.category.update', $cat) }}" method="POST" class="space-y-3">
                    @csrf @method('PUT')
                    <div>
                        <label class="block text-xs mb-1">Name (EN)</label>
                        <input type="text" name="name" value="{{ $cat->name }}" required class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs mb-1">Name (FR)</label>
                        <input type="text" name="name_fr" value="{{ $cat->name_fr }}" class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs mb-1">Sort Order</label>
                        <input type="number" name="sort_order" value="{{ $cat->sort_order }}" min="0" class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm">
                    </div>
                    <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox" name="is_active" value="1" {{ $cat->is_active ? 'checked' : '' }}>
                        Visible on site
                    </label>
                    <button type="submit" class="w-full py-2 rounded-lg text-white text-sm font-semibold" style="background-color:#2E4636;">Save</button>
                </form>
            </div>
        </div>
        @empty
        <p class="text-sm text-gray-400">No categories yet — add one above.</p>
        @endforelse
    </div>
</div>

{{-- Add Item Form --}}
<div class="bg-white rounded-2xl p-6 shadow-sm mb-8" x-data="{ open: false }">
    <button @click="open = !open" class="flex items-center gap-2 text-sm font-semibold min-h-[44px]" style="color:#BF6B47;">
        <x-admin-icon name="plus" class="w-4 h-4" /> Add New Item
    </button>
    <div x-show="open" x-transition class="mt-4">
        <form action="{{ route('admin.menu.item.store') }}" method="POST" enctype="multipart/form-data" class="grid sm:grid-cols-3 gap-4">
            @csrf
            <div>
                <label class="block text-xs mb-1">Category</label>
                <select name="menu_category_id" required class="w-full rounded-xl border border-gray-200 px-3 py-2.5 min-h-[44px] text-sm">
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs mb-1">Name (EN)</label>
                <input type="text" name="name" required class="w-full rounded-xl border border-gray-200 px-3 py-2.5 min-h-[44px] text-sm">
            </div>
            <div>
                <label class="block text-xs mb-1">Name (FR)</label>
                <input type="text" name="name_fr" class="w-full rounded-xl border border-gray-200 px-3 py-2.5 min-h-[44px] text-sm">
            </div>
            <div>
                <label class="block text-xs mb-1">Description (EN)</label>
                <input type="text" name="description" class="w-full rounded-xl border border-gray-200 px-3 py-2.5 min-h-[44px] text-sm">
            </div>
            <div>
                <label class="block text-xs mb-1">Price (RWF)</label>
                <input type="number" name="price" step="0.01" min="0" required class="w-full rounded-xl border border-gray-200 px-3 py-2.5 min-h-[44px] text-sm">
            </div>
            <div>
                <label class="block text-xs mb-1">Photo (shown on menu &amp; home page)</label>
                <x-image-input name="image" />
            </div>
            <div class="sm:col-span-3 flex justify-end">
                <button type="submit" class="px-6 py-2.5 min-h-[44px] rounded-xl text-white text-sm font-semibold" style="background-color:#BF6B47;">Add Item</button>
            </div>
        </form>
    </div>
</div>

{{-- Categories & Items --}}
<div class="space-y-6">
    @foreach($categories as $cat)
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100" style="background:#2E463610;">
            <h3 class="font-semibold" style="color:#2E4636;">{{ $cat->name }}</h3>
        </div>
        <div class="divide-y divide-gray-100">
            @foreach($cat->items as $item)
            <div x-data="{ editing: false }">
                <div class="px-6 py-3 flex flex-wrap justify-between items-center gap-x-4 gap-y-2 text-sm">
                    <div class="flex items-center gap-3 flex-1 min-w-[200px]">
                        <div class="w-12 h-12 rounded-lg overflow-hidden shrink-0 bg-gray-100 flex items-center justify-center">
                            @if($item->image_url)
                            <img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="w-full h-full object-cover">
                            @else
                            <x-admin-icon name="photo" class="w-5 h-5 text-gray-300" />
                            @endif
                        </div>
                        <div>
                            <span class="font-medium">{{ $item->name }}</span>
                            @if($item->description)<span class="text-gray-400 text-xs block">{{ $item->description }}</span>@endif
                        </div>
                    </div>
                    <span class="font-semibold" style="color:#C9A24B;">{{ frw($item->price, 2) }}</span>
                    <span class="px-2 py-0.5 rounded-full text-xs {{ $item->is_available?'bg-green-100 text-green-700':'bg-red-100 text-red-700' }}">
                        {{ $item->is_available?'Available':'Hidden' }}
                    </span>
                    <div class="flex gap-1">
                        <button @click="editing = !editing" class="w-9 h-9 min-h-[44px] min-w-[44px] flex items-center justify-center rounded-lg hover:bg-gray-100 transition" style="color:#BF6B47;" aria-label="Edit {{ $item->name }}">
                            <x-admin-icon name="pencil" class="w-4 h-4" />
                        </button>
                        <form action="{{ route('admin.menu.item.destroy', $item) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="button"
                                    @click="$dispatch('confirm-action', { form: $el.closest('form'), title: 'Remove this item?', message: '\'{{ addslashes($item->name) }}\' will be removed from the menu.' })"
                                    class="w-9 h-9 min-h-[44px] min-w-[44px] flex items-center justify-center rounded-lg text-red-500 hover:bg-red-50 hover:text-red-700 transition"
                                    aria-label="Delete {{ $item->name }}">
                                <x-admin-icon name="trash" class="w-4 h-4" />
                            </button>
                        </form>
                    </div>
                </div>

                <div x-show="editing" x-cloak x-transition class="px-6 pb-5">
                    <form action="{{ route('admin.menu.item.update', $item) }}" method="POST" enctype="multipart/form-data" class="grid sm:grid-cols-3 gap-4 bg-gray-50 rounded-xl p-4">
                        @csrf @method('PUT')
                        <div>
                            <label class="block text-xs mb-1">Name (EN)</label>
                            <input type="text" name="name" value="{{ $item->name }}" required class="w-full rounded-xl border border-gray-200 px-3 py-2.5 min-h-[44px] text-sm">
                        </div>
                        <div>
                            <label class="block text-xs mb-1">Name (FR)</label>
                            <input type="text" name="name_fr" value="{{ $item->name_fr }}" class="w-full rounded-xl border border-gray-200 px-3 py-2.5 min-h-[44px] text-sm">
                        </div>
                        <div>
                            <label class="block text-xs mb-1">Price (RWF)</label>
                            <input type="number" name="price" step="0.01" min="0" value="{{ $item->price }}" required class="w-full rounded-xl border border-gray-200 px-3 py-2.5 min-h-[44px] text-sm">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-xs mb-1">Description (EN)</label>
                            <input type="text" name="description" value="{{ $item->description }}" class="w-full rounded-xl border border-gray-200 px-3 py-2.5 min-h-[44px] text-sm">
                        </div>
                        <div>
                            <label class="block text-xs mb-1">Photo</label>
                            <x-image-input name="image" :current="$item->image_url" />
                        </div>
                        <label class="flex items-center gap-2 text-sm">
                            <input type="checkbox" name="is_available" value="1" {{ $item->is_available ? 'checked' : '' }}>
                            Available
                        </label>
                        <div class="sm:col-span-3 flex justify-end">
                            <button type="submit" class="px-6 py-2.5 min-h-[44px] rounded-xl text-white text-sm font-semibold" style="background-color:#2E4636;">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
            @endforeach
            @if($cat->items->isEmpty())
            <div class="px-6 py-4 text-sm text-gray-400">No items in this category.</div>
            @endif
        </div>
    </div>
    @endforeach
</div>
@endsection
