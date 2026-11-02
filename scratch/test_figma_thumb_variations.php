<?php
$baseUrl = 'https://www.figma.com/file/woYX2Mwm0t88Qh5Rhoqbfy/thumbnail';
$variations = [
    'https://www.figma.com/file/woYX2Mwm0t88Qh5Rhoqbfy/thumbnail?scale=2',
    'https://www.figma.com/file/woYX2Mwm0t88Qh5Rhoqbfy/thumbnail?scale=4',
    'https://www.figma.com/file/woYX2Mwm0t88Qh5Rhoqbfy/thumbnail?width=1920',
    'https://www.figma.com/file/woYX2Mwm0t88Qh5Rhoqbfy/thumbnail?size=large',
    'https://s3-alpha-sig.figma.com/thumbnails/841cb560-fbcf-4bc5-a023-00f3312ffd3f',
];

foreach ($variations as $url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $type = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
    $len = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
    echo "$url => Code: $code, Type: $type, Len: $len\n";
}
