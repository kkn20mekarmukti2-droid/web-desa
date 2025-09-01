<?php
// Add sample images to UMKM products
require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\ProdukUmkm;

echo "=== ADDING SAMPLE IMAGES TO UMKM ===\n\n";

// Sample images to copy from public/img to img/umkm
$sampleImages = [
    'DSC_0070.JPG',
    'DSC_0108.jpg', 
    'P1560599.JPG',
    'P1570155.JPG'
];

$produkList = ProdukUmkm::all();
echo "Found " . $produkList->count() . " products\n\n";

foreach ($produkList as $index => $produk) {
    if ($index >= count($sampleImages)) break;
    
    $sourceImage = $sampleImages[$index];
    $sourcePath = public_path('img/' . $sourceImage);
    
    if (file_exists($sourcePath)) {
        // Generate new filename with timestamp
        $extension = pathinfo($sourceImage, PATHINFO_EXTENSION);
        $newName = time() . '_' . uniqid() . '.' . strtolower($extension);
        $targetPath = public_path('img/umkm/' . $newName);
        
        // Copy image to umkm folder
        if (copy($sourcePath, $targetPath)) {
            // Update database with new path
            $produk->update(['gambar' => 'img/umkm/' . $newName]);
            
            echo "✓ Product '{$produk->nama_produk}' updated with image: img/umkm/{$newName}\n";
        } else {
            echo "✗ Failed to copy image for: {$produk->nama_produk}\n";
        }
    } else {
        echo "✗ Source image not found: {$sourceImage}\n";
    }
}

echo "\nDone!\n";
?>
