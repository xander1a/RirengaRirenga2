<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuCategory extends Model
{
    protected $fillable = ['name', 'name_fr', 'type', 'sort_order', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function items()
    {
        return $this->hasMany(MenuItem::class)->orderBy('sort_order');
    }

    public function getLocalNameAttribute(): string
    {
        $locale = app()->getLocale();
        return ($locale === 'fr' && $this->name_fr) ? $this->name_fr : $this->name;
    }
}
