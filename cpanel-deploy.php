<?php

echo "🚀 CPANEL DATABASE CLEANUP DEPLOYMENT\n";
echo "====================================\n\n";

require_once 'vendor/autoload.php';

// Load Laravel app
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    $timestamp = date('Y-m-d H:i:s');
    echo "📅 Deployment started at: {$timestamp}\n\n";

    // Step 1: Check current state
    echo "📊 STEP 1: Checking current database state...\n";
    $currentCount = DB::table('statistik')->count();
    echo "   Current statistik records: {$currentCount}\n";
    
    if ($currentCount > 0) {
        echo "   Sample records:\n";
        $samples = DB::table('statistik')->limit(3)->get();
        foreach ($samples as $sample) {
            echo "   - {$sample->kategori} | {$sample->label} | {$sample->jumlah}\n";
        }
    }
    echo "\n";

    // Step 2: Create backup (simple approach)
    echo "💾 STEP 2: Creating simple backup...\n";
    $backupData = DB::table('statistik')->get();
    $backupFile = "database/backup_statistik_" . date('Ymd_His') . ".json";
    
    // Create directory if it doesn't exist
    if (!is_dir('database')) {
        mkdir('database', 0755, true);
    }
    
    file_put_contents($backupFile, json_encode($backupData, JSON_PRETTY_PRINT));
    echo "   ✅ Backup saved to: {$backupFile}\n\n";

    // Step 3: Run cleanup
    echo "🗑️ STEP 3: Running database cleanup...\n";
    
    // Clear old data
    $deletedCount = DB::table('statistik')->delete();
    echo "   Deleted {$deletedCount} old records\n";
    
    // Insert real data
    $insertData = [
        [
            'kategori' => 'rt_rw',
            'label' => 'Total RT',
            'jumlah' => 12,
            'deskripsi' => 'Jumlah Rukun Tetangga di desa',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'kategori' => 'rt_rw',
            'label' => 'Total RW',
            'jumlah' => 4,
            'deskripsi' => 'Jumlah Rukun Warga di desa',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'kategori' => 'kk',
            'label' => 'KK Kepala Laki-laki',
            'jumlah' => 850,
            'deskripsi' => 'Kartu keluarga dengan kepala keluarga laki-laki',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'kategori' => 'kk',
            'label' => 'KK Kepala Perempuan',
            'jumlah' => 235,
            'deskripsi' => 'Kartu keluarga dengan kepala keluarga perempuan',
            'created_at' => now(),
            'updated_at' => now()
        ]
    ];
    
    DB::table('statistik')->insert($insertData);
    echo "   ✅ Inserted 4 real data records\n\n";

    // Step 4: Verify results
    echo "🔍 STEP 4: Verifying cleanup results...\n";
    $finalCount = DB::table('statistik')->count();
    echo "   Final record count: {$finalCount}\n";
    
    // Check RT/RW uniqueness
    $rtCount = DB::table('statistik')->where('kategori', 'rt_rw')->where('label', 'Total RT')->count();
    $rwCount = DB::table('statistik')->where('kategori', 'rt_rw')->where('label', 'Total RW')->count();
    echo "   RT entries: {$rtCount} (should be 1)\n";
    echo "   RW entries: {$rwCount} (should be 1)\n";
    
    // Show final data
    echo "\n   📋 Final data structure:\n";
    $finalData = DB::table('statistik')->orderBy('kategori')->get();
    foreach ($finalData as $record) {
        echo "   - {$record->kategori} | {$record->label} | {$record->jumlah}\n";
    }
    echo "\n";

    // Step 5: Cache clearing (if artisan is available)
    echo "🧹 STEP 5: Clearing application caches...\n";
    
    try {
        // Try to clear caches
        $output = [];
        exec('php artisan cache:clear 2>&1', $output, $return_var);
        if ($return_var === 0) {
            echo "   ✅ Application cache cleared\n";
        } else {
            echo "   ⚠️ Could not clear cache (not critical)\n";
        }
    } catch (Exception $e) {
        echo "   ⚠️ Cache clearing skipped (not critical)\n";
    }
    echo "\n";

    // Step 6: Final verification
    echo "🎯 STEP 6: Final verification...\n";
    
    $success = true;
    
    if ($finalCount !== 4) {
        echo "   ❌ Expected 4 records, found {$finalCount}\n";
        $success = false;
    } else {
        echo "   ✅ Record count correct: 4\n";
    }
    
    if ($rtCount !== 1 || $rwCount !== 1) {
        echo "   ❌ RT/RW data has duplicates\n";
        $success = false;
    } else {
        echo "   ✅ RT/RW data is unique\n";
    }
    
    // Test data values
    $rtValue = DB::table('statistik')->where('kategori', 'rt_rw')->where('label', 'Total RT')->value('jumlah');
    $rwValue = DB::table('statistik')->where('kategori', 'rt_rw')->where('label', 'Total RW')->value('jumlah');
    
    if ($rtValue == 12 && $rwValue == 4) {
        echo "   ✅ RT/RW values correct: RT={$rtValue}, RW={$rwValue}\n";
    } else {
        echo "   ⚠️ RT/RW values: RT={$rtValue}, RW={$rwValue}\n";
    }
    
    echo "\n";

    // Step 7: Deployment summary
    echo "📋 DEPLOYMENT SUMMARY\n";
    echo "====================\n";
    echo "🕐 Completed at: " . date('Y-m-d H:i:s') . "\n";
    echo "💾 Backup saved: {$backupFile}\n";
    echo "📊 Final records: {$finalCount}\n";
    echo "🏠 RT count: {$rtValue} (12 Rukun Tetangga)\n";
    echo "🏘️ RW count: {$rwValue} (4 Rukun Warga)\n";
    echo "👨‍👩‍👧‍👦 KK Laki-laki: 850 families\n";
    echo "👩‍👧‍👦 KK Perempuan: 235 families\n\n";
    
    if ($success) {
        echo "🎉 DEPLOYMENT SUCCESSFUL!\n\n";
        echo "💡 Next steps:\n";
        echo "   1. Visit your admin dashboard: /admin/data-statistik\n";
        echo "   2. Verify RT shows '12' and RW shows '4'\n";
        echo "   3. Check that KK data displays correctly\n";
        echo "   4. Test that charts work properly\n";
        echo "   5. Confirm no 'Data Wilayah' text appears\n\n";
        echo "🌐 Your dashboard should now display:\n";
        echo "   - RT card: 12 (count, not population)\n";
        echo "   - RW card: 4 (count, not population)\n";
        echo "   - KK cards: Family head counts\n";
        echo "   - Working charts with clean data\n";
    } else {
        echo "⚠️ DEPLOYMENT COMPLETED WITH WARNINGS\n";
        echo "   Please check the issues mentioned above\n";
        echo "   You may need to run this script again\n";
    }

} catch (Exception $e) {
    echo "❌ DEPLOYMENT ERROR\n";
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n\n";
    echo "💡 Troubleshooting:\n";
    echo "   1. Check database connection in .env file\n";
    echo "   2. Ensure Laravel is properly installed\n";
    echo "   3. Try running: php check_statistik_data.php\n";
}

echo "\n✅ Deployment script completed\n";
echo "📞 For support, check logs above\n";

?>
