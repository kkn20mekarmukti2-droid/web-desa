<?php
// Script untuk menambahkan sample hero images ke database
// Jalankan dengan: php add_sample_hero_images.php

require_once 'vendor/autoload.php';
require_once 'bootstrap/app.php';

use App\Models\HeroImage;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Http\Kernel')->bootstrap();

try {
    echo "=== MENAMBAHKAN SAMPLE HERO IMAGES ===\n\n";
    
    // Daftar gambar yang akan ditambahkan
    $heroImages = [
        [
            'nama_gambar' => 'Desa Mekarmukti 1',
            'gambar' => 'img/DSC_0070.JPG',
            'deskripsi' => 'Pemandangan indah Desa Mekarmukti - Foto utama untuk slideshow hero',
            'urutan' => 1,
            'is_active' => true
        ],
        [
            'nama_gambar' => 'Aktivitas Desa',
            'gambar' => 'img/DSC_0108.jpg',
            'deskripsi' => 'Aktivitas masyarakat Desa Mekarmukti dalam kehidupan sehari-hari',
            'urutan' => 2,
            'is_active' => true
        ],
        [
            'nama_gambar' => 'Infrastruktur Desa',
            'gambar' => 'img/DSC_0828.JPG',
            'deskripsi' => 'Perkembangan infrastruktur dan pembangunan di Desa Mekarmukti',
            'urutan' => 3,
            'is_active' => true
        ],
        [
            'nama_gambar' => 'Fasilitas Umum',
            'gambar' => 'img/IMG_9152.png',
            'deskripsi' => 'Fasilitas umum yang tersedia untuk masyarakat Desa Mekarmukti',
            'urutan' => 4,
            'is_active' => true
        ],
        [
            'nama_gambar' => 'Kepala Desa',
            'gambar' => 'img/kades.jpg',
            'deskripsi' => 'Kepala Desa Mekarmukti dalam menjalankan tugasnya melayani masyarakat',
            'urutan' => 5,
            'is_active' => true
        ],
        [
            'nama_gambar' => 'Kegiatan Desa 1',
            'gambar' => 'img/P1560599.JPG',
            'deskripsi' => 'Berbagai kegiatan dan program yang dilaksanakan di Desa Mekarmukti',
            'urutan' => 6,
            'is_active' => true
        ],
        [
            'nama_gambar' => 'Kegiatan Desa 2',
            'gambar' => 'img/P1570155.JPG',
            'deskripsi' => 'Dokumentasi kegiatan pembangunan dan kemasyarakatan desa',
            'urutan' => 7,
            'is_active' => true
        ]
    ];
    
    $successCount = 0;
    $skipCount = 0;
    
    foreach ($heroImages as $imageData) {
        // Check if image file exists
        $imagePath = public_path($imageData['gambar']);
        if (!file_exists($imagePath)) {
            echo "⚠️  File tidak ditemukan: {$imageData['gambar']} - Dilewati\n";
            $skipCount++;
            continue;
        }
        
        // Check if already exists in database
        $existingImage = HeroImage::where('gambar', $imageData['gambar'])->first();
        if ($existingImage) {
            echo "📋 Sudah ada: {$imageData['nama_gambar']} - Dilewati\n";
            $skipCount++;
            continue;
        }
        
        // Create new hero image
        $heroImage = HeroImage::create($imageData);
        echo "✅ Berhasil ditambahkan: {$heroImage->nama_gambar} (Urutan: {$heroImage->urutan})\n";
        $successCount++;
    }
    
    echo "\n=== RINGKASAN ===\n";
    echo "✅ Berhasil ditambahkan: $successCount gambar\n";
    echo "⚠️  Dilewati: $skipCount gambar\n";
    echo "📊 Total di database: " . HeroImage::count() . " gambar\n";
    echo "🖼️  Gambar aktif: " . HeroImage::active()->count() . " gambar\n";
    
    if ($successCount > 0) {
        echo "\n🎉 Hero images berhasil ditambahkan ke database!\n";
        echo "📱 Silakan akses /admin/hero-images untuk melihat hasilnya.\n";
    }
    
} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}
