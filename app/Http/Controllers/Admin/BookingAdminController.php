<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with('room.roomType')->latest();

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }
        if ($payment = $request->input('payment_status')) {
            $query->where('payment_status', $payment);
        }
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('reference', 'like', "%$search%")
                  ->orWhere('guest_name', 'like', "%$search%")
                  ->orWhere('guest_email', 'like', "%$search%");
            });
        }

        $bookings = $query->paginate(20)->withQueryString();
        return view('admin.bookings.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        $booking->load('room.roomType', 'payments');
        return view('admin.bookings.show', compact('booking'));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate(['status' => 'required|in:pending,confirmed,cancelled,checked_in,checked_out']);
        $booking->update(['status' => $request->status]);
        return redirect()->back()->with('success', 'Booking status updated.');
    }

    public function confirmPayment(Booking $booking)
    {
        $booking->update([
            'payment_status' => 'manual_confirmed',
            'status'         => 'confirmed',
            'confirmed_at'   => now(),
        ]);
        return redirect()->back()->with('success', 'Payment manually confirmed.');
    }

    public function export(Request $request)
    {
        $bookings = Booking::with('room.roomType')
            ->when($request->from, fn($q) => $q->where('check_in', '>=', $request->from))
            ->when($request->to, fn($q) => $q->where('check_in', '<=', $request->to))
            ->get();

        $csv = "Reference,Guest,Email,Phone,Room,Check In,Check Out,Nights,Total,Status,Payment\n";
        foreach ($bookings as $b) {
            $nights = $b->check_in->diffInDays($b->check_out);
            $csv .= implode(',', [
                $b->reference, "\"{$b->guest_name}\"", $b->guest_email, $b->guest_phone ?? '',
                "\"{$b->room->roomType->name}\"", $b->check_in->format('Y-m-d'), $b->check_out->format('Y-m-d'),
                $nights, $b->total_amount, $b->status, $b->payment_status,
            ]) . "\n";
        }

        return response($csv, 200, [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="bookings.csv"',
        ]);
    }
}
