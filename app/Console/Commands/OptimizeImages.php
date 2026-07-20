<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class OptimizeImages extends Command
{
    protected $signature = 'images:optimize {--max-width=1920} {--quality=80}';

    protected $description = 'Resize and compress all existing uploaded images in place (filenames unchanged)';

    public function handle(): int
    {
        $disk = Storage::disk('public');
        $maxWidth = (int) $this->option('max-width');
        $quality = (int) $this->option('quality');
        $done = 0;

        foreach ($disk->allFiles() as $file) {
            if (! preg_match('/\.(jpe?g|png|webp)$/i', $file)) {
                continue;
            }

            $full = $disk->path($file);
            $before = filesize($full);
            $src = @imagecreatefromstring(file_get_contents($full));
            if ($src === false) {
                $this->warn("skip (unreadable): $file");
                continue;
            }

            $width = imagesx($src);
            $height = imagesy($src);

            if ($width > $maxWidth) {
                $newHeight = (int) round($height * $maxWidth / $width);
                $resized = imagecreatetruecolor($maxWidth, $newHeight);
                $white = imagecolorallocate($resized, 255, 255, 255);
                imagefill($resized, 0, 0, $white);
                imagecopyresampled($resized, $src, 0, 0, 0, 0, $maxWidth, $newHeight, $width, $height);
                imagedestroy($src);
                $src = $resized;
            }

            // Re-save in the ORIGINAL format so stored paths stay valid.
            if (preg_match('/\.png$/i', $file)) {
                imagepng($src, $full, 8);
            } elseif (preg_match('/\.webp$/i', $file) && function_exists('imagewebp')) {
                imagewebp($src, $full, $quality);
            } else {
                imagejpeg($src, $full, $quality);
            }
            imagedestroy($src);
            clearstatcache(true, $full);

            $after = filesize($full);
            $this->line(sprintf('%s: %s -> %s', $file, $this->kb($before), $this->kb($after)));
            $done++;
        }

        $this->info("Optimized $done image(s).");

        return self::SUCCESS;
    }

    private function kb(int $bytes): string
    {
        return round($bytes / 1024).' KB';
    }
}
