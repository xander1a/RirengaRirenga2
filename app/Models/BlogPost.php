<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    protected $fillable = [
        'user_id', 'title', 'title_fr', 'slug', 'excerpt', 'excerpt_fr',
        'body', 'body_fr', 'image', 'is_published', 'published_at',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? \Illuminate\Support\Facades\Storage::disk('public')->url($this->image) : null;
    }

    public function getLocalTitleAttribute(): string
    {
        $locale = app()->getLocale();
        return ($locale === 'fr' && $this->title_fr) ? $this->title_fr : $this->title;
    }
}
