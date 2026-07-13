@extends('layouts.admin')
@section('title', 'New Post')

@section('content')
<div class="max-w-3xl mx-auto">
    <a href="{{ route('admin.blog.index') }}" class="text-sm text-gray-500 hover:text-gray-700 mb-4 inline-block">← All Posts</a>
    <div class="bg-white rounded-2xl p-8 shadow-sm">
        <form action="{{ route('admin.blog.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            <div class="grid sm:grid-cols-2 gap-5">
                <div><label class="block text-sm font-medium mb-1">Title (EN) *</label><input type="text" name="title" required class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm focus:outline-none focus:ring-2" value="{{ old('title') }}"></div>
                <div><label class="block text-sm font-medium mb-1">Title (FR)</label><input type="text" name="title_fr" class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm focus:outline-none focus:ring-2" value="{{ old('title_fr') }}"></div>
                <div class="sm:col-span-2"><label class="block text-sm font-medium mb-1">Excerpt (EN)</label><textarea name="excerpt" rows="2" class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm focus:outline-none focus:ring-2">{{ old('excerpt') }}</textarea></div>
                <div class="sm:col-span-2"><label class="block text-sm font-medium mb-1">Body (EN) * — HTML allowed</label><textarea name="body" rows="10" required class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm font-mono focus:outline-none focus:ring-2">{{ old('body') }}</textarea></div>
                <div class="sm:col-span-2"><label class="block text-sm font-medium mb-1">Body (FR)</label><textarea name="body_fr" rows="6" class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm font-mono focus:outline-none focus:ring-2">{{ old('body_fr') }}</textarea></div>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Cover Image</label>
                <x-image-input name="image" />
            </div>
            <label class="flex items-center gap-2">
                <input type="checkbox" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}>
                <span class="text-sm font-medium">Publish immediately</span>
            </label>
            <div class="flex gap-4">
                <button type="submit" class="px-6 py-3 rounded-xl text-white font-semibold" style="background-color:#BF6B47;">Save Post</button>
                <a href="{{ route('admin.blog.index') }}" class="px-6 py-3 rounded-xl border border-gray-200 text-gray-700 text-sm hover:bg-gray-50">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
