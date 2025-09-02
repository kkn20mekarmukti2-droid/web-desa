<?php
// Simple debug script
echo "Debug Edit Page\n";

// Check if we can access the URL directly
$url = "http://localhost/web-desa/admin/struktur-pemerintahan/1/edit";

$context = stream_context_create([
    'http' => [
        'method' => 'GET',
        'timeout' => 10,
        'ignore_errors' => true
    ]
]);

echo "Trying to access: $url\n";

$response = file_get_contents($url, false, $context);

if ($response === false) {
    echo "Failed to access URL\n";
    $headers = $http_response_header ?? ['No headers available'];
    foreach ($headers as $header) {
        echo "Header: $header\n";
    }
} else {
    echo "Response length: " . strlen($response) . " characters\n";
    if (strlen($response) < 100) {
        echo "Response content:\n$response\n";
    } else {
        echo "First 200 characters:\n" . substr($response, 0, 200) . "\n...\n";
        echo "Last 200 characters:\n..." . substr($response, -200) . "\n";
    }
    
    // Check for common error patterns
    if (strpos($response, 'error') !== false || strpos($response, 'Error') !== false) {
        echo "Found error in response!\n";
    }
    
    if (strpos($response, '<title>') !== false) {
        preg_match('/<title>(.*?)<\/title>/', $response, $matches);
        if ($matches) {
            echo "Page title: " . $matches[1] . "\n";
        }
    }
}
?>
