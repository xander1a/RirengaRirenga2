<?php

namespace App\Payments;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * MTN MoMo Collections API integration (Rwanda).
 *
 * TODO: Set the following .env values when live credentials are obtained:
 *   MOMO_BASE_URL, MOMO_COLLECTION_SUBSCRIPTION_KEY,
 *   MOMO_COLLECTION_USER_ID, MOMO_COLLECTION_API_KEY,
 *   MOMO_ENVIRONMENT, MOMO_CURRENCY, MOMO_CALLBACK_URL
 *
 * Until credentials are provided the gateway falls back to "pay on arrival".
 */
class MoMoGateway implements PaymentGateway
{
    public function name(): string
    {
        return 'momo';
    }

    public function initiate(Booking $booking, array $options = []): Payment
    {
        $payment = Payment::create([
            'booking_id' => $booking->id,
            'gateway'    => $this->name(),
            'amount'     => $booking->total_amount,
            'currency'   => config('services.momo.currency', 'RWF'),
            'status'     => 'pending',
        ]);

        $subscriptionKey = config('services.momo.collection_subscription_key');

        // If credentials are missing, stay in pending (manual confirmation flow)
        if (!$subscriptionKey || $subscriptionKey === 'your_subscription_key_here') {
            Log::info('MoMo: credentials not configured, staying as pending for booking ' . $booking->reference);
            return $payment;
        }

        try {
            $referenceId = (string) \Illuminate\Support\Str::uuid();

            $response = Http::withHeaders([
                'Authorization'              => 'Bearer ' . $this->getAccessToken(),
                'X-Reference-Id'             => $referenceId,
                'X-Target-Environment'       => config('services.momo.environment', 'sandbox'),
                'Ocp-Apim-Subscription-Key'  => $subscriptionKey,
                'Content-Type'               => 'application/json',
            ])->post(config('services.momo.base_url') . '/collection/v1_0/requesttopay', [
                'amount'      => (string) intval($booking->total_amount),
                'currency'    => config('services.momo.currency', 'RWF'),
                'externalId'  => $booking->reference,
                'payer'       => [
                    'partyIdType' => 'MSISDN',
                    'partyId'     => ltrim($booking->guest_phone ?? $options['phone'] ?? '', '+'),
                ],
                'payerMessage' => 'BYIZA Eco-lodge booking ' . $booking->reference,
                'payeeNote'    => 'Booking ' . $booking->reference,
            ]);

            if ($response->successful()) {
                $payment->update([
                    'gateway_reference' => $referenceId,
                    'status'            => 'processing',
                ]);
            } else {
                Log::error('MoMo request-to-pay failed', ['body' => $response->body()]);
                $payment->update(['status' => 'failed', 'gateway_response' => ['error' => $response->body()]]);
            }
        } catch (\Exception $e) {
            Log::error('MoMo exception: ' . $e->getMessage());
            $payment->update(['status' => 'failed']);
        }

        return $payment->fresh();
    }

    public function handleCallback(array $payload): void
    {
        $referenceId = $payload['referenceId'] ?? null;
        if (!$referenceId) return;

        $payment = Payment::where('gateway_reference', $referenceId)->first();
        if (!$payment) return;

        $status = strtolower($payload['status'] ?? '');

        if ($status === 'successful') {
            $payment->update(['status' => 'completed', 'paid_at' => now(), 'gateway_response' => $payload]);
            $payment->booking->update(['payment_status' => 'paid', 'status' => 'confirmed', 'confirmed_at' => now()]);
        } else {
            $payment->update(['status' => 'failed', 'gateway_response' => $payload]);
        }
    }

    private function getAccessToken(): string
    {
        $response = Http::withBasicAuth(
            config('services.momo.collection_user_id'),
            config('services.momo.collection_api_key')
        )->withHeaders([
            'Ocp-Apim-Subscription-Key' => config('services.momo.collection_subscription_key'),
        ])->post(config('services.momo.base_url') . '/collection/token/');

        return $response->json('access_token', '');
    }
}
