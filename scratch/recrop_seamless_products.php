<?php
$dir = 'C:/Users/ASUS/.gemini/antigravity-ide/brain/81d88053-2eb5-41da-9be9-6f08a63dd5c6/.user_uploaded/';

$products = [
    [
        'slug' => 'very-cheese-burger',
        'file' => 'media_1793000060721.jpg',
        'burger_top' => 308,
        'burger_bottom' => 779,
    ],
    [
        'slug' => 'cheese-chicken-burger',
        'file' => 'media_1793000060790.jpg',
        'burger_top' => 314,
        'burger_bottom' => 765,
    ],
    [
        'slug' => 'bbq-beef-burger',
        'file' => 'media_1793000060778.jpg',
        'burger_top' => 285,
        'burger_bottom' => 767,
    ],
    [
        'slug' => 'double-cheese-burger',
        'file' => 'media_1793000060702.jpg',
        'burger_top' => 315,
        'burger_bottom' => 809,
    ],
    [
        'slug' => 'regular-cheese-burger',
        'file' => 'media_1793000075987.jpg',
        'burger_top' => 310,
        'burger_bottom' => 793,
    ],
    [
        'slug' => 'beef-burger',
        'file' => 'media_1793000060697.jpg',
        'burger_top' => 301,
        'burger_bottom' => 771,
    ],
    [
        'slug' => 'regular-chicken-burger',
        'file' => 'media_1792999790311.jpg',
        'burger_top' => 344,
        'burger_bottom' => 808,
    ],
    [
        'slug' => 'hot-chicken-burger',
        'file' => 'media_1792999790325.jpg',
        'burger_top' => 356,
        'burger_bottom' => 800,
    ],
    [
        'slug' => 'classic-hotdog',
        'file' => 'media_1792999790189.jpg',
        'burger_top' => 313,
        'burger_bottom' => 824,
    ],
    [
        'slug' => 'meat-cheesy-hotdog',
        'file' => 'media_1792999790164.jpg',
        'burger_top' => 325,
        'burger_bottom' => 715,
    ],
];

// Target aspect ratio is 1.45 (e.g. 600x414)
$cropW = 724;
$cropH = 500; // 724 / 500 = 1.448

foreach ($products as $p) {
    $src = $dir . $p['file'];
    $im = imagecreatefromjpeg($src);
    
    $centerY = ($p['burger_top'] + $p['burger_bottom']) / 2;
    $cropY = round($centerY - ($cropH / 2));
    
    // Safety clamp between 245 and (880 - 500 = 380)
    if ($cropY < 245) $cropY = 245;
    if ($cropY > 380) $cropY = 380;
    
    echo "{$p['slug']}: crop at x=0, y=$cropY, w=$cropW, h=$cropH\n";
    
    // Output image size 600x414 for crisp high quality
    $dst = imagecreatetruecolor(600, 414);
    imagecopyresampled($dst, $im, 0, 0, 0, $cropY, 600, 414, $cropW, $cropH);
    
    $outPath = __DIR__ . '/../public/images/products/' . $p['slug'] . '.png';
    imagepng($dst, $outPath, 6);
    imagedestroy($dst);
    imagedestroy($im);
}
echo "All 10 seamless products successfully generated!\n";
