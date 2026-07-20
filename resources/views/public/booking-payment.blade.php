@extends('layouts.public')

@section('title', 'Payment')

@section('content')
<section class="py-16 px-4" style="background-color:#2E4636;">
    <div class="max-w-7xl mx-auto text-center text-white">
        <h1 class="font-display text-4xl font-bold">Choose Payment Method</h1>
    </div>
</section>

<section class="py-16 px-4">
    <div class="max-w-2xl mx-auto">
        {{-- Summary --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm mb-6">
            <h3 class="font-semibold mb-3" style="color:#2E4636;">Booking Summary</h3>
            <div class="text-sm text-gray-600 space-y-1">
                <div class="flex justify-between"><span>Room:</span><span class="font-medium">{{ $roomType->name }}</span></div>
                <div class="flex justify-between"><span>Guest:</span><span class="font-medium">{{ $draft['guest_name'] }}</span></div>
                <div class="flex justify-between"><span>Check-in:</span><span class="font-medium">{{ \Carbon\Carbon::parse($draft['check_in'])->format('d M Y') }}</span></div>
                <div class="flex justify-between"><span>Check-out:</span><span class="font-medium">{{ \Carbon\Carbon::parse($draft['check_out'])->format('d M Y') }}</span></div>
                <div class="flex justify-between text-base font-bold mt-3 pt-3 border-t">
                    <span>Total:</span><span style="color:#C9A24B;">{{ money($draft['total_amount'], $draft['currency'] ?? 'RWF') }}</span>
                </div>
            </div>
        </div>

        <form action="{{ route('booking.payment.process') }}" method="POST" x-data="{ method: '' }">
            @csrf
            <div class="space-y-4 mb-6">
                {{-- Paypack --}}
                <label class="flex items-center gap-4 p-5 rounded-2xl border-2 cursor-pointer transition"
                       :class="method === 'paypack' ? 'border-terracotta bg-terracotta/5' : 'border-gray-200 bg-white'">
                    <input type="radio" name="payment_method" value="paypack" x-model="method" class="hidden">
                    <div class="w-11 h-11 rounded-full flex items-center justify-center shrink-0" style="background:#BF6B4715;">
                        <x-admin-icon name="banknotes" class="w-5 h-5" style="color:#BF6B47;" />
                    </div>
                    <div>
                        <p class="font-semibold">Mobile Money (Paypack)</p>
                        <p class="text-sm text-gray-500">Pay with MTN or Airtel mobile money. You'll receive a payment prompt on your phone.</p>
                    </div>
                    <div class="ml-auto w-5 h-5 rounded-full border-2 flex items-center justify-center"
                         :class="method === 'paypack' ? 'border-terracotta' : 'border-gray-300'">
                        <div x-show="method === 'paypack'" class="w-3 h-3 rounded-full" style="background:#BF6B47;"></div>
                    </div>
                </label>
                <div x-show="method === 'paypack'" x-transition class="-mt-2 px-5">
                    <label class="block text-sm font-medium mb-1">Mobile Money Phone Number *</label>
                    <input type="tel" name="phone" placeholder="078xxxxxxx" value="{{ old('phone', $draft['guest_phone'] ?? '') }}"
                           class="w-full rounded-xl border border-gray-200 px-4 py-3 focus:outline-none focus:ring-2" style="--tw-ring-color:#BF6B47;">
                </div>

                {{-- Bank Transfer --}}
                <label class="flex items-center gap-4 p-5 rounded-2xl border-2 cursor-pointer transition"
                       :class="method === 'bank_transfer' ? 'border-terracotta bg-terracotta/5' : 'border-gray-200 bg-white'">
                    <input type="radio" name="payment_method" value="bank_transfer" x-model="method" class="hidden">
                    <div class="w-11 h-11 rounded-full flex items-center justify-center shrink-0" style="background:#2E463615;">
                        <x-admin-icon name="building" class="w-5 h-5" style="color:#2E4636;" />
                    </div>
                    <div>
                        <p class="font-semibold">Bank Transfer</p>
                        <p class="text-sm text-gray-500">Transfer to our account and upload proof. Staff will confirm manually.</p>
                    </div>
                    <div class="ml-auto w-5 h-5 rounded-full border-2 flex items-center justify-center" :class="method === 'bank_transfer' ? 'border-terracotta' : 'border-gray-300'">
                        <div x-show="method === 'bank_transfer'" class="w-3 h-3 rounded-full" style="background:#BF6B47;"></div>
                    </div>
                </label>

                {{-- Card --}}
                <label class="flex items-center gap-4 p-5 rounded-2xl border-2 cursor-pointer transition"
                       :class="method === 'card' ? 'border-terracotta bg-terracotta/5' : 'border-gray-200 bg-white'">
                    <input type="radio" name="payment_method" value="card" x-model="method" class="hidden">
                    <div class="w-11 h-11 rounded-full flex items-center justify-center shrink-0" style="background:#C9A24B15;">
                        <x-admin-icon name="archive" class="w-5 h-5" style="color:#C9A24B;" />
                    </div>
                    <div>
                        <p class="font-semibold">Credit / Debit Card</p>
                        <p class="text-sm text-gray-500">Secure card payment via Flutterwave.</p>
                        {{-- TODO: activate when Flutterwave credentials are configured --}}
                    </div>
                    <div class="ml-auto w-5 h-5 rounded-full border-2 flex items-center justify-center" :class="method === 'card' ? 'border-terracotta' : 'border-gray-300'">
                        <div x-show="method === 'card'" class="w-3 h-3 rounded-full" style="background:#BF6B47;"></div>
                    </div>
                </label>

                {{-- Pay on Arrival --}}
                <label class="flex items-center gap-4 p-5 rounded-2xl border-2 cursor-pointer transition"
                       :class="method === 'pay_on_arrival' ? 'border-terracotta bg-terracotta/5' : 'border-gray-200 bg-white'">
                    <input type="radio" name="payment_method" value="pay_on_arrival" x-model="method" class="hidden">
                    <div class="w-11 h-11 rounded-full flex items-center justify-center shrink-0" style="background:#6E8C5A15;">
                        <x-admin-icon name="check" class="w-5 h-5" style="color:#6E8C5A;" />
                    </div>
                    <div>
                        <p class="font-semibold">Pay on Arrival</p>
                        <p class="text-sm text-gray-500">Reserve now, pay when you check in. Subject to availability confirmation.</p>
                    </div>
                    <div class="ml-auto w-5 h-5 rounded-full border-2 flex items-center justify-center" :class="method === 'pay_on_arrival' ? 'border-terracotta' : 'border-gray-300'">
                        <div x-show="method === 'pay_on_arrival'" class="w-3 h-3 rounded-full" style="background:#BF6B47;"></div>
                    </div>
                </label>
            </div>

            {{-- Bank details (shown when bank_transfer selected) --}}
            <div x-show="method === 'bank_transfer'" class="rounded-2xl p-5 mb-6 text-sm" style="background:#F1E9D7;">
                <p class="font-semibold mb-2" style="color:#2E4636;">Bank Transfer Details</p>
                <p>Bank: <strong>Bank of Kigali</strong></p>
                <p>Account Name: <strong>Byiza Lodge Ltd</strong></p>
                <p>Account Number: <strong>TODO: Add account number</strong></p>
                <p>SWIFT/BIC: <strong>TODO: Add SWIFT code</strong></p>
                <p class="mt-2 text-gray-500">Please use your booking reference as the payment description. Email proof to izubatreat@gmail.com.</p>
            </div>

            @if($errors->any())
            <div class="text-sm text-red-600 mb-4">{{ $errors->first() }}</div>
            @endif

            <button type="submit" :disabled="!method"
                    class="w-full py-4 rounded-xl text-white font-semibold text-lg transition hover:opacity-90 disabled:opacity-40"
                    style="background-color:#BF6B47;">
                Confirm Booking
            </button>
            <p class="text-xs text-center text-gray-400 mt-3">By confirming you agree to our cancellation and booking policy.</p>
        </form>
    </div>
</section>
@endsection
