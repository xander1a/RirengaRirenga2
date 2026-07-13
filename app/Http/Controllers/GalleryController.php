<?php

namespace App\Http\Controllers;

use App\Models\GalleryPhoto;

class GalleryController extends Controller
{
    public function index()
    {
        $photos = GalleryPhoto::where('is_active', true)->orderBy('sort_order')->get();
        $grouped = $photos->groupBy('category');
        return view('public.gallery', compact('photos', 'grouped'));
    }
}
