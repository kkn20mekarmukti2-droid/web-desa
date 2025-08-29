<?php

require_once 'vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

use Illuminate\Support\Facades\DB;

echo "🔍 Testing fixes...\n\n";

try {
    // Test 1: Check data table
    echo "1. Testing Data Statistik table:\n";
    $dataCount = DB::table('data')->count();
    echo "   ✅ Data table exists with {$dataCount} records\n";
    
    $categories = DB::table('data')
        ->select('data', DB::raw('COUNT(*) as total_records'), DB::raw('SUM(total) as total_population'))
        ->groupBy('data')
        ->orderBy('data')
        ->get();
    
    echo "   📊 Categories found:\n";
    foreach ($categories as $cat) {
        echo "   - {$cat->data}: {$cat->total_records} records, {$cat->total_population} total\n";
    }
    
} catch (Exception $e) {
    echo "   ❌ Data table error: " . $e->getMessage() . "\n";
}

try {
    // Test 2: Check RT/RW tables
    echo "\n2. Testing RT/RW tables:\n";
    $rwCount = DB::table('rw')->count();
    $rtCount = DB::table('rt')->count();
    echo "   ✅ RW table: {$rwCount} records\n";
    echo "   ✅ RT table: {$rtCount} records\n";
    
} catch (Exception $e) {
    echo "   ❌ RT/RW table error: " . $e->getMessage() . "\n";
}

try {
    // Test 3: Check if controller exists
    echo "\n3. Testing rtRwController:\n";
    if (class_exists('App\\Http\\Controllers\\rtRwController')) {
        echo "   ✅ rtRwController class exists\n";
        
        // Test if methods exist
        $controller = new App\Http\Controllers\rtRwController();
        if (method_exists($controller, 'manageModern')) {
            echo "   ✅ manageModern method exists\n";
        }
    } else {
        echo "   ❌ rtRwController class not found\n";
    }
    
} catch (Exception $e) {
    echo "   ❌ Controller error: " . $e->getMessage() . "\n";
}

echo "\n🎯 All tests completed!\n";
