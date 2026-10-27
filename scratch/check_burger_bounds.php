<?php
$dir = 'C:/Users/ASUS/.gemini/antigravity-ide/brain/81d88053-2eb5-41da-9be9-6f08a63dd5c6/.user_uploaded/';

$posters = [
    'very-cheese' => 'media_1793000060721.jpg',
    'cheese-chicken' => 'media_1793000060790.jpg',
    'bbq-beef' => 'media_1793000060778.jpg',
    'double-cheese' => 'media_1793000060702.jpg',
    'regular-cheese' => 'media_1793000075987.jpg',
    'beef-burger' => 'media_1793000060697.jpg',
    'regular-chicken' => 'media_1792999790311.jpg',
    'hot-chicken' => 'media_1792999790325.jpg',
    'classic-hotdog' => 'media_1792999790189.jpg',
    'meat-cheesy-hotdog' => 'media_1792999790164.jpg',
];

foreach ($posters as $name => $file) {
    $src = $dir . $file;
    $im = imagecreatefromjpeg($src);
    $w = imagesx($im);
    $h = imagesy($im);
    
    $bgRgb = imagecolorat($im, 30, 30);
    $bgR = ($bgRgb >> 16) & 0xFF;
    $bgG = ($bgRgb >> 8) & 0xFF;
    $bgB = $bgRgb & 0xFF;
    
    // Scan starting from y=250 downwards to find burger top
    $burgerTop = 0;
    for ($y = 250; $y < 500; $y++) {
        for ($x = 100; $x < $w - 100; $x += 2) {
            $rgb = imagecolorat($im, $x, $y);
            $r = ($rgb >> 16) & 0xFF;
            $g = ($rgb >> 8) & 0xFF;
            $b = $rgb & 0xFF;
            if (abs($r-$bgR) + abs($g-$bgG) + abs($b-$bgB) > 40) {
                $burgerTop = $y;
                break 2;
            }
        }
    }
    
    // Scan from y=850 upwards to find burger bottom
    $burgerBottom = 0;
    for ($y = 850; $y > 600; $y--) {
        for ($x = 100; $x < $w - 100; $x += 2) {
            $rgb = imagecolorat($im, $x, $y);
            $r = ($rgb >> 16) & 0xFF;
            $g = ($rgb >> 8) & 0xFF;
            $b = $rgb & 0xFF;
            if (abs($r-$bgR) + abs($g-$bgG) + abs($b-$bgB) > 40) {
                $burgerBottom = $y;
                break 2;
            }
        }
    }
    
    $bh = $burgerBottom - $burgerTop;
    echo "$name: Burger Top = $burgerTop, Bottom = $burgerBottom (height = $bh)\n";
    imagedestroy($im);
}
