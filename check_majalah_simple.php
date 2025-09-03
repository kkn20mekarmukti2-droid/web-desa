<?php

require_once 'check_database.php';

echo "=== CHECKING MAJALAH TABLE ===\n";

try {
    // Check if table exists
    $stmt = $pdo->query("SELECT name FROM sqlite_master WHERE type='table' AND name='majalah'");
    if (!$stmt->fetch()) {
        echo "❌ Table 'majalah' tidak ditemukan!\n";
        echo "Mari buat table baru...\n";
        
        // Create simple majalah table
        $createTable = "
        CREATE TABLE majalah (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            judul VARCHAR(255) NOT NULL,
            cover_image VARCHAR(255),
            total_pages INTEGER DEFAULT 0,
            folder_path VARCHAR(255),
            is_active BOOLEAN DEFAULT 1,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )";
        
        $pdo->exec($createTable);
        echo "✅ Table majalah berhasil dibuat!\n";
    } else {
        echo "✅ Table majalah sudah ada\n";
    }
    
    // Get table structure
    $stmt = $pdo->query("PRAGMA table_info(majalah)");
    echo "\n📋 Columns in majalah table:\n";
    
    while ($column = $stmt->fetch()) {
        $nullable = $column['notnull'] ? '[NOT NULL]' : '[NULLABLE]';
        echo "   - {$column['name']} ({$column['type']}) $nullable\n";
    }
    
    // Count total records
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM majalah");
    $total = $stmt->fetch()['total'];
    echo "\n📈 Total records: $total\n";
    
    if ($total > 0) {
        $stmt = $pdo->query("SELECT * FROM majalah LIMIT 5");
        echo "\n📊 Sample data:\n";
        while ($row = $stmt->fetch()) {
            echo "   - ID: {$row['id']}, Judul: {$row['judul']}\n";
        }
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

?>
