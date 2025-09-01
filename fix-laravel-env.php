<?php
// Simple Laravel Environment Fix for Asset URLs
echo "<h1>🔧 Laravel Environment Fix</h1>";
echo "<style>body{font-family:Arial,sans-serif;margin:20px;} .success{color:green;} .error{color:red;}</style>";

try {
    require_once __DIR__ . '/vendor/autoload.php';
    $app = require_once __DIR__ . '/bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    $request = Illuminate\Http\Request::capture();
    $response = $kernel->handle($request);
    
    echo "<h2>Current Laravel Configuration</h2>";
    echo "<strong>APP_URL:</strong> " . config('app.url') . "<br>";
    echo "<strong>Request URL:</strong> " . request()->url() . "<br>";
    echo "<strong>Base URL:</strong> " . url('/') . "<br>";
    echo "<strong>Asset URL:</strong> " . asset('test') . "<br>";
    
    // Check if APP_URL is properly set
    $appUrl = config('app.url');
    if (empty($appUrl) || $appUrl === 'http://localhost') {
        echo "<div style='background:#f8d7da; padding:15px; margin:15px 0; border-radius:5px;'>";
        echo "<h3>⚠️ APP_URL Issue Detected</h3>";
        echo "<p>APP_URL is not properly configured. This causes asset() helper to generate incomplete URLs.</p>";
        
        // Try to auto-detect correct URL
        $detectedUrl = request()->getSchemeAndHttpHost();
        echo "<p><strong>Detected URL:</strong> $detectedUrl</p>";
        
        // Show how to fix
        echo "<h4>How to fix:</h4>";
        echo "<ol>";
        echo "<li>Edit .env file in your website root</li>";
        echo "<li>Find line: APP_URL=http://localhost</li>";
        echo "<li>Change to: APP_URL=$detectedUrl</li>";
        echo "<li>Save and refresh</li>";
        echo "</ol>";
        echo "</div>";
        
        // Temporary override for testing
        config(['app.url' => $detectedUrl]);
        echo "<p class='success'>✅ Temporarily fixed for this test</p>";
    }
    
    echo "<h2>Fixed Asset URLs</h2>";
    $filename = "9OdAq4f094fCgaHf6nwdi5JpIZyBRiVbOD6yAmje.jpg";
    
    echo "<strong>APBDes Image URL:</strong> " . asset("images/apbdes/$filename") . "<br>";
    echo "<strong>Structure Image URL:</strong> " . asset("img/perangkat/kades.jpg") . "<br>";
    
    echo "<h2>Image Display Test</h2>";
    echo "<div style='display:flex; gap:20px;'>";
    
    echo "<div style='border:1px solid green; padding:10px;'>";
    echo "<h3>Structure (Working)</h3>";
    echo "<img src='" . asset("img/perangkat/kades.jpg") . "' style='max-width:200px;' alt='Structure'>";
    echo "</div>";
    
    echo "<div style='border:1px solid blue; padding:10px;'>";
    echo "<h3>APBDes (Testing)</h3>";
    echo "<img src='" . asset("images/apbdes/$filename") . "' style='max-width:200px;' alt='APBDes' ";
    echo "onload=\"document.getElementById('apbdes-result').innerHTML='✅ SUCCESS'\" ";
    echo "onerror=\"document.getElementById('apbdes-result').innerHTML='❌ FAILED'\">";
    echo "<br><span id='apbdes-result'>⏳ Loading...</span>";
    echo "</div>";
    
    echo "</div>";
    
    // Get APBDes data to test in context
    echo "<h2>Live APBDes Data Test</h2>";
    $apbdes = \App\Models\Apbdes::getActive();
    
    if (!$apbdes->isEmpty()) {
        foreach ($apbdes->take(1) as $item) {
            echo "<div style='border:2px solid #007bff; padding:15px; margin:15px 0; border-radius:5px;'>";
            echo "<h3>" . htmlspecialchars($item->title) . "</h3>";
            echo "<p><strong>DB Path:</strong> " . $item->image_path . "</p>";
            
            $filename = basename($item->image_path);
            $assetUrl = asset("images/apbdes/$filename");
            
            echo "<p><strong>Asset URL:</strong> <a href='$assetUrl' target='_blank'>$assetUrl</a></p>";
            
            echo "<div style='margin:10px 0;'>";
            echo "<strong>Live Test:</strong><br>";
            echo "<img src='$assetUrl' style='max-width:300px; border:1px solid #ddd;' alt='Live APBDes Test' ";
            echo "onload=\"document.getElementById('live-result').innerHTML='✅ SUCCESS - Images will work in transparency page!'\" ";
            echo "onerror=\"document.getElementById('live-result').innerHTML='❌ FAILED - Check server configuration'\"><br>";
            echo "<strong>Result: <span id='live-result'>⏳ Loading...</span></strong>";
            echo "</div>";
            echo "</div>";
        }
    }
    
} catch (Exception $e) {
    echo "<p class='error'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
}

echo "<h2>Manual URL Test (Bypass Laravel)</h2>";
echo "<p>Direct URL access test (without Laravel asset helper):</p>";
$filename = "9OdAq4f094fCgaHf6nwdi5JpIZyBRiVbOD6yAmje.jpg";
$directUrl = "/images/apbdes/$filename";

echo "<div style='border:2px solid orange; padding:10px; margin:10px 0;'>";
echo "<strong>Direct URL:</strong> <a href='$directUrl' target='_blank'>$directUrl</a><br>";
echo "<img src='$directUrl' style='max-width:200px; border:1px solid #ddd;' alt='Direct URL Test' ";
echo "onload=\"document.getElementById('direct-result').innerHTML='✅ Direct access works - Laravel config issue'\" ";
echo "onerror=\"document.getElementById('direct-result').innerHTML='❌ Direct access failed - Server/file issue'\">";
echo "<br><strong>Result: <span id='direct-result'>⏳ Loading...</span></strong>";
echo "</div>";

echo "<hr><p><small>🕐 Environment check at: " . date('Y-m-d H:i:s') . "</small></p>";
?>
