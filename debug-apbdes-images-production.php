<?php
// Upload this file to your cPanel and run via browser
// This will help debug image display issues on production

echo "<h1>🖼️ APBDes Image Debug Tool</h1>";
echo "<style>body{font-family:Arial,sans-serif;margin:20px;} .success{color:green;} .error{color:red;} .info{color:blue;} .warning{color:orange;} pre{background:#f5f5f5;padding:10px;border-radius:5px;} img{max-width:200px;border:1px solid #ddd;margin:5px;}</style>";

try {
    require_once __DIR__ . '/vendor/autoload.php';
    $app = require_once __DIR__ . '/bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    $request = Illuminate\Http\Request::capture();
    $response = $kernel->handle($request);

    echo "<h2>1. APBDes Data & Image Paths</h2>";
    
    $apbdes = \App\Models\Apbdes::getActive();
    echo "<p class='info'>Active APBDes records: " . count($apbdes) . "</p>";
    
    if ($apbdes->isEmpty()) {
        // Check for any APBDes data
        $allApbdes = \App\Models\Apbdes::all();
        if ($allApbdes->isEmpty()) {
            echo "<p class='error'>❌ No APBDes data found at all</p>";
        } else {
            echo "<p class='warning'>⚠️ Found " . count($allApbdes) . " APBDes records, but none are active</p>";
            echo "<div class='info'><strong>Inactive Records:</strong></div>";
            foreach ($allApbdes as $item) {
                echo "<div style='border:1px solid #ddd;padding:10px;margin:10px 0;'>";
                echo "<strong>" . htmlspecialchars($item->title) . "</strong><br>";
                echo "Status: " . ($item->is_active ? '<span class="success">Active</span>' : '<span class="error">Inactive</span>') . "<br>";
                echo "Image path: " . htmlspecialchars($item->image_path ?: 'NULL') . "<br>";
                echo "</div>";
            }
        }
    } else {
        foreach ($apbdes as $item) {
            echo "<div style='border:2px solid #4CAF50;padding:15px;margin:15px 0;border-radius:5px;'>";
            echo "<h3>" . htmlspecialchars($item->title) . " (Tahun " . $item->tahun . ")</h3>";
            echo "<strong>Image Path in DB:</strong> " . htmlspecialchars($item->image_path ?: 'NULL') . "<br><br>";
            
            if ($item->image_path) {
                // Test different path combinations
                $pathTests = [
                    'storage/' . $item->image_path => __DIR__ . '/storage/app/public/' . $item->image_path,
                    'public/storage/' . $item->image_path => __DIR__ . '/public/storage/' . $item->image_path,
                    'direct path' => __DIR__ . '/' . $item->image_path,
                ];
                
                echo "<strong>Path Testing:</strong><br>";
                $imageFound = false;
                foreach ($pathTests as $label => $fullPath) {
                    $exists = file_exists($fullPath);
                    $webPath = str_replace(__DIR__, '', $fullPath);
                    echo "• " . $label . ": " . ($exists ? '<span class="success">✅ EXISTS</span>' : '<span class="error">❌ NOT FOUND</span>') . " ($webPath)<br>";
                    
                    if ($exists && !$imageFound) {
                        $imageFound = true;
                        echo "<div style='margin:10px 0;'>";
                        echo "<strong>✅ Image Preview:</strong><br>";
                        $webUrl = str_replace(__DIR__, '', $fullPath);
                        echo "<img src='$webUrl' alt='Preview' style='max-width:300px;border:2px solid #4CAF50;'><br>";
                        echo "<em>Web URL: " . $webUrl . "</em>";
                        echo "</div>";
                    }
                }
                
                if (!$imageFound) {
                    echo "<br><strong class='error'>❌ Image file not found in any expected location!</strong><br>";
                }
                
                // Show what asset() helper generates
                echo "<br><strong>Laravel Helpers:</strong><br>";
                echo "• asset('storage/' . path): " . asset('storage/' . $item->image_path) . "<br>";
                echo "• Storage::url(path): " . \Storage::url($item->image_path) . "<br>";
            } else {
                echo "<span class='error'>❌ No image path stored</span><br>";
            }
            echo "</div>";
        }
    }
    
    echo "<h2>2. Storage Configuration Check</h2>";
    echo "<strong>Storage Paths:</strong><br>";
    echo "• Storage app: " . storage_path('app') . "<br>";
    echo "• Storage public: " . storage_path('app/public') . "<br>";
    echo "• Public storage link: " . public_path('storage') . "<br>";
    echo "• Public storage exists: " . (file_exists(public_path('storage')) ? '<span class="success">YES</span>' : '<span class="error">NO</span>') . "<br>";
    
    echo "<h2>3. Quick Fix Suggestions</h2>";
    echo "<div class='info'>";
    echo "<strong>If images show as broken/not displaying:</strong><br>";
    echo "1. Check if files exist in <code>storage/app/public/</code> folder<br>";
    echo "2. Ensure <code>php artisan storage:link</code> was run<br>";
    echo "3. Verify file permissions (644 for files, 755 for folders)<br>";
    echo "4. Make sure web server can access the storage directory<br>";
    echo "</div>";
    
} catch (Exception $e) {
    echo "<p class='error'>❌ Error: " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p><small>File: " . $e->getFile() . " Line: " . $e->getLine() . "</small></p>";
}

echo "<hr><p><small>🕐 Debug run at: " . date('Y-m-d H:i:s') . "</small></p>";
?>
