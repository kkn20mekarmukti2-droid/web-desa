<?php

// Production deployment script for cPanel
// This script should be run on the production server

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "🚀 Production Deployment - Data Statistik Setup\n";
echo "==============================================\n\n";

// Check if we're in production environment
if (!isset($_SERVER['HTTP_HOST']) || !str_contains($_SERVER['HTTP_HOST'], 'mekarmukti.id')) {
    echo "⚠️  This script should be run on production server\n";
    echo "Current host: " . ($_SERVER['HTTP_HOST'] ?? 'localhost') . "\n\n";
}

require_once __DIR__ . '/vendor/autoload.php';

try {
    // Bootstrap Laravel
    $app = require_once __DIR__ . '/bootstrap/app.php';
    
    echo "📋 Checking database connection...\n";
    
    // Test database connection
    try {
        $connection = DB::connection();
        $dbName = $connection->getDatabaseName();
        echo "✅ Connected to database: {$dbName}\n\n";
    } catch (Exception $e) {
        echo "❌ Database connection failed: " . $e->getMessage() . "\n";
        exit(1);
    }

    // Check if data table exists
    echo "🔍 Checking data table...\n";
    if (Schema::hasTable('data')) {
        $count = DB::table('data')->count();
        echo "✅ Data table exists with {$count} records\n";
        
        if ($count > 0) {
            echo "📊 Current categories:\n";
            $categories = DB::table('data')
                ->select('data', DB::raw('COUNT(*) as count'))
                ->groupBy('data')
                ->get();
            foreach ($categories as $cat) {
                echo "   - {$cat->data}: {$cat->count} records\n";
            }
            echo "\n✅ Data table already populated. Deployment complete!\n";
            exit(0);
        }
    } else {
        echo "⚠️  Data table does not exist. Creating...\n";
        
        // Create data table
        Schema::create('data', function ($table) {
            $table->id();
            $table->string('data');  // Category name
            $table->string('label'); // Label within category
            $table->integer('total'); // Count/total for this label
            $table->timestamps();
        });
        
        echo "✅ Data table created successfully\n";
    }

    // Insert sample data
    echo "📊 Inserting sample statistical data...\n";
    
    $sampleData = [
        // Pendidikan
        ['data' => 'Pendidikan', 'label' => 'Tidak Tamat SD', 'total' => 45],
        ['data' => 'Pendidikan', 'label' => 'Tamat SD', 'total' => 128],
        ['data' => 'Pendidikan', 'label' => 'Tamat SMP', 'total' => 97],
        ['data' => 'Pendidikan', 'label' => 'Tamat SMA', 'total' => 156],
        ['data' => 'Pendidikan', 'label' => 'Diploma/S1', 'total' => 73],
        ['data' => 'Pendidikan', 'label' => 'S2/S3', 'total' => 12],
        
        // Pekerjaan
        ['data' => 'Pekerjaan', 'label' => 'Petani', 'total' => 187],
        ['data' => 'Pekerjaan', 'label' => 'Buruh', 'total' => 94],
        ['data' => 'Pekerjaan', 'label' => 'Pedagang', 'total' => 52],
        ['data' => 'Pekerjaan', 'label' => 'PNS', 'total' => 28],
        ['data' => 'Pekerjaan', 'label' => 'Swasta', 'total' => 65],
        ['data' => 'Pekerjaan', 'label' => 'Pensiunan', 'total' => 19],
        ['data' => 'Pekerjaan', 'label' => 'Tidak Bekerja', 'total' => 67],
        
        // Usia
        ['data' => 'Usia', 'label' => '0-5 Tahun', 'total' => 78],
        ['data' => 'Usia', 'label' => '6-17 Tahun', 'total' => 142],
        ['data' => 'Usia', 'label' => '18-59 Tahun', 'total' => 287],
        ['data' => 'Usia', 'label' => '60+ Tahun', 'total' => 56],
        
        // Agama
        ['data' => 'Agama', 'label' => 'Islam', 'total' => 524],
        ['data' => 'Agama', 'label' => 'Kristen', 'total' => 28],
        ['data' => 'Agama', 'label' => 'Katolik', 'total' => 15],
        ['data' => 'Agama', 'label' => 'Hindu', 'total' => 3],
        ['data' => 'Agama', 'label' => 'Buddha', 'total' => 1],
        
        // Status Kawin
        ['data' => 'Status Kawin', 'label' => 'Belum Kawin', 'total' => 189],
        ['data' => 'Status Kawin', 'label' => 'Kawin', 'total' => 312],
        ['data' => 'Status Kawin', 'label' => 'Cerai Hidup', 'total' => 23],
        ['data' => 'Status Kawin', 'label' => 'Cerai Mati', 'total' => 47],
        
        // Jenis Kelamin
        ['data' => 'Jenis Kelamin', 'label' => 'Laki-laki', 'total' => 289],
        ['data' => 'Jenis Kelamin', 'label' => 'Perempuan', 'total' => 282]
    ];

    $inserted = 0;
    foreach ($sampleData as $record) {
        DB::table('data')->insert([
            'data' => $record['data'],
            'label' => $record['label'],
            'total' => $record['total'],
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $inserted++;
    }

    echo "✅ Successfully inserted {$inserted} statistical records\n\n";

    // Verify data
    echo "🔍 Verifying data...\n";
    $categories = DB::table('data')
        ->select('data', DB::raw('COUNT(*) as total_records'), DB::raw('SUM(total) as total_population'))
        ->groupBy('data')
        ->orderBy('data')
        ->get();

    echo "📊 Data Summary:\n";
    foreach ($categories as $cat) {
        echo "   - {$cat->data}: {$cat->total_records} records, {$cat->total_population} total population\n";
    }

    echo "\n🎉 Production deployment completed successfully!\n";
    echo "✅ Data Statistik page should now work at: https://mekarmukti.id/admin/data-management\n";

} catch (Exception $e) {
    echo "❌ Error during deployment: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
