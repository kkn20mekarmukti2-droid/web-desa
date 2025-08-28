<?php

require_once 'vendor/autoload.php';

// Load Laravel app
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\StatistikModel;

try {
    echo "=== TAMBAH DATA TEST UNTUK CHART ===" . PHP_EOL;
    
    // Data Jenis Kelamin
    StatistikModel::create([
        'kategori' => 'jenis_kelamin',
        'label' => 'Laki-laki',
        'jumlah' => 1250,
        'deskripsi' => 'Penduduk laki-laki'
    ]);
    
    StatistikModel::create([
        'kategori' => 'jenis_kelamin',
        'label' => 'Perempuan', 
        'jumlah' => 1180,
        'deskripsi' => 'Penduduk perempuan'
    ]);
    
    // Data Agama
    StatistikModel::create([
        'kategori' => 'agama',
        'label' => 'Islam',
        'jumlah' => 2100,
        'deskripsi' => 'Penduduk beragama Islam'
    ]);
    
    StatistikModel::create([
        'kategori' => 'agama',
        'label' => 'Kristen',
        'jumlah' => 180,
        'deskripsi' => 'Penduduk beragama Kristen'
    ]);
    
    // Data Pekerjaan
    StatistikModel::create([
        'kategori' => 'pekerjaan',
        'label' => 'Petani',
        'jumlah' => 850,
        'deskripsi' => 'Petani dan pekebun'
    ]);
    
    StatistikModel::create([
        'kategori' => 'pekerjaan',
        'label' => 'Wiraswasta',
        'jumlah' => 420,
        'deskripsi' => 'Pengusaha dan pedagang'
    ]);
    
    echo "✅ Berhasil menambah data test!" . PHP_EOL;
    echo "Total data: " . StatistikModel::count() . PHP_EOL;
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . PHP_EOL;
}
