<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Majalah;
use App\Models\MajalahPage;

echo "Updating Majalah paths...\n";

// Update Majalah cover images
$majalah = Majalah::all();
foreach ($majalah as $item) {
    $oldPath = $item->cover_image;
    echo "Old cover path: $oldPath\n";
    
    if (str_contains($oldPath, 'majalah/covers/')) {
        $newPath = str_replace('majalah/covers/', 'majalah/', $oldPath);
        $item->update(['cover_image' => $newPath]);
        echo "Updated cover to: $newPath\n";
    }
}

// Update MajalahPage image paths
$pages = MajalahPage::all();
foreach ($pages as $page) {
    $oldPath = $page->image_path;
    echo "Old page path: $oldPath\n";
    
    if (str_contains($oldPath, 'majalah/pages/')) {
        $newPath = str_replace('majalah/pages/', 'majalah/pages/', $oldPath);
        $page->update(['image_path' => $newPath]);
        echo "Updated page to: $newPath\n";
    }
}

echo "Done!\n";
