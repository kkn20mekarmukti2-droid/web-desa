<?php
/**
 * Create Sample APBDes Data for Testing
 * Run: php create_sample_apbdes.php
 */

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Apbdes;
use Illuminate\Support\Facades\Storage;

echo "=== Creating Sample APBDes Data ===\n\n";

// Sample APBDes data
$sampleData = [
    [
        'judul' => 'APBDes 2024 - Rencana Anggaran Pendapatan dan Belanja Desa',
        'deskripsi' => 'Dokumen APBDes untuk tahun anggaran 2024 yang memuat rencana pendapatan dan belanja desa Mekar Mukti.',
        'file_path' => 'apbdes_2024_final.pdf',
        'tahun' => 2024,
        'is_active' => true
    ],
    [
        'judul' => 'Laporan Realisasi APBDes 2023',
        'deskripsi' => 'Laporan realisasi anggaran pendapatan dan belanja desa untuk tahun 2023.',
        'file_path' => 'realisasi_apbdes_2023.pdf', 
        'tahun' => 2023,
        'is_active' => true
    ],
    [
        'judul' => 'APBDes Perubahan 2024 - Semester I',
        'deskripsi' => 'Dokumen perubahan APBDes tahun 2024 untuk semester pertama.',
        'file_path' => 'apbdes_perubahan_2024_s1.pdf',
        'tahun' => 2024, 
        'is_active' => true
    ],
    [
        'judul' => 'Rancangan APBDes 2025',
        'deskripsi' => 'Rancangan anggaran pendapatan dan belanja desa untuk tahun 2025.',
        'file_path' => 'rancangan_apbdes_2025.pdf',
        'tahun' => 2025,
        'is_active' => true
    ],
    [
        'judul' => 'Laporan Keuangan Desa 2023',
        'deskripsi' => 'Laporan keuangan lengkap desa Mekar Mukti untuk tahun 2023.',
        'file_path' => 'laporan_keuangan_2023.pdf',
        'tahun' => 2023,
        'is_active' => true
    ],
    [
        'judul' => 'APBDes 2022 - Laporan Akhir',
        'deskripsi' => 'Laporan akhir pelaksanaan APBDes tahun 2022.',
        'file_path' => 'apbdes_2022_laporan_akhir.pdf',
        'tahun' => 2022,
        'is_active' => true
    ]
];

// Create APBDes records
$created = 0;
foreach ($sampleData as $data) {
    try {
        $apbdes = Apbdes::create($data);
        echo "✅ Created: {$apbdes->judul} (ID: {$apbdes->id})\n";
        $created++;
    } catch (Exception $e) {
        echo "❌ Error creating: {$data['judul']} - {$e->getMessage()}\n";
    }
}

echo "\n=== Summary ===\n";
echo "Created: {$created} APBDes records\n";
echo "Total APBDes: " . Apbdes::count() . "\n";
echo "Active APBDes: " . Apbdes::where('is_active', true)->count() . "\n";

echo "\n=== Testing getActive() Method ===\n";
$activeApbdes = Apbdes::getActive();
echo "Paginated Active APBDes: {$activeApbdes->total()} total, showing {$activeApbdes->count()} per page\n";

foreach ($activeApbdes as $apbdes) {
    echo "- {$apbdes->judul} ({$apbdes->tahun})\n";
}

echo "\n✅ Sample APBDes data creation completed!\n";
echo "👉 Now test: http://127.0.0.1:8000/transparansi-anggaran\n";
