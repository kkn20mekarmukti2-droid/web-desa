<?php
// Direct Web Access Test for APBDes Images
echo "<h1>🔍 Direct APBDes Image Access Test</h1>";
echo "<style>body{font-family:Arial,sans-serif;margin:20px;} .success{color:green;} .error{color:red;} .info{color:blue;}</style>";

$filename = "9OdAq4f094fCgaHf6nwdi5JpIZyBRiVbOD6yAmje.jpg";

echo "<h2>Step 1: Raw URL Access Test</h2>";

// Test various URL patterns
$testUrls = [
    "Working Structure Image" => "/img/perangkat/kades.jpg",
    "APBDes Direct" => "/images/apbdes/$filename",
    "APBDes Alternative 1" => "/public/images/apbdes/$filename", 
    "APBDes Alternative 2" => "/storage/apbdes/$filename"
];

foreach ($testUrls as $name => $url) {
    echo "<div style='border:1px solid #ddd; padding:10px; margin:10px 0;'>";
    echo "<strong>$name:</strong><br>";
    echo "URL: <a href='$url' target='_blank'>$url</a><br>";
    echo "Test: <img src='$url' style='max-width:150px; height:100px; object-fit:cover; border:1px solid #ccc;' ";
    echo "onload=\"document.getElementById('result_" . md5($name) . "').innerHTML='<span class=success>✅ SUCCESS</span>'\" ";
    echo "onerror=\"document.getElementById('result_" . md5($name) . "').innerHTML='<span class=error>❌ FAILED</span>'\"> ";
    echo "<span id='result_" . md5($name) . "'>⏳ Testing...</span>";
    echo "</div>";
}

echo "<h2>Step 2: Laravel Configuration Check</h2>";

try {
    require_once __DIR__ . '/vendor/autoload.php';
    $app = require_once __DIR__ . '/bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    $request = Illuminate\Http\Request::capture();
    $response = $kernel->handle($request);
    
    echo "<div style='background:#f8f9fa; padding:15px; border-radius:5px;'>";
    echo "<strong>Laravel Environment:</strong><br>";
    echo "APP_URL: " . config('app.url') . "<br>";
    echo "Request URL: " . request()->url() . "<br>";
    echo "Base URL: " . url('/') . "<br>";
    echo "<br>";
    
    // Test asset() with different approaches
    echo "<strong>Asset Helper Tests:</strong><br>";
    $assetTests = [
        'Standard asset()' => asset("images/apbdes/$filename"),
        'URL helper' => url("images/apbdes/$filename"),
        'Manual URL' => request()->getSchemeAndHttpHost() . "/images/apbdes/$filename"
    ];
    
    foreach ($assetTests as $method => $url) {
        echo "$method: <a href='$url' target='_blank'>$url</a><br>";
    }
    echo "</div>";
    
} catch (Exception $e) {
    echo "<p class='error'>Laravel error: " . htmlspecialchars($e->getMessage()) . "</p>";
}

echo "<h2>Step 3: File System Check</h2>";

$filePath = __DIR__ . "/public/images/apbdes/$filename";
$fileUrl = "/images/apbdes/$filename";

if (file_exists($filePath)) {
    echo "<p class='success'>✅ File exists at: $filePath</p>";
    echo "<p><strong>File details:</strong></p>";
    echo "<ul>";
    echo "<li>Size: " . number_format(filesize($filePath)) . " bytes</li>";
    echo "<li>Permissions: " . substr(sprintf('%o', fileperms($filePath)), -3) . "</li>";
    echo "<li>MIME type: " . (function_exists('mime_content_type') ? mime_content_type($filePath) : 'Unknown') . "</li>";
    echo "</ul>";
    
    // Try to serve the file directly with PHP
    echo "<h3>Direct PHP File Serve Test:</h3>";
    echo "<div style='border:2px solid blue; padding:10px;'>";
    echo "<p>PHP-served image:</p>";
    
    // Create a simple image serving script
    $imageServePath = "/serve-image.php?file=" . urlencode("images/apbdes/$filename");
    echo "<img src='$imageServePath' style='max-width:200px; border:1px solid #ccc;' alt='PHP Served Image'>";
    echo "<br><small>If this displays, then PHP can read the file correctly.</small>";
    echo "</div>";
    
} else {
    echo "<p class='error'>❌ File not found at: $filePath</p>";
}

echo "<h2>Step 4: Web Server Configuration Test</h2>";
echo "<div style='background:#fff3cd; padding:15px; border-radius:5px;'>";
echo "<p><strong>Possible issues to check:</strong></p>";
echo "<ul>";
echo "<li>Web server blocking access to /images/ directory</li>";
echo "<li>Incorrect .htaccess rules in /images/ or /public/images/</li>";
echo "<li>PHP-FPM or Apache configuration issues</li>";
echo "<li>File permissions on directories (should be 755)</li>";
echo "</ul>";
echo "</div>";

// Check directory permissions
$imageDir = __DIR__ . "/public/images";
$apbdesDir = __DIR__ . "/public/images/apbdes";

echo "<h3>Directory Permissions:</h3>";
echo "<ul>";
echo "<li>/public/images: " . (is_dir($imageDir) ? "EXISTS (permissions: " . substr(sprintf('%o', fileperms($imageDir)), -3) . ")" : "NOT FOUND") . "</li>";
echo "<li>/public/images/apbdes: " . (is_dir($apbdesDir) ? "EXISTS (permissions: " . substr(sprintf('%o', fileperms($apbdesDir)), -3) . ")" : "NOT FOUND") . "</li>";
echo "</ul>";

echo "<h2>📋 Action Plan</h2>";
echo "<div class='info'>";
echo "<ol>";
echo "<li><strong>Check which image loads above</strong> - this will tell us the correct path</li>";
echo "<li><strong>If none load:</strong> There's a server configuration issue blocking image access</li>";
echo "<li><strong>If direct URL works:</strong> Laravel asset() helper has configuration issue</li>";
echo "<li><strong>Try the PHP-served image</strong> - if it works, it's a web server routing issue</li>";
echo "</ol>";
echo "</div>";

echo "<hr><p><small>🕐 Test completed at: " . date('Y-m-d H:i:s') . "</small></p>";
?>
