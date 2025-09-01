<?php
// Copy APBDes Images to Public Images Folder (like berita system)
// This copies images from storage/app/public/apbdes/ to public/images/apbdes/
// Run via browser: http://yourdomain.com/copy-apbdes-to-images.php

echo "<h1>📁 APBDes Image Migration Tool</h1>";
echo "<style>body{font-family:Arial,sans-serif;margin:20px;} .success{color:green;} .error{color:red;} .info{color:blue;} .warning{color:orange;}</style>";

echo "<h2>Copy APBDes Images to Public Images Folder</h2>";
echo "<p class='info'>This will copy images from storage/app/public/apbdes/ to public/images/apbdes/ (like berita system)</p>";

$sourceDir = __DIR__ . '/storage/app/public/apbdes';
$targetDir = __DIR__ . '/public/images/apbdes';

echo "<strong>Source:</strong> $sourceDir<br>";
echo "<strong>Target:</strong> $targetDir<br><br>";

// Check source directory
if (!is_dir($sourceDir)) {
    echo "<p class='error'>❌ Source directory not found: $sourceDir</p>";
    echo "<p class='warning'>💡 Make sure APBDes images are stored in storage/app/public/apbdes/</p>";
    exit;
}

echo "<p class='success'>✅ Source directory exists</p>";

// Create target directory
if (!is_dir($targetDir)) {
    if (mkdir($targetDir, 0755, true)) {
        echo "<p class='success'>✅ Created target directory: $targetDir</p>";
    } else {
        echo "<p class='error'>❌ Failed to create target directory</p>";
        exit;
    }
} else {
    echo "<p class='info'>ℹ️ Target directory already exists</p>";
}

// Get list of files to copy
$files = scandir($sourceDir);
$copiedFiles = [];
$errors = [];

echo "<h3>Copying Files:</h3>";

foreach ($files as $file) {
    if ($file == '.' || $file == '..') continue;
    
    $sourceFile = $sourceDir . '/' . $file;
    $targetFile = $targetDir . '/' . $file;
    
    if (is_file($sourceFile)) {
        echo "<div style='border:1px solid #ddd;padding:10px;margin:5px 0;'>";
        echo "<strong>File:</strong> $file<br>";
        
        // Check if file already exists
        if (file_exists($targetFile)) {
            echo "<span class='warning'>⚠️ File already exists, overwriting...</span><br>";
        }
        
        // Copy file
        if (copy($sourceFile, $targetFile)) {
            chmod($targetFile, 0644);
            echo "<span class='success'>✅ Successfully copied</span><br>";
            
            // Test web accessibility
            $webPath = 'images/apbdes/' . $file;
            echo "<span class='success'>🌐 Web accessible at: <a href='/$webPath' target='_blank'>/$webPath</a></span><br>";
            
            $copiedFiles[] = $file;
        } else {
            echo "<span class='error'>❌ Failed to copy</span><br>";
            $errors[] = "Failed to copy $file";
        }
        
        echo "</div>";
    }
}

echo "<h2>Results Summary</h2>";
echo "<p><strong>Files copied:</strong> " . count($copiedFiles) . "</p>";

if (!empty($copiedFiles)) {
    echo "<div class='success'>";
    echo "<strong>✅ Successfully copied files:</strong><br>";
    foreach ($copiedFiles as $file) {
        echo "• $file → /images/apbdes/$file<br>";
    }
    echo "</div>";
}

if (!empty($errors)) {
    echo "<div class='error'>";
    echo "<strong>❌ Errors encountered:</strong><br>";
    foreach ($errors as $error) {
        echo "• $error<br>";
    }
    echo "</div>";
}

// Test Laravel integration
echo "<h2>Laravel Integration Test</h2>";
try {
    require_once __DIR__ . '/vendor/autoload.php';
    $app = require_once __DIR__ . '/bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    $request = Illuminate\Http\Request::capture();
    $response = $kernel->handle($request);

    $apbdes = \App\Models\Apbdes::getActive();
    
    if (!$apbdes->isEmpty()) {
        echo "<strong>Testing new image paths:</strong><br>";
        foreach ($apbdes as $item) {
            if ($item->image_path) {
                $filename = basename($item->image_path);
                $newWebPath = 'images/apbdes/' . $filename;
                $fullPath = __DIR__ . '/public/' . $newWebPath;
                
                echo "<div style='border:2px solid #4CAF50;padding:10px;margin:10px 0;'>";
                echo "<strong>APBDes:</strong> " . htmlspecialchars($item->title) . "<br>";
                echo "<strong>Original DB path:</strong> " . $item->image_path . "<br>";
                echo "<strong>New web path:</strong> /$newWebPath<br>";
                
                if (file_exists($fullPath)) {
                    echo "<span class='success'>✅ File accessible: <a href='/$newWebPath' target='_blank'>View Image</a></span><br>";
                    echo "<img src='/$newWebPath' style='max-width:200px;margin:10px 0;border:1px solid #4CAF50;'><br>";
                } else {
                    echo "<span class='error'>❌ File not accessible at: $newWebPath</span><br>";
                }
                
                echo "</div>";
            }
        }
    }
    
} catch (Exception $e) {
    echo "<p class='error'>❌ Laravel error: " . htmlspecialchars($e->getMessage()) . "</p>";
}

echo "<h2>Next Steps</h2>";
echo "<div class='info'>";
echo "<strong>After running this migration:</strong><br>";
echo "1. Upload the updated <code>transparansi-anggaran.blade.php</code> to your server<br>";
echo "2. Visit your transparency page: <a href='/transparansi-anggaran' target='_blank'>/transparansi-anggaran</a><br>";
echo "3. Images should now display like berita images (direct path, no symbolic link issues)<br>";
echo "4. The new path structure: <code>public/images/apbdes/filename.jpg</code><br>";
echo "</div>";

echo "<div class='success'>";
echo "<h3>✅ Why This Works:</h3>";
echo "<strong>BERITA system (works):</strong> <code>public/img/filename.jpg</code> → <code>asset('img/filename.jpg')</code><br>";
echo "<strong>APBDes system (now):</strong> <code>public/images/apbdes/filename.jpg</code> → <code>asset('images/apbdes/filename.jpg')</code><br>";
echo "<strong>Both use direct public paths, no symbolic links needed!</strong>";
echo "</div>";

echo "<hr><p><small>🕐 Migration completed at: " . date('Y-m-d H:i:s') . "</small></p>";
?>
