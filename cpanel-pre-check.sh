<?php
/**
 * Script untuk cek status database dan migration di production
 */

require_once __DIR__ . '/vendor/autoload.php';

// Load Laravel environment
$app = require_once __DIR__ . '/bootstrap/app.php';

// Set database connection ke MySQL untuk production
putenv('DB_CONNECTION=mysql');

// Bootstrap Laravel
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "=== PRODUCTION DATABASE CHECK ===" . PHP_EOL;

try {
    // Test database connection
    $connection = DB::connection();
    $dbName = $connection->getDatabaseName();
    echo "✅ Connected to database: {$dbName}" . PHP_EOL;
    
    // Check if migrations table exists
    $migrationsExists = Schema::hasTable('migrations');
    echo "Migrations table exists: " . ($migrationsExists ? '✅ Yes' : '❌ No') . PHP_EOL;
    
    // Check if statistik table exists
    $statistikExists = Schema::hasTable('statistik');
    echo "Statistik table exists: " . ($statistikExists ? '✅ Yes' : '❌ No') . PHP_EOL;
    
    if ($statistikExists) {
        $count = DB::table('statistik')->count();
        echo "Records in statistik table: {$count}" . PHP_EOL;
        
        if ($count > 0) {
            echo "\n=== SAMPLE DATA ===" . PHP_EOL;
            $samples = DB::table('statistik')->limit(5)->get();
            foreach ($samples as $row) {
                echo "ID: {$row->id} | Kategori: {$row->kategori} | Label: {$row->label} | Jumlah: {$row->jumlah}" . PHP_EOL;
            }
        }
    }
    
    // Check migrations run
    if ($migrationsExists) {
        echo "\n=== MIGRATION STATUS ===" . PHP_EOL;
        $migrations = DB::table('migrations')->orderBy('batch', 'desc')->get();
        foreach ($migrations as $migration) {
            echo "✓ {$migration->migration} (batch: {$migration->batch})" . PHP_EOL;
        }
        
        // Check specifically for statistik migration
        $statistikMigration = DB::table('migrations')->where('migration', 'like', '%create_statistik_table%')->first();
        if ($statistikMigration) {
            echo "\n✅ Statistik migration already run!" . PHP_EOL;
        } else {
            echo "\n❌ Statistik migration NOT found - need to run migration!" . PHP_EOL;
        }
    }
    
    // List all tables in database
    echo "\n=== ALL TABLES IN DATABASE ===" . PHP_EOL;
    $tables = DB::select('SHOW TABLES');
    foreach ($tables as $table) {
        $tableName = array_values((array) $table)[0];
        $count = DB::table($tableName)->count();
        echo "📋 {$tableName} ({$count} records)" . PHP_EOL;
    }
    
} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . PHP_EOL;
    echo "File: " . $e->getFile() . ":" . $e->getLine() . PHP_EOL;
}

echo "\n=== SOLUTION ===" . PHP_EOL;
echo "If statistik table doesn't exist, run:" . PHP_EOL;
echo "1. php artisan migrate" . PHP_EOL;
echo "2. php artisan db:seed --class=StatistikSeeder" . PHP_EOL;
echo "3. Clear cache: php artisan cache:clear" . PHP_EOL;
?>
