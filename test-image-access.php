<?php
// Test APBDes Image Accessibility
echo "<h1>🧪 APBDes Image Access Test</h1>";
echo "<style>body{font-family:Arial,sans-serif;margin:20px;} .success{color:green;} .error{color:red;} .info{color:blue;}</style>";

// Test the specific file
$filename = "9OdAq4f094fCgaHf6nwdi5JpIZyBRiVbOD6yAmje.jpg";
$imagePath = "images/apbdes/" . $filename;
$fullPath = __DIR__ . "/public/" . $imagePath;

echo "<h2>Direct File Test</h2>";
echo "<strong>Filename:</strong> $filename<br>";
echo "<strong>Expected path:</strong> /$imagePath<br>";
echo "<strong>Full server path:</strong> $fullPath<br>";

// Check if file exists
if (file_exists($fullPath)) {
    echo "<p class='success'>✅ File exists on server</p>";
    
    // Test web access
    echo "<h3>Web Access Test:</h3>";
    echo "<div style='border:2px solid green; padding:10px; margin:10px 0;'>";
    echo "<p><strong>Direct link test:</strong> <a href='/$imagePath' target='_blank'>/$imagePath</a></p>";
    
    // Try to display the image
    echo "<h4>Image Preview:</h4>";
    echo "<img src='/$imagePath' style='max-width:300px; border:1px solid #ddd;' alt='APBDes Image' onload=\"console.log('✅ Image loaded successfully')\" onerror=\"console.log('❌ Image failed to load')\">";
    echo "<br><small>If you see the image above, it means the path is working correctly!</small>";
    echo "</div>";
    
} else {
    echo "<p class='error'>❌ File does not exist at: $fullPath</p>";
    
    // Check alternative locations
    echo "<h3>Checking alternative locations:</h3>";
    $alternatives = [
        "public/storage/apbdes/" . $filename,
        "storage/app/public/apbdes/" . $filename,
        "public/img/" . $filename
    ];
    
    foreach ($alternatives as $alt) {
        $altPath = __DIR__ . "/" . $alt;
        if (file_exists($altPath)) {
            echo "<p class='info'>ℹ️ Found at: $alt</p>";
        }
    }
}

echo "<h2>Comparison with Working Images</h2>";

// Test struktur organisasi path
$workingImagePath = "img/perangkat/kades.jpg";
$workingFullPath = __DIR__ . "/public/" . $workingImagePath;

echo "<strong>Struktur Organisasi (working):</strong><br>";
echo "Path: /$workingImagePath<br>";
echo "Exists: " . (file_exists($workingFullPath) ? '<span class="success">YES</span>' : '<span class="error">NO</span>') . "<br>";

if (file_exists($workingFullPath)) {
    echo "<div style='border:1px solid green; padding:10px; margin:10px 0;'>";
    echo "<p>Working example:</p>";
    echo "<img src='/$workingImagePath' style='max-width:200px; border:1px solid #ddd;' alt='Working Image'>";
    echo "</div>";
}

echo "<h2>Laravel Asset Helper Test</h2>";

try {
    require_once __DIR__ . '/vendor/autoload.php';
    $app = require_once __DIR__ . '/bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    $request = Illuminate\Http\Request::capture();
    $response = $kernel->handle($request);

    echo "<strong>Testing Laravel asset() helper:</strong><br>";
    $assetUrl = asset($imagePath);
    echo "asset('$imagePath') = $assetUrl<br>";
    
    echo "<h3>Test with Browser:</h3>";
    echo "<div style='border:2px solid blue; padding:10px;'>";
    echo "<p>Click this link to test: <a href='$assetUrl' target='_blank'>$assetUrl</a></p>";
    echo "<p>If the link works, then the view should work too!</p>";
    echo "</div>";

} catch (Exception $e) {
    echo "<p class='error'>Laravel error: " . htmlspecialchars($e->getMessage()) . "</p>";
}

echo "<h2>Next Steps</h2>";
echo "<div class='info'>";
echo "<p><strong>If the image displays above:</strong></p>";
echo "<ul>";
echo "<li>✅ The file is accessible via web</li>";
echo "<li>✅ Upload the updated transparansi-anggaran.blade.php</li>";
echo "<li>✅ Test the transparency page</li>";
echo "</ul>";

echo "<p><strong>If the image doesn't display:</strong></p>";
echo "<ul>";
echo "<li>❌ Check .htaccess restrictions</li>";
echo "<li>❌ Check file permissions (should be 644)</li>";
echo "<li>❌ Check folder permissions (should be 755)</li>";
echo "</ul>";
echo "</div>";

echo "<hr><p><small>🕐 Test run at: " . date('Y-m-d H:i:s') . "</small></p>";
?>
