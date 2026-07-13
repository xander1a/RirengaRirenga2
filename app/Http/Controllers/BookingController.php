<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use App\Models\RoomType;
use App\Payments\BankTransferGateway;
use App\Payments\CardGateway;
use App\Payments\MoMoGateway;
use App\Payments\PaypackGateway;
use App\Payments\PayOnArrivalGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $checkIn   = $request->input('check_in');
        $checkOut  = $request->input('check_out');
        $guests    = $request->input('guests', 1);

        $availableRoomTypes = collect();

        if ($checkIn && $checkOut && $checkIn < $checkOut) {
            // Find room types that have at least one available physical room
            $availableRoomTypes = RoomType::where('is_active', true)
                ->with(['rooms' => function ($q) use ($checkIn, $checkOut) {
                    $q->where('is_active', true)->where('status', '!=', 'maintenance');
                }])
                ->get()
                ->filter(function ($type) use ($checkIn, $checkOut) {
                    return $type->rooms->contains(fn($room) => $room->isAvailableFor($checkIn, $checkOut));
                });
        }

        return view('public.booking', compact('availableRoomTypes', 'checkIn', 'checkOut', 'guests'));
    }

    public function selectRoom(Request $request)
    {
        $request->validate([
            'check_in'     => 'required|date|after_or_equal:today',
            'check_out'    => 'required|date|after:check_in',
            'guests'       => 'required|integer|min:1|max:10',
            'room_type_id' => 'required|exists:room_types,id',
        ]);

        // Find the first available room of the selected type
        $roomType = RoomType::findOrFail($request->room_type_id);
        $room = $roomType->rooms()
            ->where('is_active', true)
            ->where('status', '!=', 'maintenance')
            ->get()
            ->first(fn($r) => $r->isAvailableFor($request->check_in, $request->check_out));

        if (!$room) {
            return back()->withErrors(['room' => 'This room type is no longer available for the selected dates.']);
        }

        $nights = \Carbon\Carbon::parse($request->check_in)->diffInDays($request->check_out);
        $total  = $nights * $roomType->price_per_night;

        // Store selection in session for the guest-details step
        session([
            'booking_draft' => [
                'room_id'        => $room->id,
                'room_type_id'   => $roomType->id,
                'check_in'       => $request->check_in,
                'check_out'      => $request->check_out,
                'guests'         => $request->guests,
                'nights'         => $nights,
                'price_per_night'=> $roomType->price_per_night,
                'total_amount'   => $total,
            ]
        ]);

        return redirect()->route('booking.guest-details');
    }

    public function guestDetails()
    {
        $draft = session('booking_draft');
        if (!$draft) return redirect()->route('booking');

        $roomType = RoomType::find($draft['room_type_id']);
        return view('public.booking-guest', compact('draft', 'roomType'));
    }

    public function storeGuestDetails(Request $request)
    {
        $draft = session('booking_draft');
        if (!$draft) return redirect()->route('booking');

        $data = $request->validate([
            'guest_name'      => 'required|string|max:255',
            'guest_email'     => 'required|email',
            'guest_phone'     => 'nullable|string|max:30',
            'special_requests'=> 'nullable|string|max:1000',
        ]);

        session(['booking_draft' => array_merge($draft, $data)]);
        return redirect()->route('booking.payment-choice');
    }

    public function paymentChoice()
    {
        $draft = session('booking_draft');
        if (!$draft) return redirect()->route('booking');

        $roomType = RoomType::find($draft['room_type_id']);
        return view('public.booking-payment', compact('draft', 'roomType'));
    }

    public function processPayment(Request $request)
    {
        $draft = session('booking_draft');
        if (!$draft) return redirect()->route('booking');

        $request->validate([
            'payment_method' => 'required|in:paypack,momo,bank_transfer,card,pay_on_arrival',
            'phone'          => 'required_if:payment_method,paypack|nullable|string|max:20',
        ]);

        // Create the booking record
        $booking = Booking::create([
            'reference'       => Booking::generateReference(),
            'user_id'         => auth()->id(),
            'room_id'         => $draft['room_id'],
            'check_in'        => $draft['check_in'],
            'check_out'       => $draft['check_out'],
            'guests'          => $draft['guests'],
            'guest_name'      => $draft['guest_name'],
            'guest_email'     => $draft['guest_email'],
            'guest_phone'     => $draft['guest_phone'] ?? null,
            'price_per_night' => $draft['price_per_night'],
            'total_amount'    => $draft['total_amount'],
            'payment_method'  => $request->payment_method,
            'special_requests'=> $draft['special_requests'] ?? null,
            'status'          => 'pending',
            'payment_status'  => 'pending',
        ]);

        // Initiate payment via the appropriate gateway
        $gateway = match($request->payment_method) {
            'paypack'        => new PaypackGateway(),
            'momo'           => new MoMoGateway(),
            'bank_transfer'  => new BankTransferGateway(),
            'card'           => new CardGateway(),
            default          => new PayOnArrivalGateway(),
        };

        $payment = $gateway->initiate($booking, ['phone' => $request->phone]);

        // If card gateway produced a payment link, redirect to it
        if ($request->payment_method === 'card' && $payment->payment_link) {
            return redirect($payment->payment_link);
        }

        session()->forget('booking_draft');

        // Send confirmation email (queued)
        try {
            Mail::to($booking->guest_email)->send(new \App\Mail\BookingConfirmation($booking));
        } catch (\Exception) {
            // Email failure should not break booking
        }

        return redirect()->route('booking.confirmation', $booking->reference);
    }

    public function confirmation(string $reference)
    {
        $booking = Booking::where('reference', $reference)
            ->with(['room.roomType'])
            ->firstOrFail();

        return view('public.booking-confirmation', compact('booking'));
    }

    public function paymentCallback(Request $request, string $reference)
    {
        // Flutterwave redirect after card payment
        $booking = Booking::where('reference', $reference)->firstOrFail();
        (new CardGateway())->handleCallback($request->all());
        $booking->refresh();
        return redirect()->route('booking.confirmation', $booking->reference);
    }
}
