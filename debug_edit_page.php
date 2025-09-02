<?php

require_once 'vendor/autoload.php';
require_once 'bootstrap/app.php';

use App\Models\StrukturPemerintahan;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Http\Kernel')->bootstrap();

try {
    echo "=== DEBUGGING EDIT PAGE ===\n\n";
    
    // Check if model works
    $count = StrukturPemerintahan::count();
    echo "Total struktur records: $count\n";
    
    if ($count > 0) {
        $struktur = StrukturPemerintahan::first();
        echo "First record:\n";
        echo "- ID: " . $struktur->id . "\n";
        echo "- Nama: " . $struktur->nama . "\n";
        echo "- Jabatan: " . $struktur->jabatan . "\n";
        echo "- Image: " . ($struktur->image ?? 'null') . "\n\n";
        
        // Test view rendering
        echo "Testing view compilation...\n";
        $view = view('admin.struktur-pemerintahan.edit', compact('struktur'));
        echo "View compiled successfully!\n";
        
        // Check view content length
        $content = $view->render();
        echo "View content length: " . strlen($content) . " characters\n";
        
        if (strlen($content) < 100) {
            echo "Content is suspiciously short. First 200 chars:\n";
            echo substr($content, 0, 200) . "\n";
        } else {
            echo "View content looks normal.\n";
        }
        
    } else {
        echo "No struktur records found!\n";
    }
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}
