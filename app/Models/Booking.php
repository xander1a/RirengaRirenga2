<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Booking extends Model
{
    protected $fillable = [
        'reference', 'user_id', 'room_id', 'check_in', 'check_out',
        'guests', 'guest_name', 'guest_email', 'guest_phone',
        'price_per_night', 'total_amount', 'status', 'payment_status',
        'payment_method', 'payment_reference', 'special_requests', 'notes',
        'confirmed_at', 'cancelled_at',
    ];

    protected $casts = [
        'check_in' => 'date',
        'check_out' => 'date',
        'confirmed_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'price_per_night' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function getNightsAttribute(): int
    {
        return $this->check_in->diffInDays($this->check_out);
    }

    public static function generateReference(): string
    {
        $year = date('Y');
        $count = self::whereYear('created_at', $year)->count() + 1;
        return 'BYZ-' . $year . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }
}
