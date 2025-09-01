<?php
// Debug UMKM Images
require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\ProdukUmkm;

echo "=== DEBUG UMKM IMAGES ===\n\n";

// Check if there are any UMKM products
$produkList = ProdukUmkm::all(['id', 'nama_produk', 'gambar']);

echo "Total products: " . $produkList->count() . "\n\n";

foreach ($produkList as $produk) {
    echo "Product ID: {$produk->id}\n";
    echo "Name: {$produk->nama_produk}\n";
    echo "Image path in DB: " . ($produk->gambar ?? 'NULL') . "\n";
    
    if ($produk->gambar) {
        // Check all possible image locations
        $paths = [
            'storage/' . $produk->gambar => public_path('storage/' . $produk->gambar),
            $produk->gambar => public_path($produk->gambar),
            'img/umkm/' . basename($produk->gambar) => public_path('img/umkm/' . basename($produk->gambar))
        ];
        
        echo "Checking image paths:\n";
        foreach ($paths as $desc => $fullPath) {
            $exists = file_exists($fullPath);
            echo "  - {$desc}: " . ($exists ? "✓ EXISTS" : "✗ NOT FOUND") . " ({$fullPath})\n";
        }
    }
    echo "---\n";
}

// Check directories
echo "\nDirectory checks:\n";
$dirs = [
    'public/storage/umkm' => public_path('storage/umkm'),
    'public/img/umkm' => public_path('img/umkm'),
    'storage/app/public/umkm' => storage_path('app/public/umkm')
];

foreach ($dirs as $desc => $path) {
    $exists = is_dir($path);
    echo "  - {$desc}: " . ($exists ? "✓ EXISTS" : "✗ NOT FOUND") . " ({$path})\n";
    if ($exists) {
        $files = glob($path . '/*');
        echo "    Files: " . count($files) . "\n";
        foreach (array_slice($files, 0, 3) as $file) {
            echo "      - " . basename($file) . "\n";
        }
    }
}
?>
