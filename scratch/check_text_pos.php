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
    
    // Check top text: scan y from 0 to 350 to find where top text ends
    $topTextEnd = 0;
    for ($y = 50; $y < 350; $y++) {
        $hasText = false;
        for ($x = 50; $x < $w - 50; $x += 5) {
            $rgb = imagecolorat($im, $x, $y);
            $r = ($rgb >> 16) & 0xFF;
            $g = ($rgb >> 8) & 0xFF;
            $b = $rgb & 0xFF;
            if (abs($r-$bgR) + abs($g-$bgG) + abs($b-$bgB) > 40) {
                $hasText = true;
                break;
            }
        }
        if ($hasText && $y < 280) {
            $topTextEnd = $y;
        }
    }
    
    // Check bottom text: scan y from 1000 down to 750 to find where bottom text starts
    $bottomTextStart = 1000;
    for ($y = 980; $y > 750; $y--) {
        $hasText = false;
        for ($x = 50; $x < $w - 50; $x += 5) {
            $rgb = imagecolorat($im, $x, $y);
            $r = ($rgb >> 16) & 0xFF;
            $g = ($rgb >> 8) & 0xFF;
            $b = $rgb & 0xFF;
            if (abs($r-$bgR) + abs($g-$bgG) + abs($b-$bgB) > 40) {
                $hasText = true;
                break;
            }
        }
        if ($hasText && $y > 830) {
            $bottomTextStart = $y;
        }
    }
    
    echo "$name: Top text ends around y=$topTextEnd, Bottom text starts around y=$bottomTextStart\n";
    imagedestroy($im);
}
