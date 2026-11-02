<?php
// Test if oembed thumbnail changes if we provide different node-id
$testNodes = [
    '0-1',
    '1-2',
    '1-3',
    '1-4',
    '2-2',
    '2-3',
];

foreach ($testNodes as $node) {
    $target = "https://www.figma.com/design/woYX2Mwm0t88Qh5Rhoqbfy/Toon-Burger-%7C-Kelompok-5?node-id={$node}";
    $oembedUrl = "https://www.figma.com/api/oembed?url=" . urlencode($target);
    
    $ch = curl_init($oembedUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $res = curl_exec($ch);
    $json = json_decode($res, true);
    echo "Node {$node} => " . ($json['thumbnail_url'] ?? 'None') . "\n";
}
