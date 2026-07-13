<?php

namespace App\Payments;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Support\Facades\Log;
use Paypack\Paypack;

/**
 * Paypack (Rwanda mobile money — MTN/Airtel) integration.
 * Docs: https://docs.paypack.rw/sdk/laravel
 *
 * TODO: Set PAYPACK_CLIENT_ID / PAYPACK_CLIENT_SECRET in .env once you have
 * a Paypack merchant account. Until then this gateway stays "pending" so
 * staff can confirm payment manually.
 */
class PaypackGateway implements PaymentGateway
{
    public function name(): string
    {
        return 'paypack';
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

        $clientId = config('services.paypack.client_id');
        $clientSecret = config('services.paypack.client_secret');

        if (!$clientId || $clientId === 'your_client_id_here') {
            Log::info('Paypack: credentials not configured, staying as pending for booking ' . $booking->reference);
            return $payment;
        }

        $phone = $options['phone'] ?? $booking->guest_phone;

        if (!$phone) {
            $payment->update(['status' => 'failed', 'gateway_response' => ['error' => 'No phone number provided for Paypack cashin.']]);
            return $payment;
        }

        try {
            Paypack::config([
                'client_id'     => $clientId,
                'client_secret' => $clientSecret,
                'webhook_mode'  => config('services.paypack.webhook_mode', 'development'),
            ]);

            $response = Paypack::Cashin([
                'phone'  => $this->normalizePhone($phone),
                'amount' => (int) round($booking->total_amount),
            ]);

            $payment->update([
                'gateway_reference' => $response['ref'] ?? $response['data']['ref'] ?? null,
                'status'            => 'processing',
                'gateway_response'  => $response,
            ]);
        } catch (\Exception $e) {
            Log::error('Paypack cashin exception: ' . $e->getMessage());
            $payment->update(['status' => 'failed', 'gateway_response' => ['error' => $e->getMessage()]]);
        }

        return $payment->fresh();
    }

    public function handleCallback(array $payload): void
    {
        // TODO: verify against the real Paypack webhook payload shape once
        // a live merchant account is connected — field names below are best-effort.
        $reference = $payload['ref'] ?? $payload['data']['ref'] ?? null;
        if (!$reference) {
            Log::warning('Paypack webhook missing ref', $payload);
            return;
        }

        $payment = Payment::where('gateway_reference', $reference)->first();
        if (!$payment) {
            Log::warning('Paypack webhook: no matching payment for ref ' . $reference);
            return;
        }

        $status = strtolower($payload['status'] ?? $payload['data']['status'] ?? '');

        if (in_array($status, ['success', 'successful', 'completed'])) {
            $payment->update(['status' => 'completed', 'paid_at' => now(), 'gateway_response' => $payload]);
            $payment->booking->update(['payment_status' => 'paid', 'status' => 'confirmed', 'confirmed_at' => now()]);
        } elseif (in_array($status, ['failed', 'cancelled'])) {
            $payment->update(['status' => 'failed', 'gateway_response' => $payload]);
        } else {
            $payment->update(['gateway_response' => $payload]);
        }
    }

    private function normalizePhone(string $phone): string
    {
        $phone = preg_replace('/\D/', '', $phone);

        if (str_starts_with($phone, '0')) {
            $phone = '25' . $phone;
        } elseif (!str_starts_with($phone, '250')) {
            $phone = '250' . $phone;
        }

        return $phone;
    }
}
