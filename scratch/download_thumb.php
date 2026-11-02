<?php

$url = 'https://api-cdn.figma.com/resize/thumbnails/841cb560-fbcf-4bc5-a023-00f3312ffd3f?expiration=1793577600&signature=475b2839e665472bf1cf3546187e1f3dcb655f49b8d97489528c2559867a1fe4&height=450&bucket=figma-alpha';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_TIMEOUT, 20);
$data = curl_exec($ch);
curl_close($ch);

if ($data) {
    file_put_contents(__DIR__ . '/figma_oembed_thumb.png', $data);
    echo "Saved " . strlen($data) . " bytes\n";
} else {
    echo "Failed to download\n";
}
