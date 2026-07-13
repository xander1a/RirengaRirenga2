<?php

namespace App\Http\Controllers;

use App\Models\RoomType;

class RoomController extends Controller
{
    public function index()
    {
        $roomTypes = RoomType::where('is_active', true)->get();
        return view('public.rooms', compact('roomTypes'));
    }

    public function show(RoomType $roomType)
    {
        return view('public.room-detail', compact('roomType'));
    }
}
