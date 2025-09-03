<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Majalah;
use App\Models\MajalahPage;

echo "Copying majalah images from storage to public...\n";

// Copy cover images
$majalah = Majalah::all();
foreach ($majalah as $item) {
    if ($item->cover_image && file_exists(storage_path('app/public/' . $item->cover_image))) {
        $source = storage_path('app/public/' . $item->cover_image);
        $destination = public_path($item->cover_image);
        
        // Create destination directory if not exists
        $destDir = dirname($destination);
        if (!file_exists($destDir)) {
            mkdir($destDir, 0755, true);
        }
        
        echo "Copying cover: $source to $destination\n";
        copy($source, $destination);
    }
}

// Copy page images
$pages = MajalahPage::all();
foreach ($pages as $page) {
    if ($page->image_path && file_exists(storage_path('app/public/' . $page->image_path))) {
        $source = storage_path('app/public/' . $page->image_path);
        $destination = public_path($page->image_path);
        
        // Create destination directory if not exists
        $destDir = dirname($destination);
        if (!file_exists($destDir)) {
            mkdir($destDir, 0755, true);
        }
        
        echo "Copying page: $source to $destination\n";
        copy($source, $destination);
    }
}

echo "Done!\n";
