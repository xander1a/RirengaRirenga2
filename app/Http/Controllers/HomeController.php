<?php

namespace App\Http\Controllers;

use App\Models\RoomType;
use App\Models\BlogPost;
use App\Models\MenuItem;

class HomeController extends Controller
{
    public function index()
    {
        $featuredRooms = RoomType::where('is_active', true)->get();
        $latestPosts   = BlogPost::where('is_published', true)->latest('published_at')->take(3)->get();

        $restaurantImage = MenuItem::whereNotNull('image')
            ->whereHas('category', fn ($q) => $q->where('type', 'restaurant'))
            ->latest()->first();
        $barImage = MenuItem::whereNotNull('image')
            ->whereHas('category', fn ($q) => $q->where('type', 'bar'))
            ->latest()->first();

        return view('public.home', compact('featuredRooms', 'latestPosts', 'restaurantImage', 'barImage'));
    }

    public function about()
    {
        return view('public.about');
    }

    public function services()
    {
        return view('public.services');
    }

    public function contact()
    {
        return view('public.contact');
    }

    public function setLocale(string $locale)
    {
        if (in_array($locale, ['en', 'fr'])) {
            session(['locale' => $locale]);
        }
        return redirect()->back();
    }
}
