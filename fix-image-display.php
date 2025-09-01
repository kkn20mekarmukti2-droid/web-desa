<?php
echo "<h1>🔧 Fix APBDes Image Display Issues</h1>";
echo "<p>Download works but display blank = server configuration issue</p>";

// Check and create .htaccess for img directory if needed
$imgDir = __DIR__ . '/public/img/';
$htaccessPath = $imgDir . '.htaccess';

echo "<h2>Image Directory Configuration:</h2>";

if (!is_dir($imgDir)) {
    echo "❌ img directory missing<br>";
    if (mkdir($imgDir, 0755, true)) {
        echo "✅ Created img directory<br>";
    }
} else {
    echo "✅ img directory exists<br>";
}

// Check if .htaccess exists in img directory
if (!file_exists($htaccessPath)) {
    echo "⚠️ No .htaccess in img directory<br>";
    echo "📝 Creating .htaccess for proper image serving...<br>";
    
    $htaccessContent = "# Allow image access
<IfModule mod_rewrite.c>
    RewriteEngine Off
</IfModule>

# Set proper MIME types
<IfModule mod_mime.c>
    AddType image/jpeg .jpg .jpeg
    AddType image/png .png
    AddType image/gif .gif
    AddType image/webp .webp
</IfModule>

# Allow direct access to images
<Files ~ \"\\.(jpe?g|png|gif|webp)$\">
    Require all granted
    Header set Cache-Control \"public, max-age=2592000\"
</Files>

# Disable PHP execution in image directories
<Files ~ \"\\.php$\">
    Require all denied
</Files>
";
    
    if (file_put_contents($htaccessPath, $htaccessContent)) {
        echo "✅ Created .htaccess in img directory<br>";
    } else {
        echo "❌ Failed to create .htaccess<br>";
    }
} else {
    echo "✅ .htaccess exists in img directory<br>";
    echo "<pre>" . htmlspecialchars(file_get_contents($htaccessPath)) . "</pre>";
}

echo "<h2>APBDes Directory Check:</h2>";
$apbdesDir = $imgDir . 'apbdes/';
if (!is_dir($apbdesDir)) {
    echo "❌ apbdes subdirectory missing<br>";
    if (mkdir($apbdesDir, 0755, true)) {
        echo "✅ Created apbdes subdirectory<br>";
    }
} else {
    echo "✅ apbdes subdirectory exists<br>";
    
    $files = array_diff(scandir($apbdesDir), ['.', '..']);
    echo "📁 Files in apbdes: " . count($files) . "<br>";
    
    foreach ($files as $file) {
        $filePath = $apbdesDir . $file;
        $size = filesize($filePath);
        $perms = substr(sprintf('%o', fileperms($filePath)), -4);
        $readable = is_readable($filePath) ? '✅' : '❌';
        
        echo "- $file ($perms) " . number_format($size) . " bytes $readable<br>";
        
        // Test web access
        $webPath = '/img/apbdes/' . $file;
        echo "  <a href='$webPath' target='_blank'>$webPath</a><br>";
    }
}

echo "<h2>Alternative Image Serving (PHP Bypass):</h2>";
echo "<p>If direct access is blocked, we can serve images through PHP:</p>";

// Create PHP image server
$imageServerContent = "<?php
// APBDes Image Server - Bypass server restrictions
\$imageName = \$_GET['img'] ?? '';
\$imagePath = __DIR__ . '/public/img/apbdes/' . basename(\$imageName);

if (empty(\$imageName) || !file_exists(\$imagePath)) {
    header('HTTP/1.0 404 Not Found');
    exit('Image not found');
}

// Security check
\$allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
\$extension = strtolower(pathinfo(\$imagePath, PATHINFO_EXTENSION));

if (!in_array(\$extension, \$allowedTypes)) {
    header('HTTP/1.0 403 Forbidden');
    exit('File type not allowed');
}

// Get MIME type
\$mimeType = mime_content_type(\$imagePath);

// Set headers
header('Content-Type: ' . \$mimeType);
header('Content-Length: ' . filesize(\$imagePath));
header('Cache-Control: public, max-age=2592000');
header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 2592000) . ' GMT');

// Output image
readfile(\$imagePath);
exit;
?>";

$imageServerPath = __DIR__ . '/serve-apbdes-image.php';
if (file_put_contents($imageServerPath, $imageServerContent)) {
    echo "✅ Created serve-apbdes-image.php<br>";
    echo "📝 Usage: <code>/serve-apbdes-image.php?img=filename.jpg</code><br>";
} else {
    echo "❌ Failed to create image server<br>";
}

echo "<h2>Update Blade Template for Fallback:</h2>";
echo "<p>We need to update transparansi-anggaran.blade.php to use PHP image server as fallback:</p>";

echo "<textarea style='width:100%; height:200px;'>
// Add this JavaScript to transparansi-anggaran.blade.php:
function tryAlternatePaths(img, originalPath, title, id) {
    const filename = originalPath.split('/').pop();
    const alternativePaths = [
        '/img/apbdes/' + filename,           // Direct access
        '/serve-apbdes-image.php?img=' + filename,  // PHP server fallback
        '/' + originalPath,                  // Database path
        '/storage/' + originalPath           // Laravel storage fallback
    ];
    
    let currentIndex = 0;
    
    function tryNext() {
        if (currentIndex < alternativePaths.length) {
            const nextPath = alternativePaths[currentIndex];
            console.log('Trying path: ' + nextPath);
            
            img.onerror = tryNext;
            img.src = nextPath;
            currentIndex++;
        } else {
            // All paths failed, show error
            img.onerror = null;
            showImageError(img, originalPath, title, id);
        }
    }
    
    tryNext();
}
</textarea>";

echo "<h2>Quick Test:</h2>";
// Get a test image if available
try {
    $pdo = new PDO('sqlite:' . __DIR__ . '/database/database.sqlite');
    $stmt = $pdo->query("SELECT image_path FROM apbdes LIMIT 1");
    $record = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($record) {
        $testImage = basename($record['image_path']);
        echo "<div style='border:2px solid #007bff; padding:15px;'>";
        echo "<h3>Test Image Display:</h3>";
        echo "<p><strong>Direct:</strong> <img src='/img/apbdes/$testImage' style='max-width:200px;' onerror='this.style.border=\"2px solid red\"' onload='this.style.border=\"2px solid green\"'></p>";
        echo "<p><strong>PHP Server:</strong> <img src='/serve-apbdes-image.php?img=$testImage' style='max-width:200px;' onerror='this.style.border=\"2px solid red\"' onload='this.style.border=\"2px solid green\"'></p>";
        echo "</div>";
    }
} catch (Exception $e) {
    echo "Database connection failed";
}

echo "<h2>Next Steps:</h2>";
echo "<ol>";
echo "<li>Upload this fix to cPanel</li>";
echo "<li>Run the image server test above</li>";
echo "<li>If direct access fails but PHP server works, update blade template</li>";
echo "<li>Test APBDes transparency page</li>";
echo "</ol>";

echo "<hr>";
echo "<p><small>🕐 Fix applied at: " . date('Y-m-d H:i:s') . "</small></p>";
?>
