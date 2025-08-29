<?php

use App\Models\StatistikModel;

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Updating RT/RW data...\n";

// Delete old rt_rw data
$deleted = StatistikModel::where('kategori', 'rt_rw')->delete();
echo "Deleted {$deleted} old RT/RW records\n";

// Insert new rt_rw data  
StatistikModel::create([
    'kategori' => 'rt_rw', 
    'label' => 'Total RT', 
    'jumlah' => 3, 
    'deskripsi' => 'Jumlah Rukun Tetangga di desa'
]);

StatistikModel::create([
    'kategori' => 'rt_rw', 
    'label' => 'Total RW', 
    'jumlah' => 2, 
    'deskripsi' => 'Jumlah Rukun Warga di desa'
]);

echo "✅ RT/RW data updated successfully!\n";
echo "- Total RT: 3\n";
echo "- Total RW: 2\n";
