<?php
// Script untuk membuat tabel pengaduan modern
// Jalankan dengan: php create-pengaduan-table-modern.php

try {
    // Koneksi ke database menggunakan konfigurasi Laravel
    $database_path = __DIR__ . '/database/database.sqlite';
    
    if (!file_exists($database_path)) {
        echo "❌ File database SQLite tidak ditemukan: $database_path\n";
        echo "📝 Membuat file database baru...\n";
        touch($database_path);
    }
    
    $pdo = new PDO("sqlite:$database_path");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✅ Koneksi ke database berhasil\n";
    
    // Drop tabel lama jika ada untuk membuat ulang dengan struktur baru
    $pdo->exec("DROP TABLE IF EXISTS pengaduan");
    echo "🗑️  Tabel pengaduan lama dihapus (jika ada)\n";
    
    // SQL untuk membuat tabel pengaduan modern
    $createTableSQL = "
    CREATE TABLE pengaduan (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nama VARCHAR(255) NOT NULL,
        email VARCHAR(255) NULL,
        no_hp VARCHAR(20) NULL,
        kategori VARCHAR(50) NOT NULL CHECK (kategori IN ('infrastruktur', 'pelayanan', 'lingkungan', 'sosial', 'ekonomi', 'keamanan', 'lainnya')),
        isi_pengaduan TEXT NOT NULL,
        status VARCHAR(20) DEFAULT 'pending' CHECK (status IN ('pending', 'diproses', 'selesai', 'ditolak')),
        tanggapan TEXT NULL,
        petugas_id INTEGER NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )";
    
    $pdo->exec($createTableSQL);
    echo "✅ Tabel 'pengaduan' berhasil dibuat dengan struktur modern\n";
    
    // Insert beberapa data contoh
    $sampleData = [
        [
            'nama' => 'Budi Santoso',
            'email' => 'budi.santoso@email.com',
            'no_hp' => '081234567890',
            'kategori' => 'infrastruktur',
            'isi_pengaduan' => 'Jalan di RT 02 rusak parah dan berlubang besar. Mohon segera diperbaiki karena sangat mengganggu akses warga.',
            'status' => 'pending'
        ],
        [
            'nama' => 'Siti Aminah',
            'email' => null,
            'no_hp' => '087654321098',
            'kategori' => 'pelayanan',
            'isi_pengaduan' => 'Pelayanan di kantor desa lambat dan petugas kurang ramah. Harap ditingkatkan kualitas pelayanannya.',
            'status' => 'diproses'
        ],
        [
            'nama' => 'Ahmad Wijaya',
            'email' => 'ahmad.wijaya@gmail.com',
            'no_hp' => null,
            'kategori' => 'lingkungan',
            'isi_pengaduan' => 'Banyak sampah berserakan di area pasar desa. Perlu penambahan tempat sampah dan jadwal kebersihan yang rutin.',
            'status' => 'selesai'
        ],
        [
            'nama' => 'Dewi Lestari',
            'email' => 'dewi.lestari@yahoo.com',
            'no_hp' => '085678901234',
            'kategori' => 'sosial',
            'isi_pengaduan' => 'Sering terjadi kebisingan di malam hari dari warung karaoke. Mohon diatur jam operasionalnya.',
            'status' => 'pending'
        ],
        [
            'nama' => 'Hendra Kusuma',
            'email' => null,
            'no_hp' => '082345678901',
            'kategori' => 'ekonomi',
            'isi_pengaduan' => 'Perlu bantuan modal usaha kecil untuk warga yang ingin memulai bisnis. Apakah ada program khusus dari desa?',
            'status' => 'diproses'
        ]
    ];
    
    $stmt = $pdo->prepare("
        INSERT INTO pengaduan (nama, email, no_hp, kategori, isi_pengaduan, status, created_at, updated_at) 
        VALUES (?, ?, ?, ?, ?, ?, datetime('now'), datetime('now'))
    ");
    
    foreach ($sampleData as $data) {
        $stmt->execute([
            $data['nama'],
            $data['email'],
            $data['no_hp'],
            $data['kategori'],
            $data['isi_pengaduan'],
            $data['status']
        ]);
    }
    
    echo "✅ " . count($sampleData) . " data contoh berhasil ditambahkan\n";
    
    // Buat trigger untuk auto-update timestamp
    $triggerSQL = "
    CREATE TRIGGER update_pengaduan_timestamp 
    AFTER UPDATE ON pengaduan
    FOR EACH ROW
    BEGIN
        UPDATE pengaduan SET updated_at = datetime('now') WHERE id = NEW.id;
    END
    ";
    
    $pdo->exec($triggerSQL);
    echo "✅ Trigger untuk auto-update timestamp berhasil dibuat\n";
    
    // Tampilkan struktur tabel
    echo "\n📋 Struktur tabel 'pengaduan':\n";
    echo "=" . str_repeat("=", 60) . "\n";
    
    $columns = $pdo->query("PRAGMA table_info(pengaduan)")->fetchAll(PDO::FETCH_ASSOC);
    foreach ($columns as $column) {
        $nullable = $column['notnull'] ? 'NOT NULL' : 'NULL';
        $default = $column['dflt_value'] ? "DEFAULT {$column['dflt_value']}" : '';
        echo sprintf("%-15s %-15s %-10s %s\n", 
            $column['name'], 
            $column['type'], 
            $nullable,
            $default
        );
    }
    
    // Tampilkan jumlah data
    $count = $pdo->query("SELECT COUNT(*) FROM pengaduan")->fetchColumn();
    echo "\n📊 Total data pengaduan: $count record\n";
    
    // Tampilkan data berdasarkan status
    echo "\n📈 Data berdasarkan status:\n";
    $statusCount = $pdo->query("
        SELECT status, COUNT(*) as jumlah 
        FROM pengaduan 
        GROUP BY status 
        ORDER BY jumlah DESC
    ")->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($statusCount as $status) {
        echo "   • {$status['status']}: {$status['jumlah']} pengaduan\n";
    }
    
    // Tampilkan data berdasarkan kategori
    echo "\n📂 Data berdasarkan kategori:\n";
    $categoryCount = $pdo->query("
        SELECT kategori, COUNT(*) as jumlah 
        FROM pengaduan 
        GROUP BY kategori 
        ORDER BY jumlah DESC
    ")->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($categoryCount as $category) {
        echo "   • {$category['kategori']}: {$category['jumlah']} pengaduan\n";
    }
    
    echo "\n" . str_repeat("=", 70) . "\n";
    echo "🎉 Setup tabel pengaduan modern berhasil!\n";
    echo "📝 Tabel siap digunakan untuk sistem pengaduan online\n";
    echo "🔗 Akses form pengaduan di: /pengaduan\n";
    echo str_repeat("=", 70) . "\n";
    
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
?>
