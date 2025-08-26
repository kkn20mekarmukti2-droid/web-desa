<?php
require_once 'vendor/autoload.php';

// Load Laravel configuration
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\artikelModel;

echo "=== UPDATING ARTIKEL IMAGES ===\n";

// Mapping dengan berbagai variasi kata kunci
$imageMapping = [
    // Coba berbagai variasi untuk matching
    'RKPDes' => 'Penetapan RKPDes.jpg',
    'rkpdes' => 'Penetapan RKPDes.jpg',
    'penetapan' => 'Penetapan RKPDes.jpg',
    'BLT' => 'Penyaluran BLT DD.jpg',
    'penyaluran' => 'Penyaluran BLT DD.jpg',
    'IVA' => 'PENYULUHAN IVA TES.jpg',
    'penyuluhan' => 'PENYULUHAN IVA TES.jpg',
    'tes' => 'PENYULUHAN IVA TES.jpg'
];

// Get all articles
$articles = artikelModel::all();

foreach($articles as $article) {
    $updated = false;
    
    // Cek apakah judul artikel mengandung kata kunci dari mapping
    foreach($imageMapping as $keyword => $imageName) {
        if (stripos($article->judul, $keyword) !== false) {
            echo "Found match: '{$article->judul}' -> '{$imageName}'\n";
            
            // Verify file exists
            if (file_exists(public_path('img/' . $imageName))) {
                $article->sampul = $imageName;
                $article->save();
                echo "✅ Updated: {$article->judul} -> {$imageName}\n";
                $updated = true;
                break;
            } else {
                echo "❌ File not found: {$imageName}\n";
            }
        }
    }
    
    // Jika tidak ada match dan gambar saat ini tidak ada, gunakan placeholder
    if (!$updated && !file_exists(public_path('img/' . $article->sampul))) {
        $placeholders = ['news-placeholder-1.jpg', 'news-placeholder-2.jpg', 'news-placeholder-3.jpg', 'news-placeholder-4.jpg'];
        $randomPlaceholder = $placeholders[array_rand($placeholders)];
        $article->sampul = $randomPlaceholder;
        $article->save();
        echo "🔄 Updated with placeholder: {$article->judul} -> {$randomPlaceholder}\n";
        $updated = true;
    }
    
    if (!$updated) {
        echo "⚪ No change needed: {$article->judul}\n";
    }
}

echo "\n=== MANUAL UPDATES FOR SPECIFIC ARTICLES ===\n";

// Manual update untuk artikel dengan judul spesifik
$manualUpdates = [
    'Pembangunan Jalan Desa Dimulai' => 'Penetapan RKPDes.jpg',
    'Gotong Royong Membersihkan Saluran Irigasi' => 'Penyaluran BLT DD.jpg', 
    'Program Vaksinasi COVID-19 Tahap Lanjutan' => 'PENYULUHAN IVA TES.jpg'
];

foreach($manualUpdates as $judulArtikel => $imageName) {
    $article = artikelModel::where('judul', 'LIKE', "%{$judulArtikel}%")->first();
    if ($article && file_exists(public_path('img/' . $imageName))) {
        $article->sampul = $imageName;
        $article->save();
        echo "✅ Manual update: {$article->judul} -> {$imageName}\n";
    }
}

echo "\n=== VERIFICATION ===\n";
$updatedArticles = artikelModel::whereIn('sampul', array_values($imageMapping))->get();
foreach($updatedArticles as $article) {
    echo "✅ {$article->judul} -> {$article->sampul}\n";
}

echo "\n=== FINAL STATUS ===\n";
$allArticles = artikelModel::select('judul', 'sampul')->get();
foreach($allArticles as $article) {
    $fileExists = file_exists(public_path('img/' . $article->sampul));
    $status = $fileExists ? '✅ VALID' : '❌ MISSING';
    echo "{$status}: {$article->judul} -> {$article->sampul}\n";
}

?>
