<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    protected $fillable = ['key', 'value'];

    public static function get(string $key): ?string
    {
        return static::all_cached()[$key] ?? null;
    }

    public static function set(string $key, ?string $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget('site_settings');
    }

    public static function all_cached(): array
    {
        return Cache::rememberForever('site_settings', fn () => static::pluck('value', 'key')->all());
    }
}
