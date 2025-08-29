<?php

require_once 'vendor/autoload.php';

// Load Laravel app
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    echo "=== STATISTIK TABLE STRUCTURE ===" . PHP_EOL;
    
    $columns = DB::select("PRAGMA table_info(statistik)");
    
    echo "📋 Columns in statistik table:" . PHP_EOL;
    foreach ($columns as $column) {
        echo "   - {$column->name} ({$column->type}) " . ($column->notnull ? "[NOT NULL]" : "[NULLABLE]") . PHP_EOL;
    }
    
    echo "\n📊 Sample data (first 5 rows):" . PHP_EOL;
    $sampleData = DB::table('statistik')->limit(5)->get();
    
    if ($sampleData->count() > 0) {
        foreach ($sampleData as $row) {
            echo "   " . json_encode($row, JSON_PRETTY_PRINT) . PHP_EOL;
        }
    } else {
        echo "   No data found in statistik table" . PHP_EOL;
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . PHP_EOL;
}
