<?php

// Simple production deployment script for cPanel
// This script creates the data table and populates it with sample data

echo "🚀 Production Deployment - Data Statistik Setup\n";
echo "==============================================\n\n";

// Database configuration (adjust these values for production)
$host = 'localhost';
$dbname = 'mekh7277_desa';
$username = 'mekh7277_desa'; // Replace with actual username
$password = ''; // Replace with actual password

try {
    // Connect to MySQL database
    echo "📋 Connecting to database...\n";
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Connected to database: {$dbname}\n\n";

    // Check if data table exists
    echo "🔍 Checking if data table exists...\n";
    $stmt = $pdo->query("SHOW TABLES LIKE 'data'");
    $tableExists = $stmt->rowCount() > 0;

    if ($tableExists) {
        // Check if table has data
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM `data`");
        $count = $stmt->fetch()['count'];
        echo "✅ Data table exists with {$count} records\n";
        
        if ($count > 0) {
            echo "📊 Current categories:\n";
            $stmt = $pdo->query("SELECT `data`, COUNT(*) as count FROM `data` GROUP BY `data`");
            while ($row = $stmt->fetch()) {
                echo "   - {$row['data']}: {$row['count']} records\n";
            }
            echo "\n✅ Data table already populated. Deployment complete!\n";
            exit(0);
        }
    } else {
        echo "⚠️  Data table does not exist. Creating...\n";
        
        // Create data table
        $createTableSQL = "
            CREATE TABLE `data` (
                `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                `data` varchar(255) NOT NULL,
                `label` varchar(255) NOT NULL,
                `total` int(11) NOT NULL,
                `created_at` timestamp NULL DEFAULT NULL,
                `updated_at` timestamp NULL DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ";
        
        $pdo->exec($createTableSQL);
        echo "✅ Data table created successfully\n";
    }

    // Insert sample data
    echo "📊 Inserting sample statistical data...\n";
    
    $sampleData = [
        // Pendidikan
        ['data' => 'Pendidikan', 'label' => 'Tidak Tamat SD', 'total' => 45],
        ['data' => 'Pendidikan', 'label' => 'Tamat SD', 'total' => 128],
        ['data' => 'Pendidikan', 'label' => 'Tamat SMP', 'total' => 97],
        ['data' => 'Pendidikan', 'label' => 'Tamat SMA', 'total' => 156],
        ['data' => 'Pendidikan', 'label' => 'Diploma/S1', 'total' => 73],
        ['data' => 'Pendidikan', 'label' => 'S2/S3', 'total' => 12],
        
        // Pekerjaan
        ['data' => 'Pekerjaan', 'label' => 'Petani', 'total' => 187],
        ['data' => 'Pekerjaan', 'label' => 'Buruh', 'total' => 94],
        ['data' => 'Pekerjaan', 'label' => 'Pedagang', 'total' => 52],
        ['data' => 'Pekerjaan', 'label' => 'PNS', 'total' => 28],
        ['data' => 'Pekerjaan', 'label' => 'Swasta', 'total' => 65],
        ['data' => 'Pekerjaan', 'label' => 'Pensiunan', 'total' => 19],
        ['data' => 'Pekerjaan', 'label' => 'Tidak Bekerja', 'total' => 67],
        
        // Usia
        ['data' => 'Usia', 'label' => '0-5 Tahun', 'total' => 78],
        ['data' => 'Usia', 'label' => '6-17 Tahun', 'total' => 142],
        ['data' => 'Usia', 'label' => '18-59 Tahun', 'total' => 287],
        ['data' => 'Usia', 'label' => '60+ Tahun', 'total' => 56],
        
        // Agama
        ['data' => 'Agama', 'label' => 'Islam', 'total' => 524],
        ['data' => 'Agama', 'label' => 'Kristen', 'total' => 28],
        ['data' => 'Agama', 'label' => 'Katolik', 'total' => 15],
        ['data' => 'Agama', 'label' => 'Hindu', 'total' => 3],
        ['data' => 'Agama', 'label' => 'Buddha', 'total' => 1],
        
        // Status Kawin
        ['data' => 'Status Kawin', 'label' => 'Belum Kawin', 'total' => 189],
        ['data' => 'Status Kawin', 'label' => 'Kawin', 'total' => 312],
        ['data' => 'Status Kawin', 'label' => 'Cerai Hidup', 'total' => 23],
        ['data' => 'Status Kawin', 'label' => 'Cerai Mati', 'total' => 47],
        
        // Jenis Kelamin
        ['data' => 'Jenis Kelamin', 'label' => 'Laki-laki', 'total' => 289],
        ['data' => 'Jenis Kelamin', 'label' => 'Perempuan', 'total' => 282]
    ];

    // Prepare insert statement
    $stmt = $pdo->prepare("
        INSERT INTO `data` (`data`, `label`, `total`, `created_at`, `updated_at`) 
        VALUES (?, ?, ?, NOW(), NOW())
    ");

    $inserted = 0;
    foreach ($sampleData as $record) {
        $stmt->execute([
            $record['data'],
            $record['label'],
            $record['total']
        ]);
        $inserted++;
    }

    echo "✅ Successfully inserted {$inserted} statistical records\n\n";

    // Verify data
    echo "🔍 Verifying data...\n";
    $stmt = $pdo->query("
        SELECT `data`, COUNT(*) as total_records, SUM(total) as total_population 
        FROM `data` 
        GROUP BY `data` 
        ORDER BY `data`
    ");

    echo "📊 Data Summary:\n";
    while ($row = $stmt->fetch()) {
        echo "   - {$row['data']}: {$row['total_records']} records, {$row['total_population']} total population\n";
    }

    echo "\n🎉 Production deployment completed successfully!\n";
    echo "✅ Data Statistik page should now work at: https://mekarmukti.id/admin/data-management\n";

} catch (PDOException $e) {
    echo "❌ Database error: " . $e->getMessage() . "\n";
    echo "Please check your database credentials and make sure the database exists.\n";
} catch (Exception $e) {
    echo "❌ Error during deployment: " . $e->getMessage() . "\n";
}
