<?php

namespace App\Payments;

use App\Models\Booking;
use App\Models\Payment;

class BankTransferGateway implements PaymentGateway
{
    public function name(): string
    {
        return 'bank_transfer';
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
        // Bank transfers are confirmed manually by staff via the admin panel.
    }
}
