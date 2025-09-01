<?php
// Compare APBDes vs Working Images (Struktur Organisasi)
echo "<!DOCTYPE html><html><head><title>Image Comparison Test</title>";
echo "<style>body{font-family:Arial,sans-serif;margin:20px;} .test-box{border:2px solid;padding:15px;margin:15px 0;} .success{border-color:green;} .error{border-color:red;} img{max-width:200px;margin:10px;border:1px solid #ddd;}</style>";
echo "</head><body>";

echo "<h1>🔍 Image Comparison Test</h1>";

echo "<div class='test-box success'>";
echo "<h2>✅ WORKING: Struktur Organisasi</h2>";
echo "<strong>Method:</strong> Direct public folder access<br>";
echo "<strong>Path:</strong> <code>public/img/perangkat/kades.jpg</code><br>";
echo "<strong>Code:</strong> <code>asset('img/perangkat/kades.jpg')</code><br>";
echo "<strong>URL:</strong> <a href='/img/perangkat/kades.jpg' target='_blank'>/img/perangkat/kades.jpg</a><br>";
echo "<br><strong>Image Test:</strong><br>";
echo "<img src='/img/perangkat/kades.jpg' alt='Struktur Organisasi - Working' onload=\"console.log('✅ Struktur Organisasi loaded')\">";
echo "</div>";

echo "<div class='test-box error'>";
echo "<h2>❓ TESTING: APBDes</h2>";
echo "<strong>Method:</strong> Direct public folder access (copied from storage)<br>";
echo "<strong>Path:</strong> <code>public/images/apbdes/9OdAq4f094fCgaHf6nwdi5JpIZyBRiVbOD6yAmje.jpg</code><br>";
echo "<strong>Code:</strong> <code>asset('images/apbdes/filename.jpg')</code><br>";
echo "<strong>URL:</strong> <a href='/images/apbdes/9OdAq4f094fCgaHf6nwdi5JpIZyBRiVbOD6yAmje.jpg' target='_blank'>/images/apbdes/9OdAq4f094fCgaHf6nwdi5JpIZyBRiVbOD6yAmje.jpg</a><br>";
echo "<br><strong>Image Test:</strong><br>";
echo "<img src='/images/apbdes/9OdAq4f094fCgaHf6nwdi5JpIZyBRiVbOD6yAmje.jpg' alt='APBDes - Testing' onload=\"console.log('✅ APBDes loaded')\" onerror=\"console.log('❌ APBDes failed')\">";
echo "</div>";

// File existence checks
echo "<h2>📁 File Existence Verification</h2>";

$files = [
    'Struktur Organisasi' => 'public/img/perangkat/kades.jpg',
    'APBDes Image' => 'public/images/apbdes/9OdAq4f094fCgaHf6nwdi5JpIZyBRiVbOD6yAmje.jpg'
];

foreach ($files as $name => $path) {
    $fullPath = __DIR__ . '/' . $path;
    $exists = file_exists($fullPath);
    $size = $exists ? filesize($fullPath) : 0;
    $permissions = $exists ? substr(sprintf('%o', fileperms($fullPath)), -3) : 'N/A';
    
    echo "<div style='margin:10px 0;padding:10px;background:" . ($exists ? '#e8f5e8' : '#f5e8e8') . ";'>";
    echo "<strong>$name:</strong><br>";
    echo "Path: $path<br>";
    echo "Exists: " . ($exists ? '✅ YES' : '❌ NO') . "<br>";
    if ($exists) {
        echo "Size: " . number_format($size) . " bytes<br>";
        echo "Permissions: $permissions<br>";
    }
    echo "</div>";
}

// Test direct URL access
echo "<h2>🌐 Direct URL Test</h2>";
echo "<p>Click the links below to test direct access:</p>";
echo "<ul>";
echo "<li><a href='/img/perangkat/kades.jpg' target='_blank'>Struktur Organisasi Image</a> (should work)</li>";
echo "<li><a href='/images/apbdes/9OdAq4f094fCgaHf6nwdi5JpIZyBRiVbOD6yAmje.jpg' target='_blank'>APBDes Image</a> (testing)</li>";
echo "</ul>";

// Laravel asset test
echo "<h2>⚙️ Laravel Asset Helper Test</h2>";
try {
    require_once __DIR__ . '/vendor/autoload.php';
    $app = require_once __DIR__ . '/bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    $request = Illuminate\Http\Request::capture();
    $response = $kernel->handle($request);
    
    echo "<div style='background:#f0f8ff;padding:10px;margin:10px 0;'>";
    echo "<strong>Laravel Asset URLs:</strong><br>";
    echo "Struktur Organisasi: " . asset('img/perangkat/kades.jpg') . "<br>";
    echo "APBDes: " . asset('images/apbdes/9OdAq4f094fCgaHf6nwdi5JpIZyBRiVbOD6yAmje.jpg') . "<br>";
    echo "</div>";
    
} catch (Exception $e) {
    echo "<p style='color:red;'>Laravel error: " . htmlspecialchars($e->getMessage()) . "</p>";
}

echo "<h2>📊 Analysis</h2>";
echo "<div style='background:#fff3cd;padding:15px;border-radius:5px;'>";
echo "<p><strong>Both should work identically because:</strong></p>";
echo "<ul>";
echo "<li>✅ Both use direct public folder access</li>";
echo "<li>✅ Both use asset() helper</li>";  
echo "<li>✅ Both have correct file permissions (644)</li>";
echo "<li>✅ Both bypass symbolic link issues</li>";
echo "</ul>";
echo "<p><strong>If APBDes image displays above, then the transparansi-anggaran.blade.php will work!</strong></p>";
echo "</div>";

echo "<h2>🚀 Next Steps</h2>";
echo "<ol>";
echo "<li>Check if APBDes image displays in the test above</li>";
echo "<li>If YES: Upload updated transparansi-anggaran.blade.php and test</li>";
echo "<li>If NO: Check browser developer tools for specific error</li>";
echo "</ol>";

echo "<script>";
echo "// Console logging for debugging";
echo "console.log('=== Image Load Test Started ===');";
echo "</script>";

echo "</body></html>";
?>
