<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogAdminController extends Controller
{
    public function index()
    {
        $posts = BlogPost::with('author')->latest()->paginate(20);
        return view('admin.blog.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.blog.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'title_fr'     => 'nullable|string|max:255',
            'excerpt'      => 'nullable|string',
            'excerpt_fr'   => 'nullable|string',
            'body'         => 'required|string',
            'body_fr'      => 'nullable|string',
            'image'        => 'nullable|image|max:4096',
            'is_published' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('blog', 'public');
        }

        $data['slug']         = Str::slug($data['title']);
        $data['user_id']      = auth()->id();
        $data['is_published'] = $request->boolean('is_published');
        if ($data['is_published']) $data['published_at'] = now();

        BlogPost::create($data);
        return redirect()->route('admin.blog.index')->with('success', 'Post created.');
    }

    public function edit(BlogPost $blogPost)
    {
        return view('admin.blog.edit', compact('blogPost'));
    }

    public function update(Request $request, BlogPost $blogPost)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'title_fr'     => 'nullable|string|max:255',
            'excerpt'      => 'nullable|string',
            'body'         => 'required|string',
            'body_fr'      => 'nullable|string',
            'image'        => 'nullable|image|max:4096',
            'is_published' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($blogPost->image) Storage::disk('public')->delete($blogPost->image);
            $data['image'] = $request->file('image')->store('blog', 'public');
        }

        $data['is_published'] = $request->boolean('is_published');
        if ($data['is_published'] && !$blogPost->published_at) $data['published_at'] = now();

        $blogPost->update($data);
        return redirect()->route('admin.blog.index')->with('success', 'Post updated.');
    }

    public function destroy(BlogPost $blogPost)
    {
        if ($blogPost->image) Storage::disk('public')->delete($blogPost->image);
        $blogPost->delete();
        return redirect()->route('admin.blog.index')->with('success', 'Post deleted.');
    }
}
