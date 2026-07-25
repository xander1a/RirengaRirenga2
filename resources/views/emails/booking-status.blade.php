<!DOCTYPE html>
<html>
<body style="margin:0;padding:0;background-color:#F9F6EF;font-family:Arial,Helvetica,sans-serif;">
    @php
        $confirmed = $booking->status === 'confirmed';
        $cancelled = $booking->status === 'cancelled';
        $color = $confirmed ? '#3F7C8A' : ($cancelled ? '#D07A54' : '#C99A52');
    @endphp
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="padding:32px 16px;">
        <tr><td align="center">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:520px;background:#ffffff;border-radius:16px;overflow:hidden;">
                <tr>
                    <td style="background-color:#1E3A4A;padding:24px;text-align:center;">
                        <span style="font-size:22px;font-weight:bold;color:#ffffff;">Rirenga <span style="color:#C99A52;">Eco-Lodge</span></span>
                    </td>
                </tr>
                <tr>
                    <td style="padding:32px;">
                        <p style="margin:0 0 8px;color:#22201D;font-size:16px;">Hello {{ $booking->guest_name }},</p>

                        @if($confirmed)
                        <p style="margin:0 0 20px;color:#555;font-size:14px;line-height:1.6;">
                            Great news — your booking has been <strong style="color:{{ $color }};">confirmed</strong>! We look forward to welcoming you.
                        </p>
                        @elseif($cancelled)
                        <p style="margin:0 0 20px;color:#555;font-size:14px;line-height:1.6;">
                            We're sorry — your booking has been <strong style="color:{{ $color }};">declined</strong>.
                        </p>
                        @else
                        <p style="margin:0 0 20px;color:#555;font-size:14px;line-height:1.6;">
                            Your booking status has been updated to <strong style="color:{{ $color }};">{{ str_replace('_',' ',$booking->status) }}</strong>.
                        </p>
                        @endif

                        @if($booking->status_reason)
                        <p style="margin:0 0 20px;padding:12px 16px;background:#F9F6EF;border-left:4px solid {{ $color }};color:#555;font-size:14px;line-height:1.6;border-radius:0 8px 8px 0;">
                            <strong>Note from the lodge:</strong><br>{{ $booking->status_reason }}
                        </p>
                        @endif

                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#F9F6EF;border-radius:12px;">
                            <tr><td style="padding:16px 20px;">
                                <p style="margin:0 0 6px;font-size:13px;color:#555;"><strong>Reference:</strong> {{ $booking->reference }}</p>
                                <p style="margin:0 0 6px;font-size:13px;color:#555;"><strong>Room:</strong> {{ $booking->room->roomType->name ?? 'Room' }} ({{ $booking->room->room_number ?? '' }})</p>
                                <p style="margin:0 0 6px;font-size:13px;color:#555;"><strong>Check-in:</strong> {{ $booking->check_in->format('d M Y') }}</p>
                                <p style="margin:0 0 6px;font-size:13px;color:#555;"><strong>Check-out:</strong> {{ $booking->check_out->format('d M Y') }}</p>
                                <p style="margin:0;font-size:13px;color:#555;"><strong>Total:</strong> {{ money($booking->total_amount, $booking->currency) }}</p>
                            </td></tr>
                        </table>

                        <p style="margin:24px 0 0;color:#999;font-size:12px;line-height:1.6;">
                            Questions? Just reply to this email and we'll help you out.
                        </p>
                    </td>
                </tr>
                <tr>
                    <td style="padding:16px;text-align:center;background:#F9F6EF;">
                        <span style="color:#999;font-size:11px;">© {{ date('Y') }} Rirenga · Rwanda</span>
                    </td>
                </tr>
            </table>
        </td></tr>
    </table>
</body>
</html>
