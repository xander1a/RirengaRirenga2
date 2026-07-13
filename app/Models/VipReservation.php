<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VipReservation extends Model
{
    protected $fillable = [
        'reference', 'guest_name', 'guest_email', 'guest_phone',
        'date', 'time', 'party_size', 'requests', 'status', 'notes',
    ];

    protected $casts = ['date' => 'date'];

    public static function generateReference(): string
    {
        return 'VIP-' . strtoupper(substr(uniqid(), -6));
    }
}
