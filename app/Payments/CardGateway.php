<?php

namespace App\Payments;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Flutterwave card payment gateway scaffold.
 *
 * TODO: Set FLUTTERWAVE_PUBLIC_KEY, FLUTTERWAVE_SECRET_KEY, FLUTTERWAVE_WEBHOOK_SECRET
 *       in .env when account is created. The initiate() method will return a hosted
 *       payment link that redirects the guest to Flutterwave's payment page.
 */
class CardGateway implements PaymentGateway
{
    public function name(): string
    {
        return 'card';
    }

    public function initiate(Booking $booking, array $options = []): Payment
    {
        $payment = Payment::create([
            'booking_id' => $booking->id,
            'gateway'    => $this->name(),
            'amount'     => $booking->total_amount,
            'currency'   => 'RWF',
            'status'     => 'pending',
        ]);

        $secretKey = config('services.flutterwave.secret_key');

        if (!$secretKey || $secretKey === 'your_secret_key_here') {
            // TODO: credentials not yet configured
            return $payment;
        }

        try {
            $response = Http::withToken($secretKey)
                ->post('https://api.flutterwave.com/v3/payments', [
                    'tx_ref'       => $booking->reference . '-' . $payment->id,
                    'amount'       => $booking->total_amount,
                    'currency'     => 'RWF',
                    'redirect_url' => route('booking.payment.callback', ['booking' => $booking->reference]),
                    'customer'     => [
                        'email'      => $booking->guest_email,
                        'name'       => $booking->guest_name,
                        'phonenumber'=> $booking->guest_phone,
                    ],
                    'meta'         => ['booking_ref' => $booking->reference],
                    'customizations' => [
                        'title'       => 'BYIZA Eco-lodge',
                        'description' => 'Booking ' . $booking->reference,
                    ],
                ]);

            if ($response->json('status') === 'success') {
                $link = $response->json('data.link');
                $payment->update(['payment_link' => $link, 'status' => 'processing']);
            } else {
                $payment->update(['status' => 'failed']);
            }
        } catch (\Exception $e) {
            Log::error('Flutterwave initiate error: ' . $e->getMessage());
            $payment->update(['status' => 'failed']);
        }

        return $payment->fresh();
    }

    public function handleCallback(array $payload): void
    {
        $txRef = $payload['tx_ref'] ?? null;
        if (!$txRef) return;

        [$bookingRef] = explode('-', $txRef);
        $booking = \App\Models\Booking::where('reference', $bookingRef)->first();
        if (!$booking) return;

        $payment = Payment::where('booking_id', $booking->id)->where('gateway', 'card')->latest()->first();
        if (!$payment) return;

        if (($payload['status'] ?? '') === 'successful') {
            $payment->update(['status' => 'completed', 'paid_at' => now(), 'gateway_response' => $payload]);
            $booking->update(['payment_status' => 'paid', 'status' => 'confirmed', 'confirmed_at' => now()]);
        } else {
            $payment->update(['status' => 'failed', 'gateway_response' => $payload]);
        }
    }
}
