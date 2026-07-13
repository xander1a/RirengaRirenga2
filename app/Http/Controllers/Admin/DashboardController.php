<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\InventoryItem;
use App\Models\Room;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $checkInsToday   = Booking::whereDate('check_in', $today)->whereIn('status', ['confirmed', 'pending'])->count();
        $checkOutsToday  = Booking::whereDate('check_out', $today)->whereIn('status', ['confirmed', 'checked_in'])->count();
        $occupiedRooms   = Booking::where('check_in', '<=', $today)->where('check_out', '>', $today)->whereIn('status', ['confirmed', 'checked_in'])->count();
        $totalRooms      = Room::where('is_active', true)->count();
        $occupancyRate   = $totalRooms > 0 ? round(($occupiedRooms / $totalRooms) * 100) : 0;

        $recentBookings  = Booking::with('room.roomType')->latest()->take(10)->get();
        $pendingPayments = Booking::where('payment_status', 'pending')->count();
        $lowStockItems   = InventoryItem::whereRaw('quantity <= low_stock_threshold')->get();

        $monthlyRevenue  = Booking::where('payment_status', 'paid')
            ->whereMonth('created_at', $today->month)
            ->sum('total_amount');

        return view('admin.dashboard', compact(
            'checkInsToday', 'checkOutsToday', 'occupiedRooms', 'totalRooms',
            'occupancyRate', 'recentBookings', 'pendingPayments', 'lowStockItems', 'monthlyRevenue'
        ));
    }
}
