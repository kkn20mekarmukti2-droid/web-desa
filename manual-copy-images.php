<?php
// APBDes Image Fix - Manual Copy Solution for cPanel
// Run this via browser to manually copy images to public directory

echo "<h1>🔧 APBDes Manual Image Fix</h1>";
echo "<style>body{font-family:Arial,sans-serif;margin:20px;} .success{color:green;} .error{color:red;} .info{color:blue;} .warning{color:orange;}</style>";

echo "<h2>Step 1: Manual Copy Images from Storage to Public</h2>";

$sourceDir = __DIR__ . '/storage/app/public/apbdes';
$targetDir = __DIR__ . '/public/storage/apbdes';
$alternativeTargetDir = __DIR__ . '/public/images/apbdes';

echo "<strong>Source:</strong> $sourceDir<br>";
echo "<strong>Target Option 1:</strong> $targetDir<br>";
echo "<strong>Target Option 2:</strong> $alternativeTargetDir<br><br>";

// Check source directory
if (!is_dir($sourceDir)) {
    echo "<p class='error'>❌ Source directory not found: $sourceDir</p>";
    exit;
}

echo "<p class='success'>✅ Source directory exists</p>";

// Create target directories
if (!is_dir(dirname($targetDir))) {
    mkdir(dirname($targetDir), 0755, true);
}
if (!is_dir($targetDir)) {
    mkdir($targetDir, 0755, true);
}

if (!is_dir(dirname($alternativeTargetDir))) {
    mkdir(dirname($alternativeTargetDir), 0755, true);
}
if (!is_dir($alternativeTargetDir)) {
    mkdir($alternativeTargetDir, 0755, true);
}

// Get list of files to copy
$files = scandir($sourceDir);
$copiedFiles = [];
$errors = [];

echo "<h3>Copying Files:</h3>";

foreach ($files as $file) {
    if ($file == '.' || $file == '..') continue;
    
    $sourceFile = $sourceDir . '/' . $file;
    $targetFile1 = $targetDir . '/' . $file;
    $targetFile2 = $alternativeTargetDir . '/' . $file;
    
    if (is_file($sourceFile)) {
        echo "<div style='border:1px solid #ddd;padding:10px;margin:5px 0;'>";
        echo "<strong>File:</strong> $file<br>";
        
        // Copy to public/storage/apbdes/
        if (copy($sourceFile, $targetFile1)) {
            chmod($targetFile1, 0644);
            echo "<span class='success'>✅ Copied to public/storage/apbdes/</span><br>";
        } else {
            echo "<span class='error'>❌ Failed to copy to public/storage/apbdes/</span><br>";
            $errors[] = "Failed to copy $file to public/storage/apbdes/";
        }
        
        // Also copy to public/images/apbdes/ as backup
        if (copy($sourceFile, $targetFile2)) {
            chmod($targetFile2, 0644);
            echo "<span class='success'>✅ Copied to public/images/apbdes/</span><br>";
        } else {
            echo "<span class='error'>❌ Failed to copy to public/images/apbdes/</span><br>";
        }
        
        $copiedFiles[] = $file;
        echo "</div>";
    }
}

echo "<h2>Step 2: Test Image Access</h2>";

// Test Laravel connection
try {
    require_once __DIR__ . '/vendor/autoload.php';
    $app = require_once __DIR__ . '/bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    $request = Illuminate\Http\Request::capture();
    $response = $kernel->handle($request);

    $apbdes = \App\Models\Apbdes::getActive();
    
    if (!$apbdes->isEmpty()) {
        echo "<strong>Testing copied images:</strong><br>";
        foreach ($apbdes as $item) {
            if ($item->image_path) {
                $webPath1 = 'storage/' . $item->image_path;
                $webPath2 = 'images/' . $item->image_path;
                $fullPath1 = __DIR__ . '/public/' . $webPath1;
                $fullPath2 = __DIR__ . '/public/' . $webPath2;
                
                echo "<div style='border:2px solid #4CAF50;padding:10px;margin:10px 0;'>";
                echo "<strong>APBDes:</strong> " . htmlspecialchars($item->title) . "<br>";
                
                // Test both paths
                if (file_exists($fullPath1)) {
                    echo "<span class='success'>✅ Path 1 accessible: <a href='$webPath1' target='_blank'>$webPath1</a></span><br>";
                    echo "<img src='$webPath1' style='max-width:200px;margin:10px 0;border:1px solid #4CAF50;'><br>";
                } else {
                    echo "<span class='error'>❌ Path 1 not accessible: $webPath1</span><br>";
                }
                
                if (file_exists($fullPath2)) {
                    echo "<span class='success'>✅ Path 2 accessible: <a href='$webPath2' target='_blank'>$webPath2</a></span><br>";
                    echo "<img src='$webPath2' style='max-width:200px;margin:10px 0;border:1px solid #4CAF50;'><br>";
                } else {
                    echo "<span class='error'>❌ Path 2 not accessible: $webPath2</span><br>";
                }
                
                echo "</div>";
            }
        }
    }
    
} catch (Exception $e) {
    echo "<p class='error'>❌ Laravel error: " . htmlspecialchars($e->getMessage()) . "</p>";
}

echo "<h2>Step 3: Results Summary</h2>";
echo "<p><strong>Files copied:</strong> " . count($copiedFiles) . "</p>";
if (!empty($copiedFiles)) {
    echo "<ul>";
    foreach ($copiedFiles as $file) {
        echo "<li>$file</li>";
    }
    echo "</ul>";
}

if (!empty($errors)) {
    echo "<div class='error'>";
    echo "<strong>Errors encountered:</strong><br>";
    foreach ($errors as $error) {
        echo "• $error<br>";
    }
    echo "</div>";
}

echo "<h2>Step 4: Next Actions</h2>";
echo "<div class='info'>";
echo "<strong>After running this fix:</strong><br>";
echo "1. Visit your transparency page: <a href='/transparansi-anggaran' target='_blank'>/transparansi-anggaran</a><br>";
echo "2. Images should now display instead of download buttons<br>";
echo "3. If images still don't show, we'll need to update the view file to use alternative paths<br>";
echo "</div>";

// Additional path check
echo "<h2>Step 5: File Permission Check</h2>";
if (!empty($copiedFiles)) {
    $testFile = $targetDir . '/' . $copiedFiles[0];
    if (file_exists($testFile)) {
        $perms = substr(sprintf('%o', fileperms($testFile)), -3);
        echo "<p>File permissions: $perms " . ($perms == '644' ? '<span class="success">✅ Correct</span>' : '<span class="warning">⚠️ Should be 644</span>') . "</p>";
    }
}

echo "<hr><p><small>🕐 Manual fix completed at: " . date('Y-m-d H:i:s') . "</small></p>";
?>
