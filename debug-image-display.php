<?php
echo "<h1>🔍 APBDes Image Display Debug</h1>";
echo "<p>Download works = files exist. Display blank = browser/server issue.</p>";

// Database connection
try {
    $pdo = new PDO('sqlite:' . __DIR__ . '/database/database.sqlite');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h2>APBDes Data Check:</h2>";
    $stmt = $pdo->query("SELECT id, title, image_path, tahun FROM apbdes ORDER BY id DESC LIMIT 5");
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($records as $record) {
        echo "<div style='border:1px solid #ddd; padding:15px; margin:10px 0; border-radius:5px;'>";
        echo "<h3>" . htmlspecialchars($record['title']) . " (ID: {$record['id']})</h3>";
        echo "<p><strong>DB Path:</strong> <code>" . htmlspecialchars($record['image_path']) . "</code></p>";
        
        $imagePath = $record['image_path'];
        $fullPath = __DIR__ . '/public/' . $imagePath;
        
        echo "<h4>File System Check:</h4>";
        if (file_exists($fullPath)) {
            $size = filesize($fullPath);
            $type = mime_content_type($fullPath);
            echo "✅ File exists: " . number_format($size) . " bytes<br>";
            echo "📄 MIME type: $type<br>";
            echo "🔧 Permissions: " . substr(sprintf('%o', fileperms($fullPath)), -4) . "<br>";
        } else {
            echo "❌ File NOT found at: $fullPath<br>";
        }
        
        echo "<h4>Web Access Test:</h4>";
        $webUrl = '/' . $imagePath;
        echo "<strong>Direct URL:</strong> <a href='$webUrl' target='_blank'>$webUrl</a><br>";
        
        echo "<h4>Display Test (Different Methods):</h4>";
        
        echo "<div style='display:flex; gap:20px; flex-wrap:wrap;'>";
        
        // Method 1: Direct path
        echo "<div style='border:1px solid blue; padding:10px;'>";
        echo "<strong>Method 1: Direct Path</strong><br>";
        echo "<img src='$webUrl' style='max-width:150px; border:1px solid #ccc;' alt='Direct' ";
        echo "onload='this.nextElementSibling.innerHTML=\"✅ SUCCESS\"' ";
        echo "onerror='this.nextElementSibling.innerHTML=\"❌ FAILED\"'>";
        echo "<div>⏳ Loading...</div>";
        echo "</div>";
        
        // Method 2: With domain (Laravel asset simulation)
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        $domain = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $fullUrl = $protocol . '://' . $domain . $webUrl;
        echo "<div style='border:1px solid green; padding:10px;'>";
        echo "<strong>Method 2: Full URL</strong><br>";
        echo "<small>$fullUrl</small><br>";
        echo "<img src='$fullUrl' style='max-width:150px; border:1px solid #ccc;' alt='Full URL' ";
        echo "onload='this.nextElementSibling.innerHTML=\"✅ SUCCESS\"' ";
        echo "onerror='this.nextElementSibling.innerHTML=\"❌ FAILED\"'>";
        echo "<div>⏳ Loading...</div>";
        echo "</div>";
        
        // Method 3: Base64 inline (bypass server restrictions)
        if (file_exists($fullPath) && filesize($fullPath) < 1000000) { // < 1MB
            $imageData = base64_encode(file_get_contents($fullPath));
            $mimeType = mime_content_type($fullPath);
            $base64Url = "data:$mimeType;base64,$imageData";
            
            echo "<div style='border:1px solid orange; padding:10px;'>";
            echo "<strong>Method 3: Base64</strong><br>";
            echo "<small>Bypass server restrictions</small><br>";
            echo "<img src='$base64Url' style='max-width:150px; border:1px solid #ccc;' alt='Base64'>";
            echo "<div>✅ Base64 (should always work)</div>";
            echo "</div>";
        }
        
        echo "</div>"; // End display test
        
        echo "<h4>Browser Console Test:</h4>";
        echo "<button onclick='testImageLoad(\"$webUrl\", {$record['id']})'>Test in Console</button>";
        echo "<div id='console-result-{$record['id']}'></div>";
        
        echo "</div>"; // End record div
    }
    
} catch (Exception $e) {
    echo "❌ Database Error: " . $e->getMessage();
}

echo "<h2>Server Configuration Check:</h2>";
echo "<div style='border:2px solid #007bff; padding:15px; margin:15px 0;'>";
echo "<strong>Headers Test:</strong><br>";

// Test image serving headers
$testImagePath = __DIR__ . '/public/img/apbdes/';
if (is_dir($testImagePath)) {
    $files = array_diff(scandir($testImagePath), ['.', '..']);
    if (!empty($files)) {
        $testFile = array_values($files)[0];
        echo "<code>curl -I /img/apbdes/$testFile</code><br>";
        echo "<button onclick='testHeaders(\"/img/apbdes/$testFile\")'>Test Headers</button>";
        echo "<div id='headers-result'></div>";
    }
}
echo "</div>";

echo "<h2>Possible Solutions:</h2>";
echo "<ol>";
echo "<li><strong>Server Issue:</strong> .htaccess blocking image serving</li>";
echo "<li><strong>MIME Type Issue:</strong> Server not recognizing image files</li>";
echo "<li><strong>Permission Issue:</strong> Files not readable by web server</li>";
echo "<li><strong>Laravel Route Issue:</strong> Routes interfering with static files</li>";
echo "</ol>";

echo "<script>
function testImageLoad(url, id) {
    const img = new Image();
    const resultDiv = document.getElementById('console-result-' + id);
    
    img.onload = function() {
        resultDiv.innerHTML = '✅ SUCCESS: Image loaded (' + this.naturalWidth + 'x' + this.naturalHeight + ')';
        resultDiv.style.color = 'green';
    };
    
    img.onerror = function() {
        resultDiv.innerHTML = '❌ FAILED: Image failed to load';
        resultDiv.style.color = 'red';
        
        // Additional debugging
        fetch(url, {method: 'HEAD'})
            .then(response => {
                resultDiv.innerHTML += '<br>HTTP Status: ' + response.status;
                resultDiv.innerHTML += '<br>Content-Type: ' + (response.headers.get('content-type') || 'unknown');
            })
            .catch(error => {
                resultDiv.innerHTML += '<br>Fetch Error: ' + error.message;
            });
    };
    
    resultDiv.innerHTML = '⏳ Testing image load...';
    img.src = url;
}

function testHeaders(url) {
    fetch(url, {method: 'HEAD'})
        .then(response => {
            const resultDiv = document.getElementById('headers-result');
            let result = '<strong>HTTP ' + response.status + '</strong><br>';
            
            response.headers.forEach((value, key) => {
                result += key + ': ' + value + '<br>';
            });
            
            resultDiv.innerHTML = result;
            
            if (response.status === 200) {
                resultDiv.style.color = 'green';
            } else {
                resultDiv.style.color = 'red';
            }
        })
        .catch(error => {
            document.getElementById('headers-result').innerHTML = '❌ Error: ' + error.message;
        });
}
</script>";

echo "<hr>";
echo "<p><small>🕐 Debug at: " . date('Y-m-d H:i:s') . "</small></p>";
?>
