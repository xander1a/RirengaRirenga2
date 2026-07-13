<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InventoryItem;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $items = InventoryItem::orderBy('category')->orderBy('name')->get();
        return view('admin.inventory.index', compact('items'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'                => 'required|string|max:255',
            'category'            => 'nullable|string|max:100',
            'unit'                => 'required|string|max:50',
            'quantity'            => 'required|numeric|min:0',
            'low_stock_threshold' => 'required|numeric|min:0',
            'supplier'            => 'nullable|string|max:255',
            'notes'               => 'nullable|string',
        ]);
        InventoryItem::create($data);
        return redirect()->back()->with('success', 'Item added.');
    }

    public function update(Request $request, InventoryItem $inventoryItem)
    {
        $data = $request->validate([
            'quantity'            => 'required|numeric|min:0',
            'low_stock_threshold' => 'required|numeric|min:0',
        ]);
        $inventoryItem->update($data);
        return redirect()->back()->with('success', 'Stock updated.');
    }
}
