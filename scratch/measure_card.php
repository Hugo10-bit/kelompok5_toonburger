<?php
$img = imagecreatefrompng('C:/Users/ASUS/.gemini/antigravity-ide/brain/81d88053-2eb5-41da-9be9-6f08a63dd5c6/.user_uploaded/media_1792999772746.png');
// Find bounds of the yellow box in Card 1
$minX = 1000; $maxX = 0; $minY = 1000; $maxY = 0;
for ($y = 150; $y < 300; $y++) {
    for ($x = 40; $x < 200; $x++) {
        $rgb = imagecolorat($img, $x, $y);
        $r = ($rgb >> 16) & 0xFF;
        $g = ($rgb >> 8) & 0xFF;
        $b = $rgb & 0xFF;
        // Check if color is close to yellow (RGB: ~252, ~197, ~24)
        if ($r > 230 && $g > 180 && $b < 60) {
            if ($x < $minX) $minX = $x;
            if ($x > $maxX) $maxX = $x;
            if ($y < $minY) $minY = $y;
            if ($y > $maxY) $maxY = $y;
        }
    }
}
$w = $maxX - $minX;
$h = $maxY - $minY;
echo "Card 1 Yellow box: x=$minX..$maxX (w=$w), y=$minY..$maxY (h=$h), ratio=" . round($w/$h, 2) . "\n";

// Let's also check Card 1 outer white card bounds
$cardMinX = 1000; $cardMaxX = 0; $cardMinY = 1000; $cardMaxY = 0;
for ($y = 140; $y < 370; $y++) {
    for ($x = 30; $x < 200; $x++) {
        $rgb = imagecolorat($img, $x, $y);
        $r = ($rgb >> 16) & 0xFF;
        $g = ($rgb >> 8) & 0xFF;
        $b = $rgb & 0xFF;
        if ($r > 250 && $g > 250 && $b > 250) { // white card background
            if ($x < $cardMinX) $cardMinX = $x;
            if ($x > $cardMaxX) $cardMaxX = $x;
            if ($y < $cardMinY) $cardMinY = $y;
            if ($y > $cardMaxY) $cardMaxY = $y;
        }
    }
}
$cw = $cardMaxX - $cardMinX;
$ch = $cardMaxY - $cardMinY;
echo "Card 1 White card: x=$cardMinX..$cardMaxX (w=$cw), y=$cardMinY..$cardMaxY (h=$ch)\n";
