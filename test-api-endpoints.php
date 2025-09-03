<?php
/**
 * Test Visitor Counter API Endpoints
 */

echo "🌐 === TESTING VISITOR API ENDPOINTS === 🌐\n\n";

// Test the API endpoints directly
$baseUrl = 'http://localhost/web-desa'; // Adjust to your actual URL

function testApiEndpoint($url, $description) {
    echo "Testing: {$description}\n";
    echo "URL: {$url}\n";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Accept: application/json',
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    
    if ($error) {
        echo "❌ CURL Error: {$error}\n";
        return false;
    }
    
    echo "HTTP Code: {$httpCode}\n";
    
    if ($httpCode == 200) {
        echo "✅ Response received\n";
        $data = json_decode($response, true);
        if ($data) {
            echo "Response: " . json_encode($data, JSON_PRETTY_PRINT) . "\n";
        } else {
            echo "Raw response: " . substr($response, 0, 200) . "...\n";
        }
    } else {
        echo "❌ HTTP Error {$httpCode}\n";
        echo "Response: " . substr($response, 0, 200) . "\n";
    }
    
    echo "\n" . str_repeat("-", 50) . "\n\n";
    return $httpCode == 200;
}

// Test endpoints
$endpoints = [
    "/api/visitor-stats" => "Visitor Statistics",
    "/api/visitor-popular" => "Popular Pages", 
    "/api/visitor-dashboard" => "Dashboard Data"
];

foreach ($endpoints as $endpoint => $description) {
    testApiEndpoint($baseUrl . $endpoint, $description);
}

// Test if visitor tracking is working by making a simulated request
echo "🧪 **SIMULATING VISITOR TRACKING:**\n\n";

// Make a request to homepage to trigger visitor tracking
$homepageUrl = $baseUrl . '/';
echo "Making request to homepage: {$homepageUrl}\n";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $homepageUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) Test Browser'
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode == 200) {
    echo "✅ Homepage request successful (HTTP {$httpCode})\n";
} else {
    echo "❌ Homepage request failed (HTTP {$httpCode})\n";
}

// Wait a moment then check if visitor was tracked
sleep(2);

echo "\n📊 **CHECKING IF VISITOR WAS TRACKED:**\n";

try {
    $pdo = new PDO("sqlite:" . __DIR__ . "/database/database.sqlite");
    
    // Check latest visitor logs
    $stmt = $pdo->query("SELECT * FROM visitor_logs ORDER BY created_at DESC LIMIT 3");
    $logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Latest visitor logs:\n";
    foreach ($logs as $log) {
        echo "  - IP: {$log['ip_address']}\n";
        echo "    Page: {$log['page_url']}\n";
        echo "    Time: {$log['created_at']}\n";
        echo "    Browser: {$log['browser']}\n\n";
    }
    
    // Check today's stats
    $today = date('Y-m-d');
    $stmt = $pdo->query("SELECT * FROM visitor_stats WHERE date = '{$today}'");
    $stats = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($stats) {
        echo "Today's stats:\n";
        echo "  - Total: {$stats['total_visitors']}\n";
        echo "  - Unique: {$stats['unique_visitors']}\n";
        echo "  - Views: {$stats['page_views']}\n";
    }
    
} catch (Exception $e) {
    echo "❌ Database check error: " . $e->getMessage() . "\n";
}

echo "\n🎯 **CONCLUSION:**\n";
echo "If the API endpoints return data but homepage requests don't create new visitor logs,\n";
echo "then the VisitorMiddleware is not properly applied to the routes.\n\n";

echo "Test completed at " . date('Y-m-d H:i:s') . "\n";
?>
