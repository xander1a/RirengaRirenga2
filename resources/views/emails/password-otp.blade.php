<!DOCTYPE html>
<html>
<body style="margin:0;padding:0;background-color:#F9F6EF;font-family:Arial,Helvetica,sans-serif;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="padding:32px 16px;">
        <tr><td align="center">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:480px;background:#ffffff;border-radius:16px;overflow:hidden;">
                <tr>
                    <td style="background-color:#1E3A4A;padding:24px;text-align:center;">
                        <span style="font-size:22px;font-weight:bold;color:#ffffff;">Rirenga <span style="color:#C99A52;">Eco-Lodge</span></span>
                    </td>
                </tr>
                <tr>
                    <td style="padding:32px;">
                        <p style="margin:0 0 8px;color:#22201D;font-size:16px;">Hello {{ $userName }},</p>
                        <p style="margin:0 0 24px;color:#555;font-size:14px;line-height:1.6;">
                            Use the code below to reset your password. It expires in <strong>10 minutes</strong>.
                        </p>
                        <p style="margin:0 0 24px;text-align:center;">
                            <span style="display:inline-block;background:#EFE9DC;color:#1E3A4A;font-size:32px;font-weight:bold;letter-spacing:8px;padding:14px 28px;border-radius:12px;">{{ $otp }}</span>
                        </p>
                        <p style="margin:0;color:#999;font-size:12px;line-height:1.6;">
                            If you didn't request a password reset, you can safely ignore this email — your password will not change.
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
