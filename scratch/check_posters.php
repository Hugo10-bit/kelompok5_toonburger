<?php
$dir = 'C:/Users/ASUS/.gemini/antigravity-ide/brain/81d88053-2eb5-41da-9be9-6f08a63dd5c6/.user_uploaded/';
$files = glob($dir . 'media_1793000060*.jpg');

foreach ($files as $idx => $path) {
    $f = basename($path);
    $im = imagecreatefromjpeg($path);
    $w = imagesx($im);
    $h = imagesy($im);
    
    // Save preview
    $thumb = imagecreatetruecolor(300, intval(300 * $h / $w));
    imagecopyresampled($thumb, $im, 0, 0, 0, 0, 300, intval(300 * $h / $w), $w, $h);
    imagepng($thumb, __DIR__ . "/poster_thumb_$idx.png");
    imagedestroy($thumb);
    imagedestroy($im);
    echo "Saved poster_thumb_$idx.png for $f\n";
}
