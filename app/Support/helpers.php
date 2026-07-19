<?php

if (! function_exists('frw')) {
    /**
     * Format an amount as Rwandan Francs, e.g. "12,000 RWF".
     * RWF has no commonly-used subunit, so amounts are always rounded to whole francs
     * regardless of the optional $decimals arg (kept for call-site compatibility).
     */
    function frw(float|int|string|null $amount, int $decimals = 0): string
    {
        return number_format((float) $amount, 0) . ' RWF';
    }
}

if (! function_exists('money')) {
    /**
     * Format an amount in the given currency: "12,000 RWF" or "$12.00".
     */
    function money(float|int|string|null $amount, ?string $currency = 'RWF'): string
    {
        return strtoupper($currency ?? 'RWF') === 'USD'
            ? '$' . number_format((float) $amount, 2)
            : number_format((float) $amount, 0) . ' RWF';
    }
}

if (! function_exists('site_image')) {
    /**
     * Public URL of an admin-managed site image slot, or null when not set.
     */
    function site_image(string $key): ?string
    {
        $path = \App\Models\SiteSetting::get('image.' . $key);

        return $path ? \Illuminate\Support\Facades\Storage::disk('public')->url($path) : null;
    }
}
