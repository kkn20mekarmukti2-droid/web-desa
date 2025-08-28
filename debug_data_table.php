<?php

require_once 'vendor/autoload.php';

// Load Laravel app
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    echo "=== DEBUG TABEL DATA (LEGACY) ===" . PHP_EOL;
    
    // Check if table exists
    $tables = DB::select("SELECT name FROM sqlite_master WHERE type='table' AND name='data'");
    if (empty($tables)) {
        echo "❌ Tabel 'data' tidak ada" . PHP_EOL;
        return;
    }
    
    echo "✅ Tabel 'data' ditemukan" . PHP_EOL;
    
    // Get all data
    $allData = DB::table('data')->get();
    echo "Total records di tabel data: " . $allData->count() . PHP_EOL;
    
    if ($allData->count() > 0) {
        echo "\n=== DATA BY TYPE ===" . PHP_EOL;
        $groupedData = $allData->groupBy('data');
        
        foreach ($groupedData as $type => $records) {
            echo "Type: {$type} ({$records->count()} records)" . PHP_EOL;
            foreach ($records as $record) {
                echo "  - {$record->label}: {$record->total}" . PHP_EOL;
            }
            echo PHP_EOL;
        }
        
        // Show specific data for penduduk, agama, pekerjaan
        echo "=== SPECIFIC CHECKS ===" . PHP_EOL;
        $pendudukData = DB::table('data')->where('data', 'penduduk')->get();
        echo "Penduduk data: " . $pendudukData->count() . " records" . PHP_EOL;
        
        $agamaData = DB::table('data')->where('data', 'agama')->get();
        echo "Agama data: " . $agamaData->count() . " records" . PHP_EOL;
        
        $pekerjaanData = DB::table('data')->where('data', 'pekerjaan')->get();
        echo "Pekerjaan data: " . $pekerjaanData->count() . " records" . PHP_EOL;
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . PHP_EOL;
}
