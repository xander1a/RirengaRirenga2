<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarPromotion extends Model
{
    protected $fillable = [
        'title', 'title_fr', 'description', 'description_fr',
        'image', 'valid_from', 'valid_until', 'is_active',
    ];

    protected $casts = [
        'valid_from' => 'date',
        'valid_until' => 'date',
        'is_active' => 'boolean',
    ];
}
