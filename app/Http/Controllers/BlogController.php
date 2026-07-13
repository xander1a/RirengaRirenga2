<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;

class BlogController extends Controller
{
    public function index()
    {
        $posts = BlogPost::where('is_published', true)->latest('published_at')->paginate(9);
        return view('public.blog', compact('posts'));
    }

    public function show(BlogPost $blogPost)
    {
        abort_unless($blogPost->is_published, 404);
        return view('public.blog-post', compact('blogPost'));
    }
}
