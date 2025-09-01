<?php
// Add sample structure data
require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\StrukturPemerintahan;

echo "=== ADDING SAMPLE STRUKTUR PEMERINTAHAN ===\n\n";

// Sample data based on existing structure
$strukturData = [
    [
        'nama' => 'ANDRIAWAN BURHANUDIN, SH',
        'jabatan' => 'Kepala Desa',
        'kategori' => 'kepala_desa',
        'urutan' => 1,
        'foto' => 'img/perangkat/kades.jpg',
        'pendidikan' => 'S1 Hukum',
        'is_active' => true
    ],
    [
        'nama' => 'YADI DAMANHURI, ST',
        'jabatan' => 'Sekretaris Desa',
        'kategori' => 'sekretaris',
        'urutan' => 2,
        'foto' => 'img/perangkat/sekdes.jpg',
        'pendidikan' => 'S1 Teknik',
        'is_active' => true
    ],
    [
        'nama' => 'NENG IA FITRI A',
        'jabatan' => 'Kepala Urusan Keuangan',
        'kategori' => 'kepala_urusan',
        'urutan' => 3,
        'foto' => 'img/perangkat/nengia.jpg',
        'is_active' => true
    ],
    [
        'nama' => 'WAHYU HADIAN, SE',
        'jabatan' => 'Kepala Urusan Perencanaan',
        'kategori' => 'kepala_urusan',
        'urutan' => 4,
        'foto' => 'img/perangkat/wahyu.jpg',
        'pendidikan' => 'S1 Ekonomi',
        'is_active' => true
    ],
    [
        'nama' => 'TISNA UNDAYA',
        'jabatan' => 'Kepala Urusan Tata Usaha',
        'kategori' => 'kepala_urusan',
        'urutan' => 5,
        'foto' => 'img/perangkat/uun.jpg',
        'is_active' => true
    ],
    [
        'nama' => 'LALAN JAELANI',
        'jabatan' => 'Kepala Seksi Kesejahteraan',
        'kategori' => 'kepala_seksi',
        'urutan' => 6,
        'foto' => 'img/perangkat/lalan.jpg',
        'is_active' => true
    ],
    [
        'nama' => 'ASFHA NUGRAHA ARIFIN',
        'jabatan' => 'Kepala Seksi Pemerintahan',
        'kategori' => 'kepala_seksi',
        'urutan' => 7,
        'foto' => 'img/perangkat/asfa.jpg',
        'is_active' => true
    ],
    [
        'nama' => 'DEWI LISTIANI ABIDIN',
        'jabatan' => 'Kepala Seksi Pelayanan',
        'kategori' => 'kepala_seksi',
        'urutan' => 8,
        'foto' => 'img/perangkat/dewi.jpg',
        'is_active' => true
    ],
    [
        'nama' => 'ENCEP MULYANA',
        'jabatan' => 'Kepala Dusun I',
        'kategori' => 'kepala_dusun',
        'urutan' => 9,
        'foto' => 'img/perangkat/encep.jpg',
        'is_active' => true
    ],
    [
        'nama' => 'AGUS RIDWAN',
        'jabatan' => 'Kepala Dusun II',
        'kategori' => 'kepala_dusun',
        'urutan' => 10,
        'foto' => 'img/perangkat/ridwan.jpg',
        'is_active' => true
    ],
    [
        'nama' => 'FEBRI HARDIANSYAH',
        'jabatan' => 'Kepala Dusun III',
        'kategori' => 'kepala_dusun',
        'urutan' => 11,
        'foto' => 'img/perangkat/febri.jpg',
        'is_active' => true
    ],
    [
        'nama' => 'PERI',
        'jabatan' => 'Kepala Dusun IV',
        'kategori' => 'kepala_dusun',
        'urutan' => 12,
        'foto' => 'img/perangkat/peri.jpg',
        'is_active' => true
    ]
];

foreach ($strukturData as $data) {
    try {
        StrukturPemerintahan::create($data);
        echo "✓ Added: {$data['nama']} - {$data['jabatan']}\n";
    } catch (\Exception $e) {
        echo "✗ Failed to add {$data['nama']}: {$e->getMessage()}\n";
    }
}

echo "\n=== SUMMARY ===\n";
echo "Total records: " . StrukturPemerintahan::count() . "\n";
echo "Active records: " . StrukturPemerintahan::active()->count() . "\n";

// Show by category
foreach (['kepala_desa', 'sekretaris', 'kepala_urusan', 'kepala_seksi', 'kepala_dusun'] as $kategori) {
    $count = StrukturPemerintahan::where('kategori', $kategori)->count();
    echo ucwords(str_replace('_', ' ', $kategori)) . ": {$count}\n";
}

echo "\nDone!\n";
?>
