<?php
$dir = 'C:/Users/ASUS/.gemini/antigravity-ide/brain/81d88053-2eb5-41da-9be9-6f08a63dd5c6/.user_uploaded/';
$files = glob($dir . '*.jpg');
foreach ($files as $f) {
    $info = getimagesize($f);
    echo basename($f) . ": {$info[0]}x{$info[1]}\n";
}
