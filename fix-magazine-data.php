<?php
require_once 'vendor/autoload.php';

// Bootstrap Laravel app
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Majalah;
use App\Models\MajalahPage;

echo "🧹 Cleaning and Fixing Magazine Data...\n\n";

// Delete duplicate and empty magazines
$emptyMagazines = Majalah::whereDoesntHave('pages')->get();
foreach ($emptyMagazines as $mag) {
    echo "Deleting empty magazine: {$mag->judul} (ID: {$mag->id})\n";
    $mag->delete();
}

// Get remaining magazines
$magazines = Majalah::with('pages')->get();

foreach ($magazines as $mag) {
    echo "Fixing magazine: {$mag->judul} (ID: {$mag->id})\n";
    
    // Fix cover image path if needed
    if ($mag->id == 2) {
        $mag->cover_image = 'majalah/sample-cover-2.jpg';
        $mag->judul = 'Info Desa Edisi September';
        $mag->save();
        echo "  Updated cover and title\n";
    }
    
    // Fix page paths
    foreach ($mag->pages as $page) {
        $correctPath = "majalah/pages/{$mag->id}/page-{$page->page_number}.jpg";
        if ($page->image_path !== $correctPath) {
            echo "  Fixing page {$page->page_number}: {$page->image_path} -> {$correctPath}\n";
            $page->image_path = $correctPath;
            $page->save();
        }
    }
}

echo "\n✅ Data cleanup complete!\n";

// Show final state
echo "\n📊 Final Magazine State:\n";
$finalMagazines = Majalah::with('pages')->get();
foreach ($finalMagazines as $mag) {
    echo "ID: {$mag->id} - {$mag->judul} - Cover: {$mag->cover_image} - Pages: " . $mag->pages->count() . "\n";
}
