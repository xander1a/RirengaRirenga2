<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CareerPosition extends Model
{
    protected $fillable = ['title', 'department', 'type', 'description', 'requirements', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function applications()
    {
        return $this->hasMany(CareerApplication::class);
    }
}
