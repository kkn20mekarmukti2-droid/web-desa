<?php
require_once 'vendor/autoload.php';

// Load Laravel configuration
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\artikelModel;

echo "=== UPDATING ARTIKEL WITH CORRECT TITLES ===\n";

// Update artikel dengan judul yang benar sesuai yang disebutkan user
$correctMapping = [
    // Judul yang benar -> gambar yang tepat
    'Penyaluran BLT DD Tahun Anggaran 2024' => 'Penyaluran BLT DD.jpg',
    'Musyawarah Desa Mekarmukti Bahas Penetapan RKPDes TA 2025' => 'Penetapan RKPDes.jpg',
    'Penyuluhan IVA & TES Pelayanan KB PKK DESA MEKARMUKTI' => 'PENYULUHAN IVA TES.jpg'
];

// Pertama, cek apakah artikel dengan judul ini ada
echo "=== SEARCHING FOR ARTICLES ===\n";
$allArticles = artikelModel::all();
foreach ($allArticles as $article) {
    echo "Found: {$article->judul}\n";
}

echo "\n=== UPDATING WITH CORRECT MAPPING ===\n";

foreach ($correctMapping as $correctTitle => $imageName) {
    // Cari artikel dengan judul yang mirip
    $article = artikelModel::where('judul', 'LIKE', "%{$correctTitle}%")
                          ->orWhere('judul', 'LIKE', '%BLT DD%')
                          ->orWhere('judul', 'LIKE', '%RKPDes%')
                          ->orWhere('judul', 'LIKE', '%IVA%')
                          ->orWhere('judul', 'LIKE', '%PENYULUHAN%')
                          ->first();
    
    if (!$article) {
        // Jika tidak ditemukan, mungkin perlu dibuat artikel baru
        echo "❌ Article not found: {$correctTitle}\n";
        
        // Buat artikel baru
        if (file_exists(public_path('img/' . $imageName))) {
            $newArticle = new artikelModel();
            $newArticle->judul = $correctTitle;
            $newArticle->header = "Berita terbaru dari Desa Mekarmukti";
            $newArticle->sampul = $imageName;
            $newArticle->deskripsi = "Artikel berita terbaru dari Desa Mekarmukti tentang " . $correctTitle;
            $newArticle->kategori = '';
            $newArticle->status = 1;
            $newArticle->created_by = 1;
            $newArticle->updated_by = 1;
            $newArticle->save();
            
            echo "✅ Created new article: {$correctTitle} -> {$imageName}\n";
        }
    } else {
        // Update artikel yang sudah ada
        if (file_exists(public_path('img/' . $imageName))) {
            $article->sampul = $imageName;
            $article->save();
            echo "✅ Updated existing: {$article->judul} -> {$imageName}\n";
        }
    }
}

echo "\n=== FINAL VERIFICATION ===\n";
$updatedArticles = artikelModel::orderBy('created_at', 'desc')->take(6)->get();
foreach ($updatedArticles as $article) {
    $fileExists = file_exists(public_path('img/' . $article->sampul));
    $status = $fileExists ? '✅ VALID' : '❌ MISSING';
    echo "{$status}: {$article->judul} -> {$article->sampul}\n";
}

?>
