<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== UPDATE COVER PATHS ===\n";

try {
    // Update MotekArt magazine cover
    $motekart = App\Models\Majalah::where('judul', 'LIKE', '%MotekArt%')->first();
    if ($motekart) {
        $motekart->cover_image = 'img/majalah/MotekArt/1.png';
        $motekart->save();
        echo "✅ Updated MotekArt cover: {$motekart->cover_image}\n";
    }
    
    // Update sample magazine cover with placeholder if file doesn't exist
    $sample = App\Models\Majalah::where('judul', 'LIKE', '%September%')->first();
    if ($sample) {
        // Check if original cover exists
        $originalPath = public_path($sample->cover_image);
        if (!file_exists($originalPath)) {
            // Use MotekArt image as fallback
            $sample->cover_image = 'img/majalah/MotekArt/2.png';
            $sample->save();
            echo "✅ Updated Sample cover (fallback): {$sample->cover_image}\n";
        } else {
            echo "✅ Sample cover exists: {$sample->cover_image}\n";
        }
    }
    
    echo "\n=== FINAL COVERS ===\n";
    $majalah = App\Models\Majalah::all();
    foreach($majalah as $m) {
        $fullPath = public_path($m->cover_image);
        $exists = file_exists($fullPath) ? '✅' : '❌';
        echo "{$exists} {$m->judul}: {$m->cover_image}\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
