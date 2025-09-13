<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== DEBUG MAJALAH DATA ===\n";

try {
    $majalah = App\Models\Majalah::all();
    echo "Total Majalah: " . $majalah->count() . "\n\n";
    
    foreach($majalah as $m) {
        echo "ID: {$m->id}\n";
        echo "Judul: {$m->judul}\n";
        echo "Cover: {$m->cover_image}\n";
        echo "Status: " . ($m->is_active ? 'Aktif' : 'Nonaktif') . "\n";
        echo "Total Pages: " . $m->pages()->count() . "\n";
        echo "------------------------\n";
    }
    
    echo "\n=== SAMPLE PAGES ===\n";
    $pages = App\Models\MajalahPage::take(5)->get();
    foreach($pages as $p) {
        echo "Page {$p->page_number}: {$p->image_path}\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
