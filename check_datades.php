<?php
require_once 'vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

try {
    // Connect to MySQL database mekh7277_desa
    $host = $_ENV['MYSQL_POP_HOST'] ?? '127.0.0.1';
    $port = $_ENV['MYSQL_POP_PORT'] ?? '3306';
    $dbname = $_ENV['MYSQL_POP_DATABASE'] ?? 'mekh7277_desa';
    $username = $_ENV['MYSQL_POP_USERNAME'] ?? 'root';
    $password = $_ENV['MYSQL_POP_PASSWORD'] ?? '';
    
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✅ Connected to database: $dbname\n";
    
    // Check if datades table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'datades'");
    $tableExists = $stmt->rowCount() > 0;
    
    if (!$tableExists) {
        echo "❌ Table 'datades' does not exist. Creating table...\n";
        
        // Create datades table
        $createTable = "
            CREATE TABLE datades (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nama VARCHAR(255) NOT NULL,
                jenis_kelamin ENUM('Laki-laki', 'Perempuan') NOT NULL,
                umur INT,
                alamat TEXT,
                pekerjaan VARCHAR(255),
                agama VARCHAR(100),
                status_perkawinan VARCHAR(100),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ";
        
        $pdo->exec($createTable);
        echo "✅ Table 'datades' created successfully\n";
        
        // Insert sample data
        $insertData = "
            INSERT INTO datades (nama, jenis_kelamin, umur, alamat, pekerjaan, agama, status_perkawinan) VALUES
            ('Budi Santoso', 'Laki-laki', 35, 'RT 01/RW 01', 'Petani', 'Islam', 'Menikah'),
            ('Siti Rahayu', 'Perempuan', 32, 'RT 01/RW 01', 'Ibu Rumah Tangga', 'Islam', 'Menikah'),
            ('Ahmad Wijaya', 'Laki-laki', 28, 'RT 02/RW 01', 'Wiraswasta', 'Islam', 'Belum Menikah'),
            ('Rina Sari', 'Perempuan', 25, 'RT 02/RW 01', 'Guru', 'Islam', 'Belum Menikah'),
            ('Hendra Gunawan', 'Laki-laki', 45, 'RT 03/RW 01', 'PNS', 'Kristen', 'Menikah'),
            ('Maria Magdalena', 'Perempuan', 42, 'RT 03/RW 01', 'Perawat', 'Kristen', 'Menikah'),
            ('Joko Susilo', 'Laki-laki', 38, 'RT 01/RW 02', 'Karyawan Swasta', 'Islam', 'Menikah'),
            ('Dewi Lestari', 'Perempuan', 36, 'RT 01/RW 02', 'Dokter', 'Islam', 'Menikah'),
            ('Rudi Hartono', 'Laki-laki', 29, 'RT 02/RW 02', 'Mekanik', 'Islam', 'Belum Menikah'),
            ('Ani Suryani', 'Perempuan', 27, 'RT 02/RW 02', 'Penjahit', 'Islam', 'Belum Menikah'),
            ('Bambang Prasetyo', 'Laki-laki', 40, 'RT 03/RW 02', 'Pedagang', 'Islam', 'Menikah'),
            ('Sri Wahyuni', 'Perempuan', 38, 'RT 03/RW 02', 'Ibu Rumah Tangga', 'Islam', 'Menikah'),
            ('Dedi Kurniawan', 'Laki-laki', 33, 'RT 01/RW 03', 'Supir', 'Islam', 'Menikah'),
            ('Lisa Permata', 'Perempuan', 31, 'RT 01/RW 03', 'Bidan', 'Islam', 'Menikah'),
            ('Agus Setiawan', 'Laki-laki', 26, 'RT 02/RW 03', 'Mahasiswa', 'Islam', 'Belum Menikah'),
            ('Fitri Handayani', 'Perempuan', 24, 'RT 02/RW 03', 'Mahasiswa', 'Islam', 'Belum Menikah'),
            ('Wawan Kurniadi', 'Laki-laki', 41, 'RT 03/RW 03', 'Tukang Bangunan', 'Islam', 'Menikah'),
            ('Yuli Astuti', 'Perempuan', 39, 'RT 03/RW 03', 'Ibu Rumah Tangga', 'Islam', 'Menikah'),
            ('Eko Prasetyo', 'Laki-laki', 34, 'RT 01/RW 04', 'Teknisi', 'Islam', 'Menikah'),
            ('Indah Sari', 'Perempuan', 32, 'RT 01/RW 04', 'Akuntan', 'Islam', 'Menikah');
        ";
        
        $pdo->exec($insertData);
        echo "✅ Sample data inserted successfully\n";
    } else {
        echo "✅ Table 'datades' already exists\n";
    }
    
    // Check current data count
    $stmt = $pdo->query("SELECT jenis_kelamin, COUNT(*) as total FROM datades GROUP BY jenis_kelamin");
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "\n📊 Current population statistics:\n";
    foreach ($results as $row) {
        echo "- {$row['jenis_kelamin']}: {$row['total']} orang\n";
    }
    
    $totalStmt = $pdo->query("SELECT COUNT(*) as total FROM datades");
    $total = $totalStmt->fetch(PDO::FETCH_ASSOC);
    echo "- Total: {$total['total']} orang\n";
    
} catch (PDOException $e) {
    echo "❌ Connection failed: " . $e->getMessage() . "\n";
    echo "Please make sure:\n";
    echo "1. MySQL server is running\n";
    echo "2. Database 'mekh7277_desa' exists\n";
    echo "3. Credentials in .env file are correct\n";
}
?>
