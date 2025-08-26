<?php
// Jalankan script ini di cPanel untuk update artikel

require_once 'vendor/autoload.php';

// Load Laravel configuration
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\artikelModel;

try {
    echo "=== UPDATING ARTICLES FOR PRODUCTION ===\n";

    // Clear caches first
    echo "1. Clearing caches...\n";
    \Artisan::call('cache:clear');
    \Artisan::call('config:clear');  
    \Artisan::call('view:clear');

    // Get top 3 articles
    $articles = artikelModel::orderBy('created_at', 'desc')->take(3)->get();

    if ($articles->count() >= 3) {
        // Update artikel pertama
        $articles[0]->update([
            'judul' => 'Penyaluran BLT DD Tahun Anggaran 2024',
            'sampul' => 'Penyaluran BLT DD.jpg',
            'header' => 'Pemerintah Desa Mekarmukti melakukan penyaluran BLT Dana Desa'
        ]);
        echo "✅ Updated Article 1: Penyaluran BLT DD Tahun Anggaran 2024\n";

        // Update artikel kedua  
        $articles[1]->update([
            'judul' => 'Musyawarah Desa Mekarmukti Bahas Penetapan RKPDes TA 2025',
            'sampul' => 'Penetapan RKPDes.jpg',
            'header' => 'Musyawarah Desa membahas penetapan Rencana Kerja Pemerintah Desa'
        ]);
        echo "✅ Updated Article 2: Musyawarah Desa Mekarmukti Bahas Penetapan RKPDes TA 2025\n";

        // Update artikel ketiga
        $articles[2]->update([
            'judul' => 'Penyuluhan IVA & TES Pelayanan KB PKK DESA MEKARMUKTI', 
            'sampul' => 'PENYULUHAN IVA TES.jpg',
            'header' => 'Program penyuluhan kesehatan untuk ibu-ibu PKK Desa Mekarmukti'
        ]);
        echo "✅ Updated Article 3: Penyuluhan IVA & TES Pelayanan KB PKK DESA MEKARMUKTI\n";

        echo "\n=== VERIFICATION ===\n";
        $updatedArticles = artikelModel::orderBy('created_at', 'desc')->take(3)->get();
        foreach ($updatedArticles as $index => $article) {
            $imageExists = file_exists(public_path('img/' . $article->sampul)) ? '✅' : '❌';
            echo "Article " . ($index + 1) . " {$imageExists}: {$article->judul}\n";
            echo "  Image: {$article->sampul}\n";
        }

        // Clear caches again
        echo "\n2. Clearing caches again...\n";
        \Artisan::call('cache:clear');
        \Artisan::call('view:clear');

        echo "\n🎉 ARTICLES UPDATED SUCCESSFULLY!\n";
        echo "Homepage should now show the 3 correct articles with matching images.\n";

    } else {
        echo "❌ Error: Less than 3 articles found in database\n";
    }

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
