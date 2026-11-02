<?php
$data = file_get_contents(__DIR__ . '/figma_direct_thumb.png');
$im = imagecreatefromstring($data);
if (!$im) {
    die("Failed to load image");
}

$width = imagesx($im);
$height = imagesy($im);
echo "Image dimensions: {$width}x{$height}\n";

// Let's crop into 4 distinct regions:
// Region 1: Color palette & left column (x: 130 to 240, y: 380 to 559)
// Region 2: Middle desktop frames (x: 240 to 350, y: 380 to 559)
// Region 3: Right green navbar pages (x: 350 to 500, y: 380 to 559)
// Region 4: Birthday card right side (x: 600 to 800, y: 350 to 559)

$regions = [
    'region1_palette_mobile' => ['x' => 130, 'y' => 380, 'width' => 120, 'height' => 170],
    'region2_desktop'        => ['x' => 240, 'y' => 380, 'width' => 120, 'height' => 170],
    'region3_green_navbar'   => ['x' => 340, 'y' => 380, 'width' => 150, 'height' => 170],
    'region_all_ui'          => ['x' => 130, 'y' => 380, 'width' => 360, 'height' => 179],
];

foreach ($regions as $name => $rect) {
    $cropped = imagecrop($im, $rect);
    if ($cropped) {
        // Let's also upscale it 4x with nearest neighbor or bilinear so we can inspect pixels
        $scaled = imagescale($cropped, $rect['width'] * 4, $rect['height'] * 4, IMG_NEAREST_NEIGHBOUR);
        imagepng($scaled, __DIR__ . "/{$name}.png");
        imagedestroy($cropped);
        imagedestroy($scaled);
        echo "Saved {$name}.png\n";
    }
}
