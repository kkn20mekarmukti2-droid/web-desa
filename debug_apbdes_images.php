<?php
require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::capture();
$response = $kernel->handle($request);

echo "=== APBDes Image Path Debug ===\n";

try {
    $apbdes = \App\Models\Apbdes::getActive();
    echo "Active APBDes count: " . count($apbdes) . "\n\n";
    
    foreach ($apbdes as $item) {
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        echo "Title: " . $item->title . "\n";
        echo "Image Path (DB): " . ($item->image_path ?: 'NULL') . "\n";
        
        if ($item->image_path) {
            // Check various possible locations
            $possiblePaths = [
                __DIR__ . '/storage/app/public/' . $item->image_path,
                __DIR__ . '/storage/app/' . $item->image_path,
                __DIR__ . '/public/storage/' . $item->image_path,
                __DIR__ . '/public/' . $item->image_path,
                __DIR__ . '/' . $item->image_path
            ];
            
            echo "Checking file existence:\n";
            foreach ($possiblePaths as $path) {
                $exists = file_exists($path);
                $pathDisplay = str_replace(__DIR__, '', $path);
                echo "  " . ($exists ? "✅" : "❌") . " " . $pathDisplay . "\n";
                
                if ($exists) {
                    $fileSize = filesize($path);
                    $fileInfo = pathinfo($path);
                    echo "     Size: " . number_format($fileSize) . " bytes\n";
                    echo "     Extension: " . ($fileInfo['extension'] ?? 'none') . "\n";
                }
            }
            
            // Check what Laravel would generate
            echo "Laravel asset() would generate: " . asset('storage/' . $item->image_path) . "\n";
            echo "Laravel Storage::url() would generate: " . \Storage::url($item->image_path) . "\n";
        }
        echo "\n";
    }
    
    echo "=== Storage Configuration ===\n";
    echo "Storage app path: " . storage_path('app') . "\n";
    echo "Storage public path: " . storage_path('app/public') . "\n";
    echo "Public storage link: " . public_path('storage') . "\n";
    
    // Check if storage link is working
    echo "Public storage link exists: " . (file_exists(public_path('storage')) ? "YES" : "NO") . "\n";
    echo "Is link: " . (is_link(public_path('storage')) ? "YES (symbolic link)" : "NO") . "\n";
    
    if (is_link(public_path('storage'))) {
        echo "Link target: " . readlink(public_path('storage')) . "\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
