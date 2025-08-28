<?php

require_once 'vendor/autoload.php';

// Load Laravel app
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    echo "=== CLEAR LEGACY DATA TABLE ===" . PHP_EOL;
    
    // Check specific data types
    $types = ['penduduk', 'agama', 'pekerjaan'];
    
    foreach ($types as $type) {
        $count = DB::table('data')->where('data', $type)->count();
        echo "Data {$type} sebelum dihapus: {$count} records" . PHP_EOL;
        
        $deleted = DB::table('data')->where('data', $type)->delete();
        echo "Berhasil menghapus {$deleted} records untuk {$type}" . PHP_EOL;
    }
    
    echo "\n=== VERIFIKASI ===" . PHP_EOL;
    foreach ($types as $type) {
        $remaining = DB::table('data')->where('data', $type)->count();
        echo "Data {$type} yang tersisa: {$remaining} records" . PHP_EOL;
    }
    
    $totalRemaining = DB::table('data')->count();
    echo "\nTotal data yang tersisa di tabel 'data': {$totalRemaining}" . PHP_EOL;
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . PHP_EOL;
}
