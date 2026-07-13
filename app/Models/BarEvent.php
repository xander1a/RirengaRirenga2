<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarEvent extends Model
{
    protected $fillable = [
        'title', 'title_fr', 'description', 'description_fr',
        'starts_at', 'ends_at', 'image', 'is_active',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function getLocalTitleAttribute(): string
    {
        $locale = app()->getLocale();
        return ($locale === 'fr' && $this->title_fr) ? $this->title_fr : $this->title;
    }
}
