<?php
$url = 'https://www.figma.com/design/woYX2Mwm0t88Qh5Rhoqbfy/Toon-Burger-%7C-Kelompok-5';
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$html = curl_exec($ch);
echo "HTTP Status: " . curl_getinfo($ch, CURLINFO_HTTP_CODE) . "\n";
echo "HTML Length: " . strlen($html) . "\n";

preg_match_all('/<meta[^>]+>/i', $html, $matches);
foreach ($matches[0] as $meta) {
    echo $meta . "\n";
}

// Check for any embedded JSON or initial data
if (preg_match('/<script id="initial-state"[^>]*>(.*?)<\/script>/is', $html, $scriptMatch)) {
    echo "Found initial-state script tag!\n";
    file_put_contents(__DIR__ . '/figma_initial_state.json', $scriptMatch[1]);
}
if (preg_match_all('/"name"\s*:\s*"([^"]+)"/i', $html, $names)) {
    echo "Names found: " . count($names[1]) . "\n";
    print_r(array_slice(array_unique($names[1]), 0, 30));
}
