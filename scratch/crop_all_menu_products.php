<?php
$dir = 'C:/Users/ASUS/.gemini/antigravity-ide/brain/81d88053-2eb5-41da-9be9-6f08a63dd5c6/.user_uploaded/';

$products = [
    [
        'id' => 1,
        'slug' => 'very-cheese-burger',
        'file' => 'media_1793000060721.jpg', // VERY CHESEE
        'name' => 'Very Cheese Burger',
        'crop' => ['x' => 50, 'y' => 290, 'w' => 624, 'h' => 450],
        'bg' => '#F5C518'
    ],
    [
        'id' => 2,
        'slug' => 'cheese-chicken-burger',
        'file' => 'media_1793000060790.jpg', // CHESEE CHICKEN
        'name' => 'Cheese Chicken Burger',
        'crop' => ['x' => 10, 'y' => 290, 'w' => 704, 'h' => 450],
        'bg' => '#FDE2B8'
    ],
    [
        'id' => 3,
        'slug' => 'bbq-beef-burger',
        'file' => 'media_1793000060778.jpg', // BBQ BURGER
        'name' => 'BBQ Beef Burger',
        'crop' => ['x' => 50, 'y' => 270, 'w' => 624, 'h' => 470],
        'bg' => '#E60000'
    ],
    [
        'id' => 4,
        'slug' => 'double-cheese-burger',
        'file' => 'media_1793000060702.jpg', // DOUBLE CHESEE
        'name' => 'Double Cheese Burger',
        'crop' => ['x' => 50, 'y' => 290, 'w' => 624, 'h' => 450],
        'bg' => '#A7D79E'
    ],
    [
        'id' => 5,
        'slug' => 'regular-cheese-burger',
        'file' => 'media_1793000075987.jpg', // CHESEE BURGER (blue)
        'name' => 'Regular Cheese Burger',
        'crop' => ['x' => 30, 'y' => 290, 'w' => 664, 'h' => 450],
        'bg' => '#B9D7F9'
    ],
    [
        'id' => 6,
        'slug' => 'beef-burger',
        'file' => 'media_1793000060697.jpg', // BEEF BURGER (orange)
        'name' => 'Beef Burger',
        'crop' => ['x' => 20, 'y' => 280, 'w' => 684, 'h' => 460],
        'bg' => '#FB923C'
    ],
    [
        'id' => 7,
        'slug' => 'regular-chicken-burger',
        'file' => 'media_1792999790311.jpg', // CHICKEN BURGER (purple)
        'name' => 'Regular Chicken Burger',
        'crop' => ['x' => 30, 'y' => 320, 'w' => 664, 'h' => 450],
        'bg' => '#DDD6FE'
    ],
    [
        'id' => 8,
        'slug' => 'hot-chicken-burger',
        'file' => 'media_1792999790325.jpg', // HOT CHICKEN (pink)
        'name' => 'Hot Chicken Burger',
        'crop' => ['x' => 10, 'y' => 330, 'w' => 704, 'h' => 450],
        'bg' => '#FBCFE8'
    ],
    [
        'id' => 9,
        'slug' => 'classic-hotdog',
        'file' => 'media_1792999790189.jpg', // CLASIC HOTDOG
        'name' => 'Classic Hotdog',
        'crop' => ['x' => 30, 'y' => 280, 'w' => 664, 'h' => 490],
        'bg' => '#FED7AA'
    ],
    [
        'id' => 10,
        'slug' => 'meat-cheesy-hotdog',
        'file' => 'media_1792999790164.jpg', // MEAT CHESSY HOTDOG
        'name' => 'Meat Cheesy Hotdog',
        'crop' => ['x' => 30, 'y' => 280, 'w' => 664, 'h' => 490],
        'bg' => '#F5C518'
    ],
];

foreach ($products as $p) {
    $src = $dir . $p['file'];
    if (!file_exists($src)) {
        echo "Missing {$src}\n";
        continue;
    }
    $im = imagecreatefromjpeg($src);
    $c = $p['crop'];
    $dst = imagecreatetruecolor(400, 280);
    imagecopyresampled($dst, $im, 0, 0, $c['x'], $c['y'], 400, 280, $c['w'], $c['h']);
    $destFile = "public/images/products/{$p['slug']}.png";
    imagepng($dst, $destFile);
    imagedestroy($dst);
    imagedestroy($im);
    echo "Generated {$destFile}\n";
}
