<?php

namespace App\Http\Controllers;

use App\Models\TableReservation;
use App\Models\VipReservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function tableReserve(Request $request)
    {
        $data = $request->validate([
            'guest_name'      => 'required|string|max:255',
            'guest_email'     => 'required|email',
            'guest_phone'     => 'nullable|string|max:30',
            'date'            => 'required|date|after_or_equal:today',
            'time'            => 'required',
            'party_size'      => 'required|integer|min:1|max:50',
            'special_requests'=> 'nullable|string|max:500',
        ]);

        $data['reference'] = TableReservation::generateReference();

        TableReservation::create($data);

        return redirect()->back()->with('success', __('reservation.table_success'));
    }

    public function vipReserve(Request $request)
    {
        $data = $request->validate([
            'guest_name' => 'required|string|max:255',
            'guest_email'=> 'required|email',
            'guest_phone'=> 'nullable|string|max:30',
            'date'       => 'required|date|after_or_equal:today',
            'time'       => 'required',
            'party_size' => 'required|integer|min:1',
            'requests'   => 'nullable|string|max:1000',
        ]);

        $data['reference'] = VipReservation::generateReference();

        VipReservation::create($data);

        return redirect()->back()->with('success', __('reservation.vip_success'));
    }
}
