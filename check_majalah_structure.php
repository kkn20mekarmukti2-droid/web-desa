<?php

require_once 'check_database.php';

echo "=== MAJALAH TABLE STRUCTURE ===\n";

try {
    // Check if table exists
    $stmt = $pdo->query("SELECT name FROM sqlite_master WHERE type='table' AND name='majalah'");
    if (!$stmt->fetch()) {
        echo "❌ Table 'majalah' tidak ditemukan!\n";
        exit;
    }
    
    // Get table structure
    $stmt = $pdo->query("PRAGMA table_info(majalah)");
    echo "📋 Columns in majalah table:\n";
    
    $columns = [];
    while ($column = $stmt->fetch()) {
        $nullable = $column['notnull'] ? '[NOT NULL]' : '[NULLABLE]';
        echo "   - {$column['name']} ({$column['type']}) $nullable\n";
        $columns[] = $column['name'];
    }
    
    // Get sample data
    echo "\n📊 Sample data (first 5 rows):\n";
    $stmt = $pdo->query("SELECT * FROM majalah LIMIT 5");
    $found = false;
    while ($row = $stmt->fetch()) {
        $found = true;
        echo "   - ID: {$row['id']}\n";
        foreach ($columns as $col) {
            if ($col !== 'id' && isset($row[$col])) {
                $value = is_string($row[$col]) ? "'{$row[$col]}'" : $row[$col];
                echo "     {$col}: $value\n";
            }
        }
        echo "\n";
    }
    
    if (!$found) {
        echo "   No data found in majalah table\n";
    }
    
    // Count total records
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM majalah");
    $total = $stmt->fetch()['total'];
    echo "\n📈 Total records: $total\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

?>
