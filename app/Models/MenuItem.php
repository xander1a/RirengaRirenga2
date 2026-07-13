<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $fillable = [
        'menu_category_id', 'name', 'name_fr', 'description', 'description_fr',
        'price', 'image', 'is_available', 'sort_order',
    ];

    protected $casts = [
        'is_available' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function category()
    {
        return $this->belongsTo(MenuCategory::class, 'menu_category_id');
    }

    public function getLocalNameAttribute(): string
    {
        $locale = app()->getLocale();
        return ($locale === 'fr' && $this->name_fr) ? $this->name_fr : $this->name;
    }

    public function getLocalDescriptionAttribute(): ?string
    {
        $locale = app()->getLocale();
        return ($locale === 'fr' && $this->description_fr) ? $this->description_fr : $this->description;
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? \Illuminate\Support\Facades\Storage::disk('public')->url($this->image) : null;
    }
}
