<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuCategory;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuAdminController extends Controller
{
    public function index(string $type = 'restaurant')
    {
        $categories = MenuCategory::where('type', $type)->with('items')->orderBy('sort_order')->get();
        return view('admin.menu.index', compact('categories', 'type'));
    }

    public function storeCategory(Request $request)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:255',
            'name_fr'   => 'nullable|string|max:255',
            'type'      => 'required|in:restaurant,bar',
            'sort_order'=> 'nullable|integer|min:0',
        ]);
        $data['sort_order'] = $data['sort_order'] ?? 0;
        MenuCategory::create($data);

        return redirect()->back()->with('success', 'Category added.');
    }

    public function updateCategory(Request $request, MenuCategory $menuCategory)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:255',
            'name_fr'   => 'nullable|string|max:255',
            'sort_order'=> 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);
        $data['is_active'] = $request->boolean('is_active', true);
        $menuCategory->update($data);

        return redirect()->back()->with('success', 'Category updated.');
    }

    public function destroyCategory(MenuCategory $menuCategory)
    {
        foreach ($menuCategory->items as $item) {
            if ($item->image) {
                Storage::disk('public')->delete($item->image);
            }
        }
        $menuCategory->delete();

        return redirect()->back()->with('success', 'Category and its items removed.');
    }

    public function storeItem(Request $request)
    {
        $data = $request->validate([
            'menu_category_id' => 'required|exists:menu_categories,id',
            'name'             => 'required|string|max:255',
            'name_fr'          => 'nullable|string|max:255',
            'description'      => 'nullable|string',
            'description_fr'   => 'nullable|string',
            'price'            => 'required|numeric|min:0',
            'image'            => 'nullable|image|max:4096',
            'is_available'     => 'boolean',
        ]);
        $data['is_available'] = $request->boolean('is_available', true);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('menu', 'public');
        }

        MenuItem::create($data);
        return redirect()->back()->with('success', 'Item added.');
    }

    public function updateItem(Request $request, MenuItem $menuItem)
    {
        $data = $request->validate([
            'name'         => 'required|string|max:255',
            'name_fr'      => 'nullable|string|max:255',
            'description'  => 'nullable|string',
            'price'        => 'required|numeric|min:0',
            'image'        => 'nullable|image|max:4096',
            'is_available' => 'boolean',
        ]);
        $data['is_available'] = $request->boolean('is_available');

        if ($request->hasFile('image')) {
            if ($menuItem->image) {
                Storage::disk('public')->delete($menuItem->image);
            }
            $data['image'] = $request->file('image')->store('menu', 'public');
        }

        $menuItem->update($data);
        return redirect()->back()->with('success', 'Item updated.');
    }

    public function destroyItem(MenuItem $menuItem)
    {
        if ($menuItem->image) {
            Storage::disk('public')->delete($menuItem->image);
        }
        $menuItem->delete();
        return redirect()->back()->with('success', 'Item removed.');
    }
}
