<?php
$data = file_get_contents(__DIR__ . '/figma_script_3.js');
$json = json_decode($data, true);

if ($json) {
    echo "Top level keys in Script 3:\n";
    print_r(array_keys($json));
    
    // Check interesting keys
    foreach ($json as $k => $v) {
        if (is_array($v)) {
            echo "Key '$k' has subkeys: " . implode(', ', array_slice(array_keys($v), 0, 15)) . "\n";
        }
    }
} else {
    echo "Not valid JSON directly. Let's see prefix:\n";
    echo substr($data, 0, 500) . "\n";
}
