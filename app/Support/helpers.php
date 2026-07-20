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

if (! function_exists('store_image')) {
    /**
     * Store an uploaded image on the public disk, resized and compressed
     * (max width 1920px, JPEG ~80%). Falls back to a plain store when GD
     * can't read the file. Returns the stored relative path.
     */
    function store_image(\Illuminate\Http\UploadedFile $file, string $dir, int $maxWidth = 1920, int $quality = 80): string
    {
        try {
            $src = @imagecreatefromstring(file_get_contents($file->getRealPath()));
            if ($src === false) {
                return $file->store($dir, 'public');
            }

            $width  = imagesx($src);
            $height = imagesy($src);

            if ($width > $maxWidth) {
                $newHeight = (int) round($height * $maxWidth / $width);
                $resized = imagecreatetruecolor($maxWidth, $newHeight);
                // flatten transparency onto white so PNGs convert cleanly to JPEG
                $white = imagecolorallocate($resized, 255, 255, 255);
                imagefill($resized, 0, 0, $white);
                imagecopyresampled($resized, $src, 0, 0, 0, 0, $maxWidth, $newHeight, $width, $height);
                imagedestroy($src);
                $src = $resized;
            }

            $path = trim($dir, '/').'/'.\Illuminate\Support\Str::random(40).'.jpg';
            $full = \Illuminate\Support\Facades\Storage::disk('public')->path($path);
            @mkdir(dirname($full), 0755, true);
            imagejpeg($src, $full, $quality);
            imagedestroy($src);

            return $path;
        } catch (\Throwable) {
            return $file->store($dir, 'public');
        }
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
