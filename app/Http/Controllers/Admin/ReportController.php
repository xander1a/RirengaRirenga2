<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $from = $request->input('from', now()->startOfMonth()->format('Y-m-d'));
        $to   = $request->input('to', now()->format('Y-m-d'));

        $bookings = Booking::with('room.roomType')
            ->whereBetween('check_in', [$from, $to])
            ->get();

        $totalRevenue   = $bookings->where('payment_status', 'paid')->sum('total_amount');
        $totalBookings  = $bookings->count();
        $byPaymentMethod = $bookings->where('payment_status', 'paid')->groupBy('payment_method')
            ->map(fn($g) => ['count' => $g->count(), 'total' => $g->sum('total_amount')]);

        $totalRooms     = Room::where('is_active', true)->count();
        $days           = Carbon::parse($from)->diffInDays(Carbon::parse($to)) + 1;
        $possibleNights = $totalRooms * $days;
        $bookedNights   = $bookings->sum(fn($b) => $b->check_in->diffInDays($b->check_out));
        $occupancyRate  = $possibleNights > 0 ? round(($bookedNights / $possibleNights) * 100, 1) : 0;

        return view('admin.reports.index', compact(
            'from', 'to', 'bookings', 'totalRevenue', 'totalBookings',
            'byPaymentMethod', 'occupancyRate'
        ));
    }

    public function export(Request $request)
    {
        $from = $request->input('from', now()->startOfMonth()->format('Y-m-d'));
        $to   = $request->input('to', now()->format('Y-m-d'));

        $bookings = Booking::with('room.roomType')
            ->whereBetween('check_in', [$from, $to])
            ->get();

        $csv = "Reference,Guest,Email,Room,Check In,Check Out,Nights,Total,Status,Payment Method,Payment Status\n";
        foreach ($bookings as $b) {
            $nights = $b->check_in->diffInDays($b->check_out);
            $csv .= implode(',', [
                $b->reference, "\"{$b->guest_name}\"", $b->guest_email,
                "\"{$b->room->roomType->name}\"",
                $b->check_in->format('Y-m-d'), $b->check_out->format('Y-m-d'),
                $nights, $b->total_amount, $b->status, $b->payment_method ?? '', $b->payment_status,
            ]) . "\n";
        }

        return response($csv, 200, [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"report-{$from}-{$to}.csv\"",
        ]);
    }
}
