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
    
    // Sample background color from top-left (e.g. x=30, y=30)
    $bgRgb = imagecolorat($im, 30, 30);
    $bgR = ($bgRgb >> 16) & 0xFF;
    $bgG = ($bgRgb >> 8) & 0xFF;
    $bgB = $bgRgb & 0xFF;
    
    // Find where the burger starts and ends (between y=180 and y=850)
    // The title is in y=50..220, subtitle is in y=850..950
    // In y=230..840, find bounding box of non-background pixels
    $minX = $w; $maxX = 0; $minY = $h; $maxY = 0;
    for ($y = 220; $y < 850; $y += 2) {
        for ($x = 20; $x < $w - 20; $x += 2) {
            $rgb = imagecolorat($im, $x, $y);
            $r = ($rgb >> 16) & 0xFF;
            $g = ($rgb >> 8) & 0xFF;
            $b = $rgb & 0xFF;
            // Difference from background color
            $diff = abs($r - $bgR) + abs($g - $bgG) + abs($b - $bgB);
            if ($diff > 35) {
                if ($x < $minX) $minX = $x;
                if ($x > $maxX) $maxX = $x;
                if ($y < $minY) $minY = $y;
                if ($y > $maxY) $maxY = $y;
            }
        }
    }
    $bw = $maxX - $minX;
    $bh = $maxY - $minY;
    echo "$name: Burger bbox x=$minX..$maxX (w=$bw), y=$minY..$maxY (h=$bh), center=(" . round(($minX+$maxX)/2) . ", " . round(($minY+$maxY)/2) . ")\n";
    imagedestroy($im);
}
