<?php
$url = "http://127.0.0.1:8001/admin/struktur-pemerintahan/1/edit";

echo "Testing: $url\n";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

if ($error) {
    echo "cURL Error: $error\n";
} else {
    echo "HTTP Code: $httpCode\n";
    echo "Response length: " . strlen($response) . "\n";
    
    if ($httpCode == 200) {
        // Check for key content
        if (strpos($response, 'Edit Struktur') !== false || strpos($response, 'Edit Aparatur') !== false) {
            echo "✓ Found edit title\n";
        }
        if (strpos($response, '<form') !== false) {
            echo "✓ Found form element\n";
        }
        if (strpos($response, 'admin-modern') !== false) {
            echo "✓ Using admin-modern layout\n";
        }
        if (strpos($response, 'struktur') !== false) {
            echo "✓ Found struktur context\n";
        }
        
        // Show first bit to verify content
        echo "\nFirst 300 characters:\n";
        echo substr($response, 0, 300) . "...\n";
        
    } else {
        echo "HTTP Error: $httpCode\n";
        echo "Response: " . substr($response, 0, 500) . "\n";
    }
}
?>
