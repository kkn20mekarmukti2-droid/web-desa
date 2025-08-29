<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== CURRENT DATABASE STATUS ===\n\n";

try {
    // Check statistik table content
    echo "📊 STATISTIK TABLE:\n";
    $statistik = DB::table('statistik')->orderBy('kategori')->orderBy('label')->get();
    $count = $statistik->count();
    echo "   Total records: $count\n\n";
    
    if ($count > 0) {
        foreach ($statistik as $data) {
            echo "   📋 {$data->kategori} | {$data->label} | {$data->jumlah}\n";
        }
    }
    
    echo "\n=== RT/RW SPECIFIC DATA ===\n";
    $rtRwData = DB::table('statistik')->where('kategori', 'rt_rw')->get();
    echo "RT/RW records: " . $rtRwData->count() . "\n";
    foreach ($rtRwData as $data) {
        echo "   🏠 {$data->label}: {$data->jumlah} - {$data->deskripsi}\n";
    }
    
    echo "\n=== KK SPECIFIC DATA ===\n";
    $kkData = DB::table('statistik')->where('kategori', 'kk')->get();
    echo "KK records: " . $kkData->count() . "\n";
    foreach ($kkData as $data) {
        echo "   📋 {$data->label}: {$data->jumlah} - {$data->deskripsi}\n";
    }
    
    // Check if we have legacy data table
    echo "\n=== LEGACY TABLES CHECK ===\n";
    $tables = DB::select("SELECT name FROM sqlite_master WHERE type='table'");
    $tableNames = array_map(function($table) { return $table->name; }, $tables);
    
    if (in_array('data', $tableNames)) {
        $legacyCount = DB::table('data')->count();
        echo "❌ Legacy 'data' table found with $legacyCount records\n";
        
        if ($legacyCount > 0) {
            $legacyTypes = DB::table('data')->distinct()->pluck('data');
            echo "   Types: " . implode(', ', $legacyTypes->toArray()) . "\n";
        }
    } else {
        echo "✅ No legacy 'data' table found\n";
    }
    
    if (in_array('datades', $tableNames)) {
        $legacyCount = DB::table('datades')->count();
        echo "❌ Legacy 'datades' table found with $legacyCount records\n";
    } else {
        echo "✅ No legacy 'datades' table found\n";
    }
    
    if (in_array('rw', $tableNames)) {
        $rwCount = DB::table('rw')->count();
        echo "📍 RW table found with $rwCount records\n";
    }
    
    if (in_array('rt', $tableNames)) {
        $rtCount = DB::table('rt')->count();
        echo "📍 RT table found with $rtCount records\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\n=== RECOMMENDATION ===\n";
echo "If RT/RW/KK data not showing:\n";
echo "1. Clear all legacy/dummy data from statistik table\n";
echo "2. Populate with real data from imported database\n";
echo "3. Or manually add RT/RW/KK data via admin interface\n";
