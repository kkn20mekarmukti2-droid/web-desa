<?php
require_once 'vendor/autoload.php';

// Load Laravel configuration
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\artikelModel;
use App\Models\galleryModel;

echo "=== ARTIKEL DATA ===\n";
$articles = artikelModel::select('judul', 'sampul', 'created_at')->take(5)->get();
foreach($articles as $article) {
    echo "Judul: {$article->judul}\n";
    echo "Sampul: {$article->sampul}\n";
    echo "Path: " . asset('img/' . $article->sampul) . "\n";
    echo "File exists: " . (file_exists(public_path('img/' . $article->sampul)) ? 'YES' : 'NO') . "\n";
    echo "---\n";
}

echo "\n=== GALLERY DATA ===\n";
try {
    $galleries = galleryModel::select('judul', 'url', 'type')->get();
    if($galleries->count() > 0) {
        foreach($galleries->take(5) as $gallery) {
            echo "Judul: {$gallery->judul}\n";
            echo "URL: {$gallery->url}\n";
            echo "Type: {$gallery->type}\n";
            if($gallery->type == 'foto') {
                echo "Path: " . asset('galeri/' . $gallery->url) . "\n";
                echo "File exists: " . (file_exists(public_path('galeri/' . $gallery->url)) ? 'YES' : 'NO') . "\n";
            }
            echo "---\n";
        }
    } else {
        echo "No gallery data found.\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
