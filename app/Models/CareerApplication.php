<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CareerApplication extends Model
{
    protected $fillable = [
        'career_position_id', 'name', 'email', 'phone', 'cover_letter', 'cv_path', 'status',
    ];

    public function position()
    {
        return $this->belongsTo(CareerPosition::class, 'career_position_id');
    }
}
