<?php
// Test localhost access
$url = "http://127.0.0.1:8000/admin/struktur-pemerintahan/1/edit";

echo "Testing: $url\n";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
]);

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
        // Split headers and body
        $parts = explode("\r\n\r\n", $response, 2);
        $headers = $parts[0];
        $body = $parts[1] ?? '';
        
        echo "Content length: " . strlen($body) . "\n";
        
        if (strlen($body) < 500) {
            echo "Full response:\n$body\n";
        } else {
            echo "First 200 chars:\n" . substr($body, 0, 200) . "\n...\n";
            
            // Check for specific content
            if (strpos($body, 'Edit Struktur') !== false) {
                echo "✓ Found edit title\n";
            }
            if (strpos($body, 'form') !== false) {
                echo "✓ Found form\n";
            }
            if (strpos($body, 'error') !== false || strpos($body, 'Error') !== false) {
                echo "⚠ Found error in response\n";
            }
        }
    } else {
        echo "HTTP Error Code: $httpCode\n";
        echo "Response:\n$response\n";
    }
}
?>
