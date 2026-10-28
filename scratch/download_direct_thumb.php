<?php
$url = 'https://www.figma.com/file/woYX2Mwm0t88Qh5Rhoqbfy/thumbnail?ver=thumbnails/841cb560-fbcf-4bc5-a023-00f3312ffd3f';
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$img = curl_exec($ch);
file_put_contents(__DIR__ . '/figma_direct_thumb.png', $img);
echo "Saved figma_direct_thumb.png, size: " . strlen($img) . " bytes\n";
$info = getimagesize(__DIR__ . '/figma_direct_thumb.png');
print_r($info);
