<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Booking $booking)
    {
    }

    public function envelope(): Envelope
    {
        $subject = match ($this->booking->status) {
            'confirmed' => 'Your booking is confirmed — '.$this->booking->reference,
            'cancelled' => 'Your booking has been declined — '.$this->booking->reference,
            default     => 'Booking update — '.$this->booking->reference,
        };

        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(view: 'emails.booking-status');
    }
}
