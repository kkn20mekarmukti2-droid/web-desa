<?php
echo "<h1>🎯 APBDes Simple Test - Following Berita Pattern</h1>";

echo "<h2>✅ What We Changed:</h2>";
echo "<ul>";
echo "<li><strong>REMOVED:</strong> 200+ lines of complex JavaScript fallbacks</li>";
echo "<li><strong>REMOVED:</strong> Complex path alternatives and retries</li>";
echo "<li><strong>REMOVED:</strong> Over-engineered error handling</li>";
echo "</ul>";

echo "<h2>✅ Now Using EXACT Same Pattern as Berita:</h2>";
echo "<pre style='background:#f5f5f5; padding:10px; border-radius:5px;'>
// BERITA (WORKS):
@if(\$berita->sampul && file_exists(public_path('img/' . \$berita->sampul)))
    &lt;img src=\"{{ asset('img/' . \$berita->sampul) }}\" /&gt;
@endif

// APBDES (NOW SAME):
@if(\$item->image_path && file_exists(public_path(\$item->image_path)))
    &lt;img src=\"{{ asset(\$item->image_path) }}\" /&gt;
@endif
</pre>";

echo "<h2>🔍 Database Check:</h2>";
try {
    $pdo = new PDO('sqlite:' . __DIR__ . '/database/database.sqlite');
    $stmt = $pdo->query("SELECT id, title, image_path FROM apbdes LIMIT 3");
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($records as $record) {
        echo "<div style='border:1px solid #ddd; padding:10px; margin:10px 0;'>";
        echo "<strong>ID {$record['id']}:</strong> " . htmlspecialchars($record['title']) . "<br>";
        echo "<strong>Path:</strong> <code>" . htmlspecialchars($record['image_path']) . "</code><br>";
        
        $fullPath = __DIR__ . '/public/' . $record['image_path'];
        if (file_exists($fullPath)) {
            $size = filesize($fullPath);
            echo "✅ File exists: " . number_format($size) . " bytes<br>";
            
            // Test web URL
            $webUrl = '/' . $record['image_path'];
            echo "🌐 URL: <a href='$webUrl' target='_blank'>$webUrl</a><br>";
            echo "📷 Preview: <img src='$webUrl' style='max-width:200px; max-height:150px; border:1px solid #ccc;' alt='Test'><br>";
        } else {
            echo "❌ File NOT found at: $fullPath<br>";
        }
        echo "</div>";
    }
} catch (Exception $e) {
    echo "❌ Database error: " . $e->getMessage();
}

echo "<h2>🎯 Expected Results:</h2>";
echo "<ul>";
echo "<li>✅ <strong>If berita images work, APBDes will work too</strong></li>";
echo "<li>✅ No complex fallbacks needed</li>";
echo "<li>✅ No JavaScript retries</li>";
echo "<li>✅ Same pattern = same reliability</li>";
echo "</ul>";

echo "<h2>🚀 Test APBDes Page:</h2>";
echo "<a href='/transparansi-anggaran' target='_blank' style='background:#007bff; color:white; padding:10px 20px; text-decoration:none; border-radius:5px;'>View APBDes Transparency Page</a>";

echo "<hr>";
echo "<p><small>🕐 Simple test at: " . date('Y-m-d H:i:s') . "</small></p>";
?>
