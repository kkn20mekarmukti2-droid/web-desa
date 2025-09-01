<?php
echo "<h1>🔄 Fix APBDes Data and Test New Storage</h1>";
echo "<p>Fixing existing APBDes records to use new path format and test new uploads</p>";

// Database connection
try {
    // Get current APBDes data
    $pdo = new PDO('sqlite:' . __DIR__ . '/database/database.sqlite');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h2>Current APBDes Data:</h2>";
    $stmt = $pdo->query("SELECT id, title, image_path, tahun FROM apbdes ORDER BY id DESC");
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($records)) {
        echo "<p>❌ No APBDes records found</p>";
    } else {
        echo "<table border='1' style='border-collapse:collapse; width:100%; margin:10px 0;'>";
        echo "<tr><th>ID</th><th>Title</th><th>Current Path</th><th>Status</th><th>Action</th></tr>";
        
        foreach ($records as $record) {
            $currentPath = $record['image_path'];
            $needsUpdate = false;
            $newPath = $currentPath;
            
            // Check if path needs updating
            if (strpos($currentPath, 'apbdes/') === 0) {
                // Old Laravel storage format: "apbdes/filename.jpg" 
                $newPath = 'img/apbdes/' . basename($currentPath);
                $needsUpdate = true;
                $status = "❌ Old storage path";
            } elseif (strpos($currentPath, 'img/apbdes/') === 0) {
                // Already correct format
                $status = "✅ Correct path";
            } else {
                // Unknown format
                $status = "❓ Unknown format";
                $newPath = 'img/apbdes/' . basename($currentPath);
                $needsUpdate = true;
            }
            
            echo "<tr>";
            echo "<td>{$record['id']}</td>";
            echo "<td>" . htmlspecialchars($record['title']) . "</td>";
            echo "<td><code>" . htmlspecialchars($currentPath) . "</code></td>";
            echo "<td>$status</td>";
            echo "<td>";
            
            if ($needsUpdate) {
                echo "<button onclick='updateRecord({$record['id']}, \"" . addslashes($newPath) . "\")'>Fix Path</button>";
            } else {
                echo "No action needed";
            }
            
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    
    echo "<h2>Directory Check:</h2>";
    $imgApbdesDir = __DIR__ . '/public/img/apbdes/';
    if (is_dir($imgApbdesDir)) {
        echo "✅ Directory exists: /public/img/apbdes/<br>";
        $files = array_diff(scandir($imgApbdesDir), ['.', '..']);
        echo "📁 Files: " . count($files) . "<br>";
        foreach ($files as $file) {
            $size = filesize($imgApbdesDir . $file);
            echo "- $file (" . number_format($size) . " bytes)<br>";
        }
    } else {
        echo "❌ Directory missing: /public/img/apbdes/<br>";
        echo "📁 Creating directory...<br>";
        if (mkdir($imgApbdesDir, 0755, true)) {
            echo "✅ Directory created successfully<br>";
        } else {
            echo "❌ Failed to create directory<br>";
        }
    }
    
    echo "<h2>Actions:</h2>";
    echo "<button onclick='fixAllPaths()' style='background:#007bff;color:white;padding:10px;border:none;border-radius:5px;'>Fix All Paths</button>";
    echo "<button onclick='testNewUpload()' style='background:#28a745;color:white;padding:10px;border:none;border-radius:5px;margin-left:10px;'>Test Upload Process</button>";
    
} catch (Exception $e) {
    echo "❌ Database Error: " . $e->getMessage();
}

echo "<script>
function updateRecord(id, newPath) {
    fetch('fix-apbdes-paths.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({action: 'update', id: id, path: newPath})
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        location.reload();
    });
}

function fixAllPaths() {
    if(confirm('Fix all APBDes paths to use img/apbdes/ format?')) {
        fetch('fix-apbdes-paths.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({action: 'fix_all'})
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            location.reload();
        });
    }
}

function testNewUpload() {
    alert('New uploads will now automatically save to public/img/apbdes/ with correct path format!');
}
</script>";

echo "<hr>";
echo "<p><small>🕐 Data check at: " . date('Y-m-d H:i:s') . "</small></p>";
?>
