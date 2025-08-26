<?php
require_once 'vendor/autoload.php';

// Load Laravel configuration
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\artikelModel;

echo "=== UPDATING ARTIKEL TITLES AND IMAGES ===\n";

// Get the latest 3 articles (yang akan ditampilkan di homepage)
$articles = artikelModel::orderBy('created_at', 'desc')->take(3)->get();

if ($articles->count() >= 3) {
    // Update artikel pertama
    $article1 = $articles[0];
    $article1->judul = 'Penyaluran BLT DD Tahun Anggaran 2024';
    $article1->sampul = 'Penyaluran BLT DD.jpg';
    $article1->header = 'Pemerintah Desa Mekarmukti melakukan penyaluran BLT Dana Desa';
    $article1->save();
    echo "✅ Updated Article 1: {$article1->judul}\n";

    // Update artikel kedua
    $article2 = $articles[1];
    $article2->judul = 'Musyawarah Desa Mekarmukti Bahas Penetapan RKPDes TA 2025';
    $article2->sampul = 'Penetapan RKPDes.jpg';
    $article2->header = 'Musyawarah Desa membahas penetapan Rencana Kerja Pemerintah Desa';
    $article2->save();
    echo "✅ Updated Article 2: {$article2->judul}\n";

    // Update artikel ketiga
    $article3 = $articles[2];
    $article3->judul = 'Penyuluhan IVA & TES Pelayanan KB PKK DESA MEKARMUKTI';
    $article3->sampul = 'PENYULUHAN IVA TES.jpg';
    $article3->header = 'Program penyuluhan kesehatan untuk ibu-ibu PKK Desa Mekarmukti';
    $article3->save();
    echo "✅ Updated Article 3: {$article3->judul}\n";
}

echo "\n=== VERIFICATION - TOP 3 ARTICLES ===\n";
$topArticles = artikelModel::orderBy('created_at', 'desc')->take(3)->get();
foreach ($topArticles as $index => $article) {
    $fileExists = file_exists(public_path('img/' . $article->sampul));
    $status = $fileExists ? '✅ VALID' : '❌ MISSING';
    echo "Article " . ($index + 1) . " {$status}: {$article->judul} -> {$article->sampul}\n";
}

echo "\nThese are the 3 articles that will show on homepage!\n";

?>
