<?php
$data = json_decode(file_get_contents(__DIR__ . '/figma_script_3.js'), true);
echo "EARLY_ARGS:\n";
print_r($data['EARLY_ARGS']);
