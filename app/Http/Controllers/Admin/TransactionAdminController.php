<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class TransactionAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with('booking')->latest();

        if ($request->filled('gateway')) {
            $query->where('gateway', $request->gateway);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('gateway_reference', 'like', "%{$search}%")
                  ->orWhereHas('booking', fn ($b) => $b->where('reference', 'like', "%{$search}%")
                                                        ->orWhere('guest_name', 'like', "%{$search}%"));
            });
        }

        $transactions = $query->paginate(20)->withQueryString();

        $totals = [
            'completed' => Payment::where('status', 'completed')->sum('amount'),
            'pending'   => Payment::whereIn('status', ['pending', 'processing'])->count(),
            'failed'    => Payment::where('status', 'failed')->count(),
        ];

        return view('admin.transactions.index', compact('transactions', 'totals'));
    }
}
