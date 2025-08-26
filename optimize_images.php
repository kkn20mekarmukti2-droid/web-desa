<?php
require_once 'vendor/autoload.php';

// Load Laravel configuration
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\artikelModel;

echo "=== OPTIMAL IMAGE DISTRIBUTION ===\n";

// Update artikel dengan gambar baru yang tepat
$optimalMapping = [
    'Pembangunan Jalan Desa Dimulai' => 'Penetapan RKPDes.jpg',
    'Festival Budaya Desa 2024' => 'WhatsApp Image 2024-12-10 at 15.25.04_b22621d9_1733827186.jpg', // Kembalikan ke asli
    'Gotong Royong Membersihkan Saluran Irigasi' => 'Penyaluran BLT DD.jpg',
    'Program Vaksinasi COVID-19 Tahap Lanjutan' => 'PENYULUHAN IVA TES.jpg',
    'Pasar Rakyat Desa Raih Omzet Tertinggi' => 'news-placeholder-2.jpg',
    'Launching Website Resmi Desa' => 'news-placeholder-4.jpg'
];

foreach($optimalMapping as $judulArtikel => $imageName) {
    $article = artikelModel::where('judul', $judulArtikel)->first();
    if ($article && file_exists(public_path('img/' . $imageName))) {
        $article->sampul = $imageName;
        $article->save();
        echo "✅ Updated: {$article->judul} -> {$imageName}\n";
    }
}

echo "\n=== FINAL VERIFICATION ===\n";
$allArticles = artikelModel::select('judul', 'sampul')->get();
foreach($allArticles as $article) {
    $fileExists = file_exists(public_path('img/' . $article->sampul));
    $status = $fileExists ? '✅ VALID' : '❌ MISSING';
    echo "{$status}: {$article->judul} -> {$article->sampul}\n";
}
?>
