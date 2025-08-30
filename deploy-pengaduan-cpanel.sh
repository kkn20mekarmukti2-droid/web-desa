#!/bin/bash

echo "🚀 DEPLOYING PENGADUAN TABLE TO CPANEL"
echo "======================================"

# Upload create-pengaduan-table.php to public_html
echo "📤 Uploading create-pengaduan-table.php to server..."
echo "1. Upload file create-pengaduan-table.php ke public_html"
echo "2. Atau copy paste code berikut ke file manager cPanel:"
echo ""
echo "=== CODE UNTUK CPANEL ==="
cat << 'EOF'
<?php
/**
 * Script untuk membuat tabel pengaduan di database production
 * Upload ke public_html dan akses via browser: https://mekarmukti.id/create-pengaduan-table.php
 */

// Database connection untuk cPanel
$servername = "localhost";
$username = "mekh7277_desa";
$password = "Desa2024!";
$dbname = "mekh7277_desa";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h2>🔧 MEMBUAT TABEL PENGADUAN</h2>";
    echo "<hr>";
    
    // Check if table already exists
    $checkTable = $conn->query("SHOW TABLES LIKE 'pengaduan'");
    if ($checkTable->rowCount() > 0) {
        echo "✅ Tabel 'pengaduan' sudah ada!<br><br>";
    } else {
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
        echo "✅ Tabel 'pengaduan' berhasil dibuat!<br><br>";
    }
    
    // Insert sample data
    $insertSample = "INSERT INTO pengaduan (nama, no_hp, alamat_lengkap, isi) VALUES 
        ('John Doe', '08123456789', 'Jl. Merdeka No. 123, RT/RW 01/02, Desa Mekarmukti', 'Saya ingin melaporkan jalan rusak di depan rumah yang sudah berlubang cukup dalam dan mengganggu aktivitas warga.'),
        ('Jane Smith', '08987654321', 'Jl. Sudirman No. 45, RT/RW 03/01, Desa Mekarmukti', 'Mohon perhatiannya untuk masalah air bersih yang sudah 3 hari tidak mengalir di wilayah kami. Warga sangat kesulitan untuk kebutuhan sehari-hari.')";
    
    $conn->exec($insertSample);
    echo "✅ Sample data pengaduan berhasil ditambahkan!<br><br>";
    
    // Verify data
    $stmt = $conn->query("SELECT COUNT(*) as total FROM pengaduan");
    $count = $stmt->fetch()['total'];
    echo "📊 Total pengaduan dalam database: <strong>$count</strong><br><br>";
    
    echo "🎉 <strong>SELESAI!</strong> Tabel pengaduan sudah siap digunakan.<br>";
    echo "👉 Sekarang coba buka: <a href='/admin/pengaduan' target='_blank'>Admin Panel - Pengaduan</a><br>";
    echo "👉 Test form pengaduan di: <a href='/' target='_blank'>Homepage (tombol Buat Pengaduan)</a>";
    
} catch(PDOException $e) {
    echo "❌ Error: " . $e->getMessage();
}
?>
EOF

echo "========================="
echo ""
echo "📋 LANGKAH DEPLOYMENT:"
echo "1. Login ke cPanel https://mekarmukti.id:2083"
echo "2. Buka File Manager"
echo "3. Masuk ke folder public_html"
echo "4. Create New File: create-pengaduan-table.php"
echo "5. Copy paste code di atas"
echo "6. Save file"
echo "7. Akses via browser: https://mekarmukti.id/create-pengaduan-table.php"
echo ""
echo "✅ Setelah berhasil, hapus file create-pengaduan-table.php dari server untuk keamanan"
