@extends('layouts.admin')
@section('title', 'Edit Post')

@section('content')
<div class="max-w-3xl mx-auto">
    <a href="{{ route('admin.blog.index') }}" class="text-sm text-gray-500 hover:text-gray-700 mb-4 inline-block">← All Posts</a>
    <div class="bg-white rounded-2xl p-8 shadow-sm">
        <form action="{{ route('admin.blog.update', $blogPost) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf @method('PUT')
            <div class="grid sm:grid-cols-2 gap-5">
                <div><label class="block text-sm font-medium mb-1">Title (EN) *</label><input type="text" name="title" required value="{{ old('title', $blogPost->title) }}" class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm focus:outline-none focus:ring-2"></div>
                <div><label class="block text-sm font-medium mb-1">Title (FR)</label><input type="text" name="title_fr" value="{{ old('title_fr', $blogPost->title_fr) }}" class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm focus:outline-none focus:ring-2"></div>
                <div class="sm:col-span-2"><label class="block text-sm font-medium mb-1">Excerpt</label><textarea name="excerpt" rows="2" class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm focus:outline-none focus:ring-2">{{ old('excerpt', $blogPost->excerpt) }}</textarea></div>
                <div class="sm:col-span-2"><label class="block text-sm font-medium mb-1">Body (EN) *</label><textarea name="body" rows="10" required class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm font-mono focus:outline-none focus:ring-2">{{ old('body', $blogPost->body) }}</textarea></div>
                <div class="sm:col-span-2"><label class="block text-sm font-medium mb-1">Body (FR)</label><textarea name="body_fr" rows="6" class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm font-mono focus:outline-none focus:ring-2">{{ old('body_fr', $blogPost->body_fr) }}</textarea></div>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Cover Image</label>
                <x-image-input name="image" :current="$blogPost->image_url" />
            </div>
            <label class="flex items-center gap-2">
                <input type="checkbox" name="is_published" value="1" {{ old('is_published', $blogPost->is_published) ? 'checked' : '' }}>
                <span class="text-sm font-medium">Published</span>
            </label>
            <div class="flex gap-4">
                <button type="submit" class="px-6 py-3 rounded-xl text-white font-semibold" style="background-color:#BF6B47;">Save Changes</button>
                <a href="{{ route('admin.blog.index') }}" class="px-6 py-3 rounded-xl border border-gray-200 text-sm hover:bg-gray-50">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
