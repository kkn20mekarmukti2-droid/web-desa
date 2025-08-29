<?php

require_once 'vendor/autoload.php';
require_once 'bootstrap/app.php';

use Illuminate\Support\Facades\DB;

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->boot();

// Clear existing data
DB::table('rt')->delete();
DB::table('rw')->delete();

// Create sample RW data
$rwData = [
    ['nomor_rw' => '001', 'jumlah_kk' => 125],
    ['nomor_rw' => '002', 'jumlah_kk' => 98],
    ['nomor_rw' => '003', 'jumlah_kk' => 142],
    ['nomor_rw' => '004', 'jumlah_kk' => 87],
    ['nomor_rw' => '005', 'jumlah_kk' => 156]
];

foreach($rwData as $data) {
    DB::table('rw')->insert([
        'nomor_rw' => $data['nomor_rw'],
        'jumlah_kk' => $data['jumlah_kk'],
        'created_at' => now(),
        'updated_at' => now()
    ]);
}

// Get RW IDs
$rwIds = DB::table('rw')->pluck('id', 'nomor_rw')->toArray();

// Create sample RT data
$rtData = [
    // RW 001
    ['nomor_rt' => '001', 'rw_nomor' => '001', 'jumlah_kk' => 32],
    ['nomor_rt' => '002', 'rw_nomor' => '001', 'jumlah_kk' => 28],
    ['nomor_rt' => '003', 'rw_nomor' => '001', 'jumlah_kk' => 35],
    ['nomor_rt' => '004', 'rw_nomor' => '001', 'jumlah_kk' => 30],
    
    // RW 002
    ['nomor_rt' => '001', 'rw_nomor' => '002', 'jumlah_kk' => 25],
    ['nomor_rt' => '002', 'rw_nomor' => '002', 'jumlah_kk' => 38],
    ['nomor_rt' => '003', 'rw_nomor' => '002', 'jumlah_kk' => 35],
    
    // RW 003
    ['nomor_rt' => '001', 'rw_nomor' => '003', 'jumlah_kk' => 45],
    ['nomor_rt' => '002', 'rw_nomor' => '003', 'jumlah_kk' => 42],
    ['nomor_rt' => '003', 'rw_nomor' => '003', 'jumlah_kk' => 55],
    
    // RW 004
    ['nomor_rt' => '001', 'rw_nomor' => '004', 'jumlah_kk' => 43],
    ['nomor_rt' => '002', 'rw_nomor' => '004', 'jumlah_kk' => 44],
    
    // RW 005
    ['nomor_rt' => '001', 'rw_nomor' => '005', 'jumlah_kk' => 52],
    ['nomor_rt' => '002', 'rw_nomor' => '005', 'jumlah_kk' => 48],
    ['nomor_rt' => '003', 'rw_nomor' => '005', 'jumlah_kk' => 56]
];

foreach($rtData as $data) {
    DB::table('rt')->insert([
        'nomor_rt' => $data['nomor_rt'],
        'rw_id' => $rwIds[$data['rw_nomor']],
        'jumlah_kk' => $data['jumlah_kk'],
        'created_at' => now(),
        'updated_at' => now()
    ]);
}

echo "Sample RT/RW data created successfully!\n";
echo "Created " . count($rwData) . " RW records\n";
echo "Created " . count($rtData) . " RT records\n";
