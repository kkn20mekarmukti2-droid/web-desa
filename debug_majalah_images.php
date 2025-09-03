<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Majalah;

echo "DEBUG: Checking Majalah Images\n";
echo "=============================\n";

$majalah = Majalah::first();
if ($majalah) {
    echo "Magazine Title: " . $majalah->judul . "\n";
    echo "Cover Path in DB: " . $majalah->cover_image . "\n";
    
    // Test different paths
    $paths = [
        $majalah->cover_image,
        'majalah/' . str_replace('majalah/', '', $majalah->cover_image),
        'storage/' . $majalah->cover_image,
        'galeri/' . str_replace('majalah/', '', $majalah->cover_image)
    ];
    
    foreach ($paths as $path) {
        $fullPath = public_path($path);
        $exists = file_exists($fullPath);
        echo "Path: $path -> " . ($exists ? "EXISTS" : "NOT FOUND") . "\n";
        if ($exists) {
            echo "  Full path: $fullPath\n";
            echo "  URL: " . asset($path) . "\n";
        }
    }
} else {
    echo "No magazine found!\n";
}

echo "\nDirect file check:\n";
echo "public/majalah/ contents:\n";
$files = glob(public_path('majalah/*'));
foreach ($files as $file) {
    echo "  " . basename($file) . "\n";
}
