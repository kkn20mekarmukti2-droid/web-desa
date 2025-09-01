<?php
// Fix APBDes Image Display - Storage Link Repair
// Upload this to your cPanel and run via browser to fix storage link issues

echo "<h1>🔧 APBDes Image Fix Tool</h1>";
echo "<style>body{font-family:Arial,sans-serif;margin:20px;} .success{color:green;} .error{color:red;} .info{color:blue;} .warning{color:orange;}</style>";

echo "<h2>Step 1: Storage Link Diagnosis</h2>";

$publicStoragePath = __DIR__ . '/public/storage';
$storagePublicPath = __DIR__ . '/storage/app/public';

echo "<strong>Current Status:</strong><br>";
echo "• Public storage path: $publicStoragePath<br>";
echo "• Storage public path: $storagePublicPath<br>";
echo "• Public storage exists: " . (file_exists($publicStoragePath) ? '<span class="success">YES</span>' : '<span class="error">NO</span>') . "<br>";
echo "• Storage public exists: " . (file_exists($storagePublicPath) ? '<span class="success">YES</span>' : '<span class="error">NO</span>') . "<br>";

if (file_exists($publicStoragePath)) {
    echo "• Is symbolic link: " . (is_link($publicStoragePath) ? '<span class="success">YES</span>' : '<span class="error">NO</span>') . "<br>";
    if (is_link($publicStoragePath)) {
        $target = readlink($publicStoragePath);
        echo "• Link target: $target<br>";
        echo "• Target exists: " . (file_exists($target) ? '<span class="success">YES</span>' : '<span class="error">NO</span>') . "<br>";
    }
}

echo "<h2>Step 2: Auto-Fix Storage Link</h2>";

try {
    // Create storage/app/public if it doesn't exist
    if (!file_exists($storagePublicPath)) {
        if (mkdir($storagePublicPath, 0755, true)) {
            echo "<p class='success'>✅ Created storage/app/public directory</p>";
        } else {
            echo "<p class='error'>❌ Failed to create storage/app/public directory</p>";
        }
    }

    // Remove existing public/storage if it's not a proper link
    if (file_exists($publicStoragePath) && !is_link($publicStoragePath)) {
        if (is_dir($publicStoragePath)) {
            // It's a directory, remove it
            $files = scandir($publicStoragePath);
            foreach ($files as $file) {
                if ($file != '.' && $file != '..') {
                    unlink($publicStoragePath . '/' . $file);
                }
            }
            if (rmdir($publicStoragePath)) {
                echo "<p class='warning'>⚠️ Removed existing public/storage directory</p>";
            }
        }
    }

    // Create the symbolic link
    if (!file_exists($publicStoragePath)) {
        if (symlink($storagePublicPath, $publicStoragePath)) {
            echo "<p class='success'>✅ Created storage symbolic link</p>";
        } else {
            echo "<p class='error'>❌ Failed to create symbolic link. Trying alternative...</p>";
            
            // Alternative: copy files instead of symlink (for shared hosting)
            if (mkdir($publicStoragePath, 0755)) {
                echo "<p class='info'>📁 Created public/storage as regular directory</p>";
                echo "<p class='warning'>⚠️ Note: You'll need to manually copy files from storage/app/public to public/storage</p>";
            }
        }
    } else {
        echo "<p class='info'>ℹ️ Storage link already exists</p>";
    }

} catch (Exception $e) {
    echo "<p class='error'>❌ Error: " . htmlspecialchars($e->getMessage()) . "</p>";
}

echo "<h2>Step 3: Test APBDes Images</h2>";

try {
    require_once __DIR__ . '/vendor/autoload.php';
    $app = require_once __DIR__ . '/bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    $request = Illuminate\Http\Request::capture();
    $response = $kernel->handle($request);

    $apbdes = \App\Models\Apbdes::getActive();
    if (!$apbdes->isEmpty()) {
        echo "<strong>Testing image accessibility:</strong><br>";
        foreach ($apbdes->take(3) as $item) {
            if ($item->image_path) {
                $webPath = 'storage/' . $item->image_path;
                $fullPath = __DIR__ . '/public/' . $webPath;
                $accessible = file_exists($fullPath);
                
                echo "• " . htmlspecialchars($item->title) . ": ";
                if ($accessible) {
                    echo '<span class="success">✅ ACCESSIBLE</span>';
                    echo " - <a href='$webPath' target='_blank'>View Image</a>";
                } else {
                    echo '<span class="error">❌ NOT ACCESSIBLE</span>';
                    echo " (Expected at: $webPath)";
                }
                echo "<br>";
            }
        }
    } else {
        echo "<p class='warning'>⚠️ No active APBDes records to test</p>";
    }

} catch (Exception $e) {
    echo "<p class='error'>❌ Laravel error: " . htmlspecialchars($e->getMessage()) . "</p>";
}

echo "<h2>Step 4: Manual Fix Instructions</h2>";
echo "<div class='info'>";
echo "<strong>If automatic fix didn't work:</strong><br>";
echo "1. Via cPanel File Manager, navigate to your website root<br>";
echo "2. Create folder: <code>public/storage</code> (if it doesn't exist)<br>";
echo "3. Copy all files from <code>storage/app/public/</code> to <code>public/storage/</code><br>";
echo "4. Set permissions: Files = 644, Folders = 755<br>";
echo "5. Test your transparency page again<br><br>";

echo "<strong>Alternative approach - Update image paths:</strong><br>";
echo "Instead of using <code>asset('storage/...')</code>, you could:<br>";
echo "1. Store images directly in <code>public/images/apbdes/</code><br>";
echo "2. Update the view to use <code>asset('images/apbdes/' . \$item->image_path)</code><br>";
echo "</div>";

echo "<h2>Step 5: Next Steps</h2>";
echo "<p class='success'>After running this fix:</p>";
echo "<ul>";
echo "<li>Visit your transparency page: <a href='/transparansi-anggaran'>/transparansi-anggaran</a></li>";
echo "<li>Images should now display properly instead of showing download buttons</li>";
echo "<li>If issues persist, check file permissions and paths</li>";
echo "</ul>";

echo "<hr><p><small>🕐 Fix applied at: " . date('Y-m-d H:i:s') . "</small></p>";
?>
