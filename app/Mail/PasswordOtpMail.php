<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PasswordOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public string $otp, public string $userName)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Your Rirenga Eco-Lodge password reset code');
    }

    public function content(): Content
    {
        return new Content(view: 'emails.password-otp');
    }
}
