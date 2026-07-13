<?php

namespace App\Payments;

use App\Models\Booking;
use App\Models\Payment;

class PayOnArrivalGateway implements PaymentGateway
{
    public function name(): string
    {
        return 'pay_on_arrival';
    }

    public function initiate(Booking $booking, array $options = []): Payment
    {
        return Payment::create([
            'booking_id' => $booking->id,
            'gateway'    => $this->name(),
            'amount'     => $booking->total_amount,
            'currency'   => 'RWF',
            'status'     => 'pending',
        ]);
    }

    public function handleCallback(array $payload): void
    {
        // No callback — staff confirms manually.
    }
}
