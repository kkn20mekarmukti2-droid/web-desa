<?php
// Simple script to add hero images directly using database connection

echo "=== MENAMBAHKAN HERO IMAGES ===\n\n";

// Database configuration - sesuaikan dengan .env Anda
$host = 'localhost';
$dbname = 'web_desa'; // Sesuaikan nama database
$username = 'root';   // Sesuaikan username database
$password = '';       // Sesuaikan password database

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✅ Koneksi database berhasil!\n\n";
    
    // Data hero images
    $heroImages = [
        ['nama_gambar' => 'Desa Mekarmukti 1', 'gambar' => 'img/DSC_0070.JPG', 'deskripsi' => 'Pemandangan indah Desa Mekarmukti - Foto utama untuk slideshow hero', 'urutan' => 1],
        ['nama_gambar' => 'Aktivitas Desa', 'gambar' => 'img/DSC_0108.jpg', 'deskripsi' => 'Aktivitas masyarakat Desa Mekarmukti dalam kehidupan sehari-hari', 'urutan' => 2],
        ['nama_gambar' => 'Infrastruktur Desa', 'gambar' => 'img/DSC_0828.JPG', 'deskripsi' => 'Perkembangan infrastruktur dan pembangunan di Desa Mekarmukti', 'urutan' => 3],
        ['nama_gambar' => 'Fasilitas Umum', 'gambar' => 'img/IMG_9152.png', 'deskripsi' => 'Fasilitas umum yang tersedia untuk masyarakat Desa Mekarmukti', 'urutan' => 4],
        ['nama_gambar' => 'Kepala Desa', 'gambar' => 'img/kades.jpg', 'deskripsi' => 'Kepala Desa Mekarmukti dalam menjalankan tugasnya melayani masyarakat', 'urutan' => 5],
        ['nama_gambar' => 'Kegiatan Desa 1', 'gambar' => 'img/P1560599.JPG', 'deskripsi' => 'Berbagai kegiatan dan program yang dilaksanakan di Desa Mekarmukti', 'urutan' => 6],
        ['nama_gambar' => 'Kegiatan Desa 2', 'gambar' => 'img/P1570155.JPG', 'deskripsi' => 'Dokumentasi kegiatan pembangunan dan kemasyarakatan desa', 'urutan' => 7]
    ];
    
    // Prepare statement
    $stmt = $pdo->prepare("INSERT INTO hero_images (nama_gambar, gambar, deskripsi, urutan, is_active, created_at, updated_at) VALUES (?, ?, ?, ?, 1, NOW(), NOW())");
    
    $successCount = 0;
    $skipCount = 0;
    
    foreach ($heroImages as $image) {
        // Check if file exists
        $imagePath = "C:\\xampp\\htdocs\\web-desa\\public\\" . str_replace('/', '\\', $image['gambar']);
        if (!file_exists($imagePath)) {
            echo "⚠️  File tidak ditemukan: {$image['gambar']} - Dilewati\n";
            $skipCount++;
            continue;
        }
        
        // Check if already exists
        $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM hero_images WHERE gambar = ?");
        $checkStmt->execute([$image['gambar']]);
        if ($checkStmt->fetchColumn() > 0) {
            echo "📋 Sudah ada: {$image['nama_gambar']} - Dilewati\n";
            $skipCount++;
            continue;
        }
        
        // Insert data
        if ($stmt->execute([$image['nama_gambar'], $image['gambar'], $image['deskripsi'], $image['urutan']])) {
            echo "✅ Berhasil: {$image['nama_gambar']} (Urutan: {$image['urutan']})\n";
            $successCount++;
        } else {
            echo "❌ Gagal: {$image['nama_gambar']}\n";
        }
    }
    
    // Get final count
    $totalStmt = $pdo->query("SELECT COUNT(*) FROM hero_images");
    $totalCount = $totalStmt->fetchColumn();
    
    echo "\n=== RINGKASAN ===\n";
    echo "✅ Berhasil ditambahkan: $successCount gambar\n";
    echo "⚠️  Dilewati: $skipCount gambar\n";
    echo "📊 Total di database: $totalCount gambar\n";
    
    if ($successCount > 0) {
        echo "\n🎉 Hero images berhasil ditambahkan ke database!\n";
        echo "📱 Silakan akses /admin/hero-images untuk melihat hasilnya.\n";
    }
    
} catch (PDOException $e) {
    echo "❌ Database Error: " . $e->getMessage() . "\n";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
