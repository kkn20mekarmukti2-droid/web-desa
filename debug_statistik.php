<?php

// Debug script untuk cek data statistik
require_once 'vendor/autoload.php';

// Load Laravel environment
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\StatistikModel;
use Illuminate\Support\Facades\DB;

echo "=== DEBUG DATA STATISTIK ===\n\n";

try {
    // Cek semua data di tabel statistik
    $allData = StatistikModel::all();
    echo "Total data di tabel statistik: " . $allData->count() . "\n";
    
    foreach ($allData as $data) {
        echo "ID: {$data->id}, Kategori: {$data->kategori}, Label: {$data->label}, Jumlah: {$data->jumlah}\n";
    }
    
    echo "\n=== DATA BY KATEGORI ===\n";
    
    // Cek data jenis kelamin
    $jenisKelamin = StatistikModel::getDataByKategori('jenis_kelamin');
    echo "Data jenis kelamin: " . $jenisKelamin->count() . " records\n";
    foreach ($jenisKelamin as $data) {
        echo "- {$data->label}: {$data->jumlah}\n";
    }
    
    // Cek data agama
    $agama = StatistikModel::getDataByKategori('agama');
    echo "Data agama: " . $agama->count() . " records\n";
    foreach ($agama as $data) {
        echo "- {$data->label}: {$data->jumlah}\n";
    }
    
    // Cek data pekerjaan
    $pekerjaan = StatistikModel::getDataByKategori('pekerjaan');
    echo "Data pekerjaan: " . $pekerjaan->count() . " records\n";
    foreach ($pekerjaan as $data) {
        echo "- {$data->label}: {$data->jumlah}\n";
    }
    
    echo "\n=== TEST API ENDPOINT ===\n";
    
    // Test endpoint langsung
    $baseUrl = 'http://localhost/web-desa/public';
    
    $endpoints = [
        'penduduk' => $baseUrl . '/getdatades?type=penduduk',
        'agama' => $baseUrl . '/getdatades?type=agama', 
        'pekerjaan' => $baseUrl . '/getdatades?type=pekerjaan'
    ];
    
    foreach ($endpoints as $type => $url) {
        echo "Testing $type endpoint: $url\n";
        $response = file_get_contents($url);
        echo "Response: $response\n\n";
    }
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}

?>
