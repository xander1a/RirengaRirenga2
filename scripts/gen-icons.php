<?php
function makeIcon(int $size, string $path): void
{
    $im = imagecreatetruecolor($size, $size);
    $forest = imagecolorallocate($im, 0x2E, 0x46, 0x36);
    $gold = imagecolorallocate($im, 0xC9, 0xA2, 0x4B);
    imagefilledrectangle($im, 0, 0, $size, $size, $forest);

    $fontSize = (int) ($size * 0.45);
    $text = 'B';
    $useTtf = file_exists(__DIR__ . '/../public/fonts/arial.ttf');

    if ($useTtf) {
        $bbox = imagettfbbox($fontSize, 0, __DIR__ . '/../public/fonts/arial.ttf', $text);
        $textWidth = $bbox[2] - $bbox[0];
        $textHeight = $bbox[1] - $bbox[7];
        $x = (int) (($size - $textWidth) / 2);
        $y = (int) (($size + $textHeight) / 2);
        imagettftext($im, $fontSize, 0, $x, $y, $gold, __DIR__ . '/../public/fonts/arial.ttf', $text);
    } else {
        $font = 5;
        $charW = imagefontwidth($font);
        $charH = imagefontheight($font);
        $scale = $size / 64;
        $tmp = imagecreatetruecolor($charW, $charH);
        imagefilledrectangle($tmp, 0, 0, $charW, $charH, $forest);
        $tmpGold = imagecolorallocate($tmp, 0xC9, 0xA2, 0x4B);
        imagestring($tmp, $font, 0, 0, $text, $tmpGold);
        imagecopyresampled($im, $tmp, (int) ($size / 2 - ($charW * $scale) / 2), (int) ($size / 2 - ($charH * $scale) / 2), 0, 0, (int) ($charW * $scale), (int) ($charH * $scale), $charW, $charH);
        imagedestroy($tmp);
    }

    imagepng($im, $path);
    imagedestroy($im);
}

makeIcon(192, __DIR__ . '/../public/icons/icon-192.png');
makeIcon(512, __DIR__ . '/../public/icons/icon-512.png');
echo "Icons generated.\n";
