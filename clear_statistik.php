<?php

require_once 'vendor/autoload.php';

// Load Laravel app
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\StatistikModel;

try {
    echo "=== CLEAR ALL STATISTIK DATA ===" . PHP_EOL;
    echo "Menghapus semua data statistik..." . PHP_EOL;
    
    // Delete all statistik data
    $deletedCount = StatistikModel::query()->delete();
    
    echo "Berhasil menghapus {$deletedCount} data statistik." . PHP_EOL;
    
    // Verify data is empty
    $remainingCount = StatistikModel::count();
    echo "Data yang tersisa: {$remainingCount}" . PHP_EOL;
    
    if ($remainingCount == 0) {
        echo "✅ Semua data statistik berhasil dihapus!" . PHP_EOL;
    } else {
        echo "⚠️  Masih ada {$remainingCount} data yang tersisa." . PHP_EOL;
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . PHP_EOL;
}
