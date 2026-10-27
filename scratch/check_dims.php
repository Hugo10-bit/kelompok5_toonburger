<?php
$files = [
    'very-cheese-burger.png',
    'cheese-chicken-burger.png',
    'bbq-beef-burger.png',
    'double-cheese-burger.png',
    'regular-cheese-burger.png',
    'beef-burger.png',
    'regular-chicken-burger.png',
    'hot-chicken-burger.png',
    'classic-hotdog.png',
    'meat-cheesy-hotdog.png',
];

foreach ($files as $f) {
    $path = __DIR__ . '/../public/images/products/' . $f;
    if (file_exists($path)) {
        $info = getimagesize($path);
        echo "$f: {$info[0]}x{$info[1]} (ratio " . round($info[0]/$info[1], 2) . ")\n";
    } else {
        echo "$f: MISSING!\n";
    }
}
