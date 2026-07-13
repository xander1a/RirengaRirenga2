<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TableReservation extends Model
{
    protected $fillable = [
        'reference', 'guest_name', 'guest_email', 'guest_phone',
        'date', 'time', 'party_size', 'special_requests', 'status', 'notes',
    ];

    protected $casts = ['date' => 'date'];

    public static function generateReference(): string
    {
        return 'TBL-' . strtoupper(substr(uniqid(), -6));
    }
}
