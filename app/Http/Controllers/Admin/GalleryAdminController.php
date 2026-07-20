<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryAdminController extends Controller
{
    public function index()
    {
        $photos = GalleryPhoto::orderBy('category')->orderBy('sort_order')->get();
        return view('admin.gallery.index', compact('photos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'photo'    => 'required|image|max:5120',
            'category' => 'required|in:rooms,restaurant,bar,surroundings',
            'title'    => 'nullable|string|max:255',
        ]);

        $path = store_image($request->file('photo'), 'gallery');

        GalleryPhoto::create([
            'file_path' => $path,
            'category'  => $request->category,
            'title'     => $request->title,
        ]);

        return redirect()->back()->with('success', 'Photo uploaded.');
    }

    public function destroy(GalleryPhoto $galleryPhoto)
    {
        Storage::disk('public')->delete($galleryPhoto->file_path);
        $galleryPhoto->delete();
        return redirect()->back()->with('success', 'Photo deleted.');
    }
}
