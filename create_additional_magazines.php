<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== CREATE MAJALAH FROM EXISTING IMAGES ===\n";

try {
    // Create Majalah Dokumentasi Desa
    $majalah_docs = App\Models\Majalah::create([
        'judul' => 'Dokumentasi Kegiatan Desa',
        'deskripsi' => 'Kumpulan dokumentasi kegiatan-kegiatan penting di desa kami',
        'cover_image' => 'img/DSC_0070.JPG',
        'is_active' => true,
        'tanggal_terbit' => now()->subDays(10)
    ]);
    
    // Create pages for this magazine
    $docImages = [
        'img/DSC_0070.JPG',
        'img/DSC_0108.jpg', 
        'img/DSC_0828.JPG',
        'img/P1560599.JPG',
        'img/P1570155.JPG',
        'img/Penetapan RKPDes.jpg',
        'img/Penyaluran BLT DD.jpg',
        'img/PENYULUHAN IVA TES.jpg'
    ];
    
    foreach($docImages as $index => $imagePath) {
        App\Models\MajalahPage::create([
            'majalah_id' => $majalah_docs->id,
            'page_number' => $index + 1,
            'title' => 'Halaman ' . ($index + 1),
            'image_path' => $imagePath
        ]);
    }
    
    echo "✅ Created 'Dokumentasi Kegiatan Desa' with {$majalah_docs->pages()->count()} pages\n";
    
    // Create Majalah Berita Desa  
    $majalah_news = App\Models\Majalah::create([
        'judul' => 'Info Berita Desa Terkini',
        'deskripsi' => 'Berita dan informasi terbaru dari desa',
        'cover_image' => 'img/news-placeholder-1.jpg',
        'is_active' => true,
        'tanggal_terbit' => now()->subDays(5)
    ]);
    
    // Create pages for news magazine
    $newsImages = [
        'img/news-placeholder-1.jpg',
        'img/news-placeholder-2.JPG',
        'img/news-placeholder-3.jpg', 
        'img/news-placeholder-4.jpg',
        'img/kantor.png',
        'img/kades.jpg'
    ];
    
    foreach($newsImages as $index => $imagePath) {
        App\Models\MajalahPage::create([
            'majalah_id' => $majalah_news->id,
            'page_number' => $index + 1,
            'title' => 'Berita ' . ($index + 1),
            'image_path' => $imagePath
        ]);
    }
    
    echo "✅ Created 'Info Berita Desa Terkini' with {$majalah_news->pages()->count()} pages\n";
    
    echo "\n=== SUMMARY ===\n";
    $allMajalah = App\Models\Majalah::all();
    foreach($allMajalah as $m) {
        echo "📚 {$m->judul} ({$m->total_pages} hal) - Cover: {$m->cover_image}\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
