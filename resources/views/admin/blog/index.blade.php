@extends('layouts.admin')
@section('title', 'Blog')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div></div>
    <a href="{{ route('admin.blog.create') }}" class="flex items-center gap-2 px-4 py-2.5 min-h-[44px] rounded-xl text-white text-sm font-semibold" style="background-color:#D07A54;">
        <x-admin-icon name="plus" class="w-4 h-4" /> New Post
    </a>
</div>
<div class="bg-white rounded-2xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto admin-scroll">
    <table class="w-full text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Title</th>
                <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Author</th>
                <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Published</th>
                <th class="px-5 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach($posts as $post)
            <tr>
                <td class="px-5 py-3 font-medium">{{ $post->title }}</td>
                <td class="px-5 py-3 text-gray-500">{{ $post->author?->name ?? '—' }}</td>
                <td class="px-5 py-3">
                    <span class="px-2 py-0.5 rounded-full text-xs {{ $post->is_published?'bg-green-100 text-green-700':'bg-gray-100 text-gray-500' }}">
                        {{ $post->is_published ? $post->published_at?->format('d M Y') : 'Draft' }}
                    </span>
                </td>
                <td class="px-5 py-3">
                    <div class="flex gap-1 justify-end">
                        <a href="{{ route('admin.blog.edit', $post) }}"
                           class="w-9 h-9 min-h-[44px] min-w-[44px] flex items-center justify-center rounded-lg hover:bg-gray-100 transition" style="color:#D07A54;"
                           aria-label="Edit {{ $post->title }}">
                            <x-admin-icon name="pencil" class="w-4 h-4" />
                        </a>
                        <form action="{{ route('admin.blog.destroy', $post) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="button"
                                    @click="$dispatch('confirm-action', { form: $el.closest('form'), title: 'Delete this post?', message: '\'{{ addslashes($post->title) }}\' will be permanently deleted.' })"
                                    class="w-9 h-9 min-h-[44px] min-w-[44px] flex items-center justify-center rounded-lg text-red-500 hover:bg-red-50 hover:text-red-700 transition"
                                    aria-label="Delete {{ $post->title }}">
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
    <div class="px-5 py-4 border-t">{{ $posts->links() }}</div>
</div>
@endsection
