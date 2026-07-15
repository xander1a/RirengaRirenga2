<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerPortalController extends Controller
{
    public function dashboard()
    {
        $user     = auth()->user();
        $bookings = $user->bookings()->with('room.roomType')->latest()->get();
        return view('portal.dashboard', compact('user', 'bookings'));
    }

    public function booking(string $reference)
    {
        $booking = auth()->user()->bookings()
            ->with('room.roomType', 'payments')
            ->where('reference', $reference)
            ->firstOrFail();
        return view('portal.booking', compact('booking'));
    }

    public function profile()
    {
        return view('portal.profile', ['user' => auth()->user()]);
    }

    public function updateProfile(Request $request)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'phone' => 'nullable|string|max:30',
        ]);
        auth()->user()->update($data);
        return redirect()->back()->with('success', 'Profile updated.');
    }
}
