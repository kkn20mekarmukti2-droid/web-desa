<?php
require_once 'vendor/autoload.php';

// Bootstrap Laravel app
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Majalah;

echo "📊 Database Content Check:\n\n";

$magazines = Majalah::with('pages')->get();

foreach ($magazines as $mag) {
    echo "ID: {$mag->id}\n";
    echo "Judul: {$mag->judul}\n";
    echo "Cover Image: {$mag->cover_image}\n";
    echo "Total Pages: " . $mag->pages->count() . "\n";
    echo "Created: {$mag->created_at}\n";
    echo "Active: " . ($mag->is_active ? 'Yes' : 'No') . "\n";
    
    echo "Pages:\n";
    foreach ($mag->pages->sortBy('page_number') as $page) {
        echo "  - Page {$page->page_number}: {$page->image_path}\n";
    }
    echo "\n";
}
