<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    protected $fillable = [
        'code', 'name', 'description', 'price_per_night',
        'max_guests', 'amenities', 'image', 'images', 'is_active',
    ];

    protected $casts = [
        'amenities' => 'array',
        'images' => 'array',
        'is_active' => 'boolean',
        'price_per_night' => 'decimal:2',
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function getImageUrlAttribute(): string
    {
        return $this->image ? \Illuminate\Support\Facades\Storage::disk('public')->url($this->image) : asset('images/room-placeholder.jpg');
    }
}
