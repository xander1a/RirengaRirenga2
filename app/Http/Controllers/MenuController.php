<?php

namespace App\Http\Controllers;

use App\Models\MenuCategory;
use App\Models\BarEvent;
use App\Models\BarPromotion;

class MenuController extends Controller
{
    public function restaurant()
    {
        $categories = MenuCategory::where('type', 'restaurant')
            ->where('is_active', true)
            ->with(['items' => fn($q) => $q->where('is_available', true)])
            ->orderBy('sort_order')
            ->get();

        return view('public.restaurant', compact('categories'));
    }

    public function bar()
    {
        $categories = MenuCategory::where('type', 'bar')
            ->where('is_active', true)
            ->with(['items' => fn($q) => $q->where('is_available', true)])
            ->orderBy('sort_order')
            ->get();

        $events = BarEvent::where('is_active', true)
            ->where('starts_at', '>=', now())
            ->orderBy('starts_at')
            ->get();

        $promotions = BarPromotion::where('is_active', true)->get();

        return view('public.bar', compact('categories', 'events', 'promotions'));
    }
}
