<?php
/**
 * cPanel Production Deployment Script
 * Khusus untuk memperbaiki error "Table 'data' doesn't exist"
 * di halaman Data Statistik
 */

// KONFIGURASI DATABASE - SESUAIKAN DENGAN cPANEL ANDA
$db_config = [
    'host' => 'localhost',           
    'dbname' => 'mekh7277_desa',    // Nama database cPanel
    'username' => 'mekh7277_desa',  // Username database cPanel  
    'password' => 'PASSWORD_ANDA'   // ⚠️ GANTI DENGAN PASSWORD DATABASE ASLI
];

echo "🚀 DEPLOYMENT DATA STATISTIK - CPANEL PRODUCTION\n";
echo "================================================\n";
echo "Target: https://mekarmukti.id/admin/data-management\n";
echo "Database: {$db_config['dbname']}\n\n";

// Cek environment
if (!isset($_SERVER['HTTP_HOST']) || !strpos($_SERVER['HTTP_HOST'], 'mekarmukti.id')) {
    echo "⚠️  PERINGATAN: Script ini untuk production server!\n";
    echo "Host saat ini: " . ($_SERVER['HTTP_HOST'] ?? 'localhost') . "\n\n";
}

try {
    // 1. KONEKSI DATABASE
    echo "📋 Step 1: Connecting to MySQL database...\n";
    $dsn = "mysql:host={$db_config['host']};dbname={$db_config['dbname']};charset=utf8mb4";
    $pdo = new PDO($dsn, $db_config['username'], $db_config['password']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Berhasil terhubung ke database: {$db_config['dbname']}\n\n";

    // 2. CEK TABEL DATA
    echo "📋 Step 2: Checking data table...\n";
    $stmt = $pdo->query("SHOW TABLES LIKE 'data'");
    $tableExists = $stmt->rowCount() > 0;

    if ($tableExists) {
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM `data`");
        $count = $stmt->fetch()['count'];
        echo "ℹ️  Tabel 'data' sudah ada dengan {$count} records\n";
        
        if ($count >= 28) {
            echo "\n✅ DEPLOYMENT SUDAH SELESAI!\n";
            echo "Data statistik sudah lengkap ({$count} records)\n";
            echo "Test halaman: https://mekarmukti.id/admin/data-management\n";
            exit(0);
        } else {
            echo "⚠️  Tabel ada tapi data kurang ({$count}/28), akan menambah data...\n";
        }
    } else {
        echo "⚠️  Tabel 'data' tidak ditemukan, akan dibuat...\n";
        
        // CREATE TABLE
        $createSQL = "
            CREATE TABLE `data` (
                `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                `data` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Kategori data',
                `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Label dalam kategori',
                `total` int(11) NOT NULL COMMENT 'Jumlah/total untuk label ini',
                `created_at` timestamp NULL DEFAULT NULL,
                `updated_at` timestamp NULL DEFAULT NULL,
                PRIMARY KEY (`id`),
                KEY `idx_data_category` (`data`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Tabel data statistik desa'
        ";
        
        $pdo->exec($createSQL);
        echo "✅ Tabel 'data' berhasil dibuat\n\n";
    }

    // 3. INSERT DATA STATISTIK
    echo "📋 Step 3: Inserting statistical data...\n";
    
    // Hapus data lama jika ada (untuk memastikan data fresh)
    if ($tableExists) {
        $pdo->exec("DELETE FROM `data`");
        echo "🗑️  Data lama dihapus\n";
    }

    // Data statistik lengkap untuk Desa Mekar Mukti
    $statistik_data = [
        // PENDIDIKAN (6 kategori)
        ['data' => 'Pendidikan', 'label' => 'Tidak Tamat SD', 'total' => 45],
        ['data' => 'Pendidikan', 'label' => 'Tamat SD/Sederajat', 'total' => 128],
        ['data' => 'Pendidikan', 'label' => 'Tamat SMP/Sederajat', 'total' => 97],
        ['data' => 'Pendidikan', 'label' => 'Tamat SMA/Sederajat', 'total' => 156],
        ['data' => 'Pendidikan', 'label' => 'Diploma/Sarjana S1', 'total' => 73],
        ['data' => 'Pendidikan', 'label' => 'Pascasarjana S2/S3', 'total' => 12],
        
        // PEKERJAAN (7 kategori)
        ['data' => 'Pekerjaan', 'label' => 'Petani/Pekebun', 'total' => 187],
        ['data' => 'Pekerjaan', 'label' => 'Buruh Tani/Harian', 'total' => 94],
        ['data' => 'Pekerjaan', 'label' => 'Pedagang/Wiraswasta', 'total' => 52],
        ['data' => 'Pekerjaan', 'label' => 'PNS/ASN', 'total' => 28],
        ['data' => 'Pekerjaan', 'label' => 'Karyawan Swasta', 'total' => 65],
        ['data' => 'Pekerjaan', 'label' => 'Pensiunan', 'total' => 19],
        ['data' => 'Pekerjaan', 'label' => 'Belum/Tidak Bekerja', 'total' => 67],
        
        // KELOMPOK USIA (4 kategori)
        ['data' => 'Usia', 'label' => 'Balita (0-5 Tahun)', 'total' => 78],
        ['data' => 'Usia', 'label' => 'Anak-Remaja (6-17 Tahun)', 'total' => 142],
        ['data' => 'Usia', 'label' => 'Dewasa (18-59 Tahun)', 'total' => 287],
        ['data' => 'Usia', 'label' => 'Lansia (60+ Tahun)', 'total' => 56],
        
        // AGAMA (5 kategori)
        ['data' => 'Agama', 'label' => 'Islam', 'total' => 524],
        ['data' => 'Agama', 'label' => 'Kristen Protestan', 'total' => 28],
        ['data' => 'Agama', 'label' => 'Katolik', 'total' => 15],
        ['data' => 'Agama', 'label' => 'Hindu', 'total' => 3],
        ['data' => 'Agama', 'label' => 'Buddha', 'total' => 1],
        
        // STATUS PERKAWINAN (4 kategori)
        ['data' => 'Status Kawin', 'label' => 'Belum Kawin', 'total' => 189],
        ['data' => 'Status Kawin', 'label' => 'Kawin', 'total' => 312],
        ['data' => 'Status Kawin', 'label' => 'Cerai Hidup', 'total' => 23],
        ['data' => 'Status Kawin', 'label' => 'Cerai Mati (Duda/Janda)', 'total' => 47],
        
        // JENIS KELAMIN (2 kategori)  
        ['data' => 'Jenis Kelamin', 'label' => 'Laki-laki', 'total' => 289],
        ['data' => 'Jenis Kelamin', 'label' => 'Perempuan', 'total' => 282]
    ];

    // Prepare statement untuk insert
    $insertSQL = "INSERT INTO `data` (`data`, `label`, `total`, `created_at`, `updated_at`) VALUES (?, ?, ?, NOW(), NOW())";
    $stmt = $pdo->prepare($insertSQL);

    $berhasil = 0;
    foreach ($statistik_data as $record) {
        $stmt->execute([
            $record['data'],
            $record['label'], 
            $record['total']
        ]);
        $berhasil++;
        echo "✓ {$record['data']}: {$record['label']} ({$record['total']})\n";
    }

    echo "\n✅ Berhasil insert {$berhasil} data statistik\n\n";

    // 4. VERIFIKASI DATA
    echo "📋 Step 4: Verifying data...\n";
    $stmt = $pdo->query("
        SELECT `data` as kategori, 
               COUNT(*) as jumlah_record, 
               SUM(total) as total_populasi 
        FROM `data` 
        GROUP BY `data` 
        ORDER BY `data`
    ");

    echo "📊 RINGKASAN DATA STATISTIK:\n";
    echo "============================\n";
    $total_records = 0;
    $total_populasi = 0;
    
    while ($row = $stmt->fetch()) {
        echo sprintf("%-15s: %2d records, %3d total\n", 
            $row['kategori'], 
            $row['jumlah_record'], 
            $row['total_populasi']
        );
        $total_records += $row['jumlah_record'];
        $total_populasi += $row['total_populasi'];
    }
    
    echo "============================\n";
    echo sprintf("%-15s: %2d records, %3d total\n", "GRAND TOTAL", $total_records, $total_populasi);

    // 5. SUCCESS MESSAGE
    echo "\n🎉 DEPLOYMENT BERHASIL SELESAI!\n";
    echo "================================\n";
    echo "✅ Tabel 'data' sudah dibuat dan berisi {$total_records} records\n";
    echo "✅ Total populasi: {$total_populasi} jiwa\n";
    echo "✅ Data Statistik siap digunakan\n\n";
    
    echo "🔗 TEST HALAMAN:\n";
    echo "Admin: https://mekarmukti.id/admin/data-management\n";
    echo "Public: https://mekarmukti.id (jika ada statistik di homepage)\n\n";
    
    echo "📝 CATATAN:\n";
    echo "- Jika masih error, coba clear cache Laravel\n";
    echo "- Data ini adalah contoh, bisa disesuaikan dengan data riil desa\n";
    echo "- File script ini bisa dihapus setelah deployment berhasil\n";

} catch (PDOException $e) {
    echo "\n❌ DATABASE ERROR:\n";
    echo "Error: " . $e->getMessage() . "\n";
    echo "Code: " . $e->getCode() . "\n\n";
    
    echo "🔧 TROUBLESHOOTING:\n";
    echo "1. Pastikan database credentials benar\n";
    echo "2. Cek database 'mekh7277_desa' ada di cPanel\n";
    echo "3. Pastikan user punya permission CREATE dan INSERT\n";
    echo "4. Coba akses phpMyAdmin untuk test koneksi\n";
    
} catch (Exception $e) {
    echo "\n❌ GENERAL ERROR:\n";
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " line " . $e->getLine() . "\n";
}

echo "\n" . date('Y-m-d H:i:s') . " - Deployment script finished.\n";
?>
