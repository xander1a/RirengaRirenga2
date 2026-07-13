<?php

namespace App\Payments;

use App\Models\Booking;
use App\Models\Payment;

interface PaymentGateway
{
    /**
     * Initiate a payment for a booking. Returns the Payment model.
     */
    public function initiate(Booking $booking, array $options = []): Payment;

    /**
     * Handle a webhook/callback from the gateway.
     */
    public function handleCallback(array $payload): void;

    /**
     * Return the gateway identifier string.
     */
    public function name(): string;
}
