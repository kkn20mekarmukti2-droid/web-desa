<?php
/**
 * Script untuk membuat tabel pengaduan di database production cPanel
 * Upload ke public_html dan akses: https://mekarmukti.id/create-pengaduan-table.php
 */
?>
<!DOCTYPE html>
<html>
<head>
    <title>Deploy Pengaduan Table</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .container { max-width: 800px; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .success { color: #28a745; } .error { color: #dc3545; }
        .info { background: #e7f3ff; padding: 10px; border-left: 4px solid #007bff; margin: 10px 0; }
    </style>
</head>
<body>
<div class="container">
<?php
// Database connection untuk cPanel
$servername = "localhost";
$username = "mekh7277_desa"; 
$password = "Desa2024!";
$dbname = "mekh7277_desa";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h2>🔧 DEPLOYING PENGADUAN TABLE</h2>";
    echo "<hr>";
    echo "<p>Database: <strong>$dbname</strong></p>";
    echo "<hr>";
    
    // Check current tables
    echo "<h3>📋 Checking existing tables...</h3>";
    $tables = $conn->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    echo "<p>Found " . count($tables) . " tables in database</p>";
    
    // Check if pengaduan table exists
    $pengaduanExists = in_array('pengaduan', $tables);
    
    if ($pengaduanExists) {
        echo "<div class='info'>✅ Tabel 'pengaduan' sudah ada!</div>";
        
        // Check table structure
        $structure = $conn->query("DESCRIBE pengaduan")->fetchAll();
        echo "<h4>Current table structure:</h4><ul>";
        foreach ($structure as $column) {
            echo "<li>{$column['Field']} - {$column['Type']}</li>";
        }
        echo "</ul>";
        
    } else {
        echo "<h3>🚀 Creating pengaduan table...</h3>";
        
        // Create pengaduan table
        $sql = "CREATE TABLE pengaduan (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            nama VARCHAR(255) NOT NULL,
            no_hp VARCHAR(20) NOT NULL,
            alamat_lengkap TEXT NOT NULL,
            isi TEXT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        
        $conn->exec($sql);
        echo "<div class='success'>✅ Tabel 'pengaduan' berhasil dibuat!</div>";
    }
    
    // Check existing data
    $count = $conn->query("SELECT COUNT(*) FROM pengaduan")->fetchColumn();
    echo "<h3>📊 Current data:</h3>";
    echo "<p>Total pengaduan: <strong>$count</strong></p>";
    
    if ($count == 0) {
        echo "<h3>➕ Inserting sample data...</h3>";
        
        $insertSample = "INSERT INTO pengaduan (nama, no_hp, alamat_lengkap, isi) VALUES 
            ('John Doe', '08123456789', 'Jl. Merdeka No. 123, RT/RW 01/02, Desa Mekarmukti', 'Saya ingin melaporkan jalan rusak di depan rumah yang sudah berlubang cukup dalam dan mengganggu aktivitas warga.'),
            ('Jane Smith', '08987654321', 'Jl. Sudirman No. 45, RT/RW 03/01, Desa Mekarmukti', 'Mohon perhatiannya untuk masalah air bersih yang sudah 3 hari tidak mengalir di wilayah kami. Warga sangat kesulitan untuk kebutuhan sehari-hari.'),
            ('Ahmad Rizki', '08567890123', 'Jl. Pahlawan No. 67, RT/RW 02/01, Desa Mekarmukti', 'Lampu jalan di area kami sudah mati sejak seminggu lalu, sehingga malam hari sangat gelap dan tidak aman untuk aktivitas warga.')";
        
        $conn->exec($insertSample);
        echo "<div class='success'>✅ Sample data berhasil ditambahkan!</div>";
        
        $newCount = $conn->query("SELECT COUNT(*) FROM pengaduan")->fetchColumn();
        echo "<p>Total pengaduan sekarang: <strong>$newCount</strong></p>";
    }
    
    // Show sample data
    echo "<h3>📝 Sample data (latest 5):</h3>";
    $stmt = $conn->query("SELECT * FROM pengaduan ORDER BY created_at DESC LIMIT 5");
    $data = $stmt->fetchAll();
    
    if ($data) {
        echo "<table border='1' cellpadding='8' style='width:100%; border-collapse: collapse;'>";
        echo "<tr><th>ID</th><th>Nama</th><th>No HP</th><th>Alamat</th><th>Isi</th><th>Created</th></tr>";
        foreach ($data as $row) {
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['nama']}</td>";
            echo "<td>{$row['no_hp']}</td>";
            echo "<td>" . substr($row['alamat_lengkap'], 0, 30) . "...</td>";
            echo "<td>" . substr($row['isi'], 0, 50) . "...</td>";
            echo "<td>{$row['created_at']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    
    echo "<hr>";
    echo "<div class='info'>";
    echo "<h3>🎉 DEPLOYMENT SUCCESSFUL!</h3>";
    echo "<p><strong>Tabel pengaduan sudah siap digunakan!</strong></p>";
    echo "<p>👉 Test admin panel: <a href='/admin/pengaduan' target='_blank'>Admin Pengaduan</a></p>";
    echo "<p>👉 Test form pengaduan: <a href='/' target='_blank'>Homepage - Tombol \"Buat Pengaduan\"</a></p>";
    echo "<p>⚠️ <strong>PENTING:</strong> Hapus file ini setelah selesai deployment untuk keamanan!</p>";
    echo "</div>";
    
} catch(PDOException $e) {
    echo "<div class='error'>";
    echo "<h3>❌ DATABASE ERROR</h3>";
    echo "<p><strong>Error:</strong> " . $e->getMessage() . "</p>";
    echo "<p><strong>Code:</strong> " . $e->getCode() . "</p>";
    echo "</div>";
    
    echo "<div class='info'>";
    echo "<h4>💡 Troubleshooting:</h4>";
    echo "<ul>";
    echo "<li>Pastikan credentials database benar</li>";
    echo "<li>Cek apakah database mekh7277_desa ada</li>";
    echo "<li>Pastikan user mekh7277_desa memiliki akses CREATE TABLE</li>";
    echo "</ul>";
    echo "</div>";
}
?>
</div>
</body>
</html>
