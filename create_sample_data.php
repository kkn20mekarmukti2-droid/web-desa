<?php

require_once 'vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

use Illuminate\Support\Facades\DB;

try {
    // Clear existing data
    DB::table('data')->delete();
    
    // Sample data categories with records
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
    
    // Insert sample data
    foreach ($sampleData as $record) {
        DB::table('data')->insert([
            'data' => $record['data'],
            'label' => $record['label'],
            'total' => $record['total'],
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
    
    echo "✅ Sample data created successfully!\n";
    echo "Created " . count($sampleData) . " data records across multiple categories\n";
    
    // Show summary
    $categories = DB::table('data')
        ->select('data', DB::raw('COUNT(*) as count'), DB::raw('SUM(total) as total'))
        ->groupBy('data')
        ->get();
        
    echo "\n📊 Data Summary:\n";
    foreach ($categories as $cat) {
        echo "- {$cat->data}: {$cat->count} records, {$cat->total} total population\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
