<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; color: #2B2A28; background: #F1E9D7; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 0 auto; background: #fff; border-radius: 16px; overflow: hidden; }
        .header { background: #2E4636; padding: 32px; text-align: center; }
        .header h1 { color: #fff; font-size: 24px; margin: 0; }
        .header p { color: rgba(255,255,255,0.7); margin: 8px 0 0; }
        .body { padding: 32px; }
        .row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #eee; font-size: 14px; }
        .label { color: #999; }
        .value { font-weight: 600; }
        .total { font-size: 18px; font-weight: bold; color: #C9A24B; }
        .cta { text-align: center; margin: 24px 0; }
        .btn { display: inline-block; background: #BF6B47; color: #fff; padding: 12px 28px; border-radius: 12px; text-decoration: none; font-weight: bold; }
        .footer { background: #2E4636; padding: 20px; text-align: center; color: rgba(255,255,255,0.5); font-size: 12px; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>BYIZA Eco-lodge</h1>
        <p>Booking Confirmation</p>
    </div>
    <div class="body">
        <p>Dear <strong>{{ $booking->guest_name }}</strong>,</p>
        <p>Thank you for booking with BYIZA Eco-lodge. We look forward to welcoming you!</p>

        <div class="row"><span class="label">Reference</span><span class="value">{{ $booking->reference }}</span></div>
        <div class="row"><span class="label">Room</span><span class="value">{{ $booking->room->roomType->name ?? 'Room' }}</span></div>
        <div class="row"><span class="label">Check-in</span><span class="value">{{ $booking->check_in->format('l, d M Y') }}</span></div>
        <div class="row"><span class="label">Check-out</span><span class="value">{{ $booking->check_out->format('l, d M Y') }}</span></div>
        <div class="row"><span class="label">Nights</span><span class="value">{{ $booking->nights }}</span></div>
        <div class="row"><span class="label">Guests</span><span class="value">{{ $booking->guests }}</span></div>
        <div class="row"><span class="label">Includes</span><span class="value">✓ Dinner & Breakfast daily</span></div>
        <div class="row"><span class="label">Total Amount</span><span class="value total">{{ frw($booking->total_amount, 2) }}</span></div>
        <div class="row"><span class="label">Payment Method</span><span class="value capitalize">{{ str_replace('_',' ',$booking->payment_method ?? '') }}</span></div>
        <div class="row"><span class="label">Payment Status</span><span class="value capitalize">{{ str_replace('_',' ',$booking->payment_status) }}</span></div>

        @if($booking->payment_method === 'bank_transfer')
        <div style="background:#F1E9D7;padding:16px;border-radius:12px;margin-top:20px;font-size:13px;">
            <strong>Bank Transfer Instructions:</strong><br>
            Bank: Bank of Kigali<br>
            Account: BYIZA Eco-lodge Ltd (TODO: add account)<br>
            Reference: <strong>{{ $booking->reference }}</strong><br>
            Email proof to info@byizaecolodge.com
        </div>
        @endif

        <div class="cta">
            <a class="btn" href="{{ url('/booking/confirmation/'.$booking->reference) }}">View Booking</a>
        </div>

        <p style="font-size:13px;color:#999;">Questions? Email us at info@byizaecolodge.com or call +250 788 000 000.</p>
    </div>
    <div class="footer">
        &copy; {{ date('Y') }} BYIZA Eco-lodge — Rwanda
    </div>
</div>
</body>
</html>
