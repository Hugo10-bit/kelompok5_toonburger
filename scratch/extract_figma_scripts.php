<?php
$html = file_get_contents(__DIR__ . '/figma_initial_state.json');
if (!$html) {
    // If initial_state wasn't captured, grab from the curl request directly
    $url = 'https://www.figma.com/design/woYX2Mwm0t88Qh5Rhoqbfy/Toon-Burger-%7C-Kelompok-5';
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $html = curl_exec($ch);
}

// Search for scripts or JSON
preg_match_all('/<script[^>]*>(.*?)<\/script>/is', $html, $scripts);
echo "Total script tags: " . count($scripts[0]) . "\n";

foreach ($scripts[1] as $idx => $scriptContent) {
    $len = strlen($scriptContent);
    echo "Script #$idx len: $len\n";
    if ($len > 1000) {
        // Let's see what this large script contains
        $sample = substr($scriptContent, 0, 300);
        echo "Sample #$idx: " . $sample . "\n";
        file_put_contents(__DIR__ . "/figma_script_$idx.js", $scriptContent);
    }
}
