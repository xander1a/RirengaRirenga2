@extends('layouts.public')

@section('title', 'Payment')

@section('content')
<section class="px-4 py-20 sm:py-24" style="background-color:#1E3A4A;">
    <div class="max-w-2xl mx-auto">
        <h1 class="ed-title ed-title--light" style="font-size:clamp(2.25rem,5vw,3.25rem);">Choose Payment Method</h1>
    </div>
</section>

<section class="py-24 px-4">
    <div class="max-w-2xl mx-auto">
        {{-- Summary --}}
        <div class="p-7 mb-8" style="background:#EFE9DC;border-radius:2px;">
            <h3 class="ed-kicker mb-4">Booking Summary</h3>
            <div class="text-sm text-gray-700 space-y-2">
                <div class="flex justify-between"><span class="text-gray-500">Room</span><span class="font-medium">{{ $roomType->name }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Guest</span><span class="font-medium">{{ $draft['guest_name'] }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Check-in</span><span class="font-medium">{{ \Carbon\Carbon::parse($draft['check_in'])->format('d M Y') }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Check-out</span><span class="font-medium">{{ \Carbon\Carbon::parse($draft['check_out'])->format('d M Y') }}</span></div>
                <div class="flex justify-between text-base font-bold mt-3 pt-3" style="border-top:1px solid rgba(34,32,29,0.15);">
                    <span>Total</span><span class="font-display" style="color:#C99A52;">{{ money($draft['total_amount'], $draft['currency'] ?? 'RWF') }}</span>
                </div>
            </div>
        </div>

        <form action="{{ route('booking.payment.process') }}" method="POST" x-data="{ method: '' }">
            @csrf
            @php
                $methods = [
                    ['value'=>'paypack','icon'=>'banknotes','iconbg'=>'#D07A5415','iconcolor'=>'#D07A54','title'=>'Mobile Money (Paypack)','desc'=>"Pay with MTN or Airtel mobile money. You'll receive a payment prompt on your phone."],
                    ['value'=>'bank_transfer','icon'=>'building','iconbg'=>'#1E3A4A15','iconcolor'=>'#1E3A4A','title'=>'Bank Transfer','desc'=>'Transfer to our account and upload proof. Staff will confirm manually.'],
                    ['value'=>'card','icon'=>'archive','iconbg'=>'#C99A5215','iconcolor'=>'#C99A52','title'=>'Credit / Debit Card','desc'=>'Secure card payment via Flutterwave.'],
                    ['value'=>'pay_on_arrival','icon'=>'check','iconbg'=>'#3F7C8A15','iconcolor'=>'#3F7C8A','title'=>'Pay on Arrival','desc'=>'Reserve now, pay when you check in. Subject to availability confirmation.'],
                ];
            @endphp
            <div class="space-y-3 mb-6">
                @foreach($methods as $m)
                <label class="flex items-center gap-4 p-5 cursor-pointer transition"
                       style="border-radius:2px;"
                       :style="method === '{{ $m['value'] }}' ? 'border:1px solid #D07A54;background:#D07A540a;' : 'border:1px solid rgba(34,32,29,0.14);background:#fff;'">
                    <input type="radio" name="payment_method" value="{{ $m['value'] }}" x-model="method" class="hidden">
                    <div class="w-11 h-11 rounded-full flex items-center justify-center shrink-0" style="background:{{ $m['iconbg'] }};">
                        <x-admin-icon name="{{ $m['icon'] }}" class="w-5 h-5" style="color:{{ $m['iconcolor'] }};" />
                    </div>
                    <div>
                        <p class="font-display font-bold" style="color:#22201D;">{{ $m['title'] }}</p>
                        <p class="text-sm text-gray-500">{{ $m['desc'] }}</p>
                    </div>
                    <div class="ml-auto w-5 h-5 rounded-full border flex items-center justify-center"
                         :style="method === '{{ $m['value'] }}' ? 'border-color:#D07A54;' : 'border-color:#cbd5e1;'">
                        <div x-show="method === '{{ $m['value'] }}'" class="w-2.5 h-2.5 rounded-full" style="background:#D07A54;"></div>
                    </div>
                </label>
                @if($m['value'] === 'paypack')
                <div x-show="method === 'paypack'" x-transition class="px-5 pt-1 pb-2">
                    <label class="block text-[0.7rem] font-semibold uppercase tracking-wider text-gray-500 mb-1.5">Mobile Money Phone Number *</label>
                    <input type="tel" name="phone" placeholder="078xxxxxxx" value="{{ old('phone', $draft['guest_phone'] ?? '') }}"
                           class="w-full border border-gray-200 px-4 py-3 focus:outline-none focus:border-[#D07A54]" style="border-radius:2px;">
                </div>
                @endif
                @endforeach
            </div>

            {{-- Bank details (shown when bank_transfer selected) --}}
            <div x-show="method === 'bank_transfer'" x-cloak class="p-5 mb-6 text-sm" style="background:#EFE9DC;border-radius:2px;">
                <p class="ed-kicker mb-3">Bank Transfer Details</p>
                <p>Bank: <strong>Bank of Kigali</strong></p>
                <p>Account Name: <strong>Rirenga</strong></p>
                <p>Account Number: <strong>TODO: Add account number</strong></p>
                <p>SWIFT/BIC: <strong>TODO: Add SWIFT code</strong></p>
                <p class="mt-2 text-gray-500">Please use your booking reference as the payment description. Email proof to izubatreat@gmail.com.</p>
            </div>

            @if($errors->any())
            <div class="text-sm text-red-600 mb-4">{{ $errors->first() }}</div>
            @endif

            <button type="submit" :disabled="!method"
                    class="ed-btn ed-btn-solid w-full disabled:opacity-40" style="padding-top:1.1rem;padding-bottom:1.1rem;">
                Confirm Booking
            </button>
            <p class="text-xs text-center text-gray-400 mt-3">By confirming you agree to our cancellation and booking policy.</p>
        </form>
    </div>
</section>
@endsection
