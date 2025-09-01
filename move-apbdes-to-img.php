<?php
echo "<h1>🔄 Move APBDes Images to Follow Convention</h1>";
echo "<p>Moving images from /images/apbdes/ to /img/apbdes/ to match berita and struktur pattern</p>";

$sourceDir = __DIR__ . '/public/images/apbdes/';
$targetDir = __DIR__ . '/public/img/apbdes/';

echo "<h2>Creating target directory...</h2>";
if (!is_dir($targetDir)) {
    if (mkdir($targetDir, 0755, true)) {
        echo "✅ Created directory: $targetDir<br>";
    } else {
        echo "❌ Failed to create directory: $targetDir<br>";
        exit;
    }
} else {
    echo "✅ Directory already exists: $targetDir<br>";
}

echo "<h2>Moving files...</h2>";
if (is_dir($sourceDir)) {
    $files = scandir($sourceDir);
    foreach ($files as $file) {
        if ($file != '.' && $file != '..' && is_file($sourceDir . $file)) {
            $sourcePath = $sourceDir . $file;
            $targetPath = $targetDir . $file;
            
            if (copy($sourcePath, $targetPath)) {
                echo "✅ Moved: $file (" . number_format(filesize($targetPath)) . " bytes)<br>";
                unlink($sourcePath); // Remove original
            } else {
                echo "❌ Failed to move: $file<br>";
            }
        }
    }
    
    // Remove empty source directory
    if (rmdir($sourceDir)) {
        echo "✅ Removed old directory: $sourceDir<br>";
    }
} else {
    echo "❌ Source directory not found: $sourceDir<br>";
}

echo "<h2>Verification</h2>";
if (is_dir($targetDir)) {
    $files = array_diff(scandir($targetDir), ['.', '..']);
    echo "✅ Files in /img/apbdes/: " . count($files) . "<br>";
    foreach ($files as $file) {
        $size = filesize($targetDir . $file);
        echo "- $file (" . number_format($size) . " bytes)<br>";
    }
} else {
    echo "❌ Target directory not found<br>";
}

echo "<h2>URL Test</h2>";
echo "<p>Testing new path pattern:</p>";
$files = array_diff(scandir($targetDir), ['.', '..']);
if (!empty($files)) {
    $testFile = array_values($files)[0];
    $testUrl = '/img/apbdes/' . $testFile;
    echo "<strong>Test URL:</strong> <a href='$testUrl' target='_blank'>$testUrl</a><br>";
    echo "<img src='$testUrl' style='max-width:200px; border:1px solid #ddd;' alt='Test Image'><br>";
}

echo "<hr>";
echo "<p><small>🕐 Migration completed at: " . date('Y-m-d H:i:s') . "</small></p>";
?>
