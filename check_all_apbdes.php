<?php
require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$request = Illuminate\Http\Request::capture();
$response = $kernel->handle($request);

echo "=== All APBDes Data (including inactive) ===\n";

try {
    // Get ALL APBDes data (not just active)
    $allApbdes = \App\Models\Apbdes::all();
    echo "Total APBDes records: " . count($allApbdes) . "\n\n";
    
    if ($allApbdes->isEmpty()) {
        echo "❌ No APBDes data found at all!\n";
        echo "This means data needs to be added to the database.\n\n";
        
        // Check if table exists
        $tableExists = \Schema::hasTable('apbdes');
        echo "APBDes table exists: " . ($tableExists ? "Yes" : "No") . "\n";
        
        if ($tableExists) {
            $columns = \Schema::getColumnListing('apbdes');
            echo "Table columns: " . implode(', ', $columns) . "\n";
        }
        
    } else {
        echo "Found APBDes records:\n";
        foreach ($allApbdes as $item) {
            echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
            echo "ID: " . $item->id . "\n";
            echo "Title: " . $item->title . "\n";
            echo "Year: " . $item->tahun . "\n";
            echo "Description: " . substr($item->description ?? 'No description', 0, 100) . "\n";
            echo "Status: " . ($item->is_active ? '✅ ACTIVE' : '❌ INACTIVE') . "\n";
            echo "File: " . ($item->file_path ?: 'No file') . "\n";
            echo "Created: " . $item->created_at . "\n";
            echo "Updated: " . $item->updated_at . "\n\n";
        }
        
        $activeCount = $allApbdes->where('is_active', true)->count();
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        echo "Summary: $activeCount active, " . ($allApbdes->count() - $activeCount) . " inactive\n";
        
        if ($activeCount == 0) {
            echo "\n🔧 SOLUTION: You need to set some APBDes records to active (is_active = 1)\n";
            echo "You can do this through:\n";
            echo "1. Admin panel (recommended)\n";
            echo "2. phpMyAdmin\n";
            echo "3. PHP script\n";
        }
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " line " . $e->getLine() . "\n";
}
