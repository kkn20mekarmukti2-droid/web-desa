<?php

require_once 'check_database.php';

echo "=== ADDING MOTEKART MAGAZINE ===\n";

try {
    // First, check if MotekArt magazine already exists
    $checkStmt = $pdo->prepare("SELECT id FROM majalah WHERE judul LIKE '%MotekArt%'");
    $checkStmt->execute();
    
    if ($checkStmt->fetch()) {
        echo "⚠️  Majalah MotekArt sudah ada, akan diupdate...\n";
        $updateStmt = $pdo->prepare("
            UPDATE majalah 
            SET cover_image = ?, 
                deskripsi = ?,
                is_active = 1,
                tanggal_terbit = ?,
                updated_at = ?
            WHERE judul LIKE '%MotekArt%'
        ");
        
        $updateStmt->execute([
            'img/majalah/MotekArt/1.png',
            'Majalah MotekArt - Seni dan Kreativitas Desa dengan 26 halaman penuh inspirasi dan karya seni masyarakat desa.',
            date('Y-m-d'),
            date('Y-m-d H:i:s')
        ]);
        
        echo "✅ Majalah MotekArt berhasil diupdate!\n";
    } else {
        // Insert new MotekArt magazine
        $insertStmt = $pdo->prepare("
            INSERT INTO majalah (judul, deskripsi, cover_image, is_active, tanggal_terbit, created_at, updated_at) 
            VALUES (?, ?, ?, 1, ?, ?, ?)
        ");
        
        $insertStmt->execute([
            'Majalah MotekArt - Seni dan Kreativitas Desa',
            'Majalah MotekArt - Seni dan Kreativitas Desa dengan 26 halaman penuh inspirasi dan karya seni masyarakat desa.',
            'img/majalah/MotekArt/1.png',
            date('Y-m-d'),
            date('Y-m-d H:i:s'),
            date('Y-m-d H:i:s')
        ]);
        
        echo "✅ Majalah MotekArt berhasil ditambahkan!\n";
    }
    
    // Check if majalah_pages table exists, if not create it
    $stmt = $pdo->query("SELECT name FROM sqlite_master WHERE type='table' AND name='majalah_pages'");
    if (!$stmt->fetch()) {
        $createPagesTable = "
        CREATE TABLE majalah_pages (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            majalah_id INTEGER NOT NULL,
            page_number INTEGER NOT NULL,
            image_path VARCHAR(255) NOT NULL,
            title VARCHAR(255),
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (majalah_id) REFERENCES majalah(id) ON DELETE CASCADE
        )";
        
        $pdo->exec($createPagesTable);
        echo "✅ Table majalah_pages berhasil dibuat!\n";
    }
    
    // Get the majalah ID for MotekArt
    $stmt = $pdo->prepare("SELECT id FROM majalah WHERE judul LIKE '%MotekArt%'");
    $stmt->execute();
    $majalahId = $stmt->fetch()['id'];
    
    // Clear existing pages for this magazine
    $deletePages = $pdo->prepare("DELETE FROM majalah_pages WHERE majalah_id = ?");
    $deletePages->execute([$majalahId]);
    
    // Add all 26 pages
    echo "\n📄 Menambahkan halaman-halaman majalah...\n";
    $insertPage = $pdo->prepare("
        INSERT INTO majalah_pages (majalah_id, page_number, image_path, title, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    
    for ($i = 1; $i <= 26; $i++) {
        $imagePath = "img/majalah/MotekArt/{$i}.png";
        $title = ($i == 1) ? "Cover" : "Halaman {$i}";
        
        $insertPage->execute([
            $majalahId,
            $i,
            $imagePath,
            $title,
            date('Y-m-d H:i:s'),
            date('Y-m-d H:i:s')
        ]);
        
        echo "✅ Halaman {$i}: {$imagePath}\n";
    }
    
    echo "\n📊 Status final:\n";
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM majalah");
    $totalMajalah = $stmt->fetch()['total'];
    echo "Total majalah: {$totalMajalah}\n";
    
    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM majalah_pages WHERE majalah_id = ?");
    $stmt->execute([$majalahId]);
    $totalPages = $stmt->fetch()['total'];
    echo "Total halaman MotekArt: {$totalPages}\n";
    
    echo "\n🎉 Majalah MotekArt berhasil disetup dengan {$totalPages} halaman!\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

?>
