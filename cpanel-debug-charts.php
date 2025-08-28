<?php
/**
 * Production Chart API Debug Script
 * Test endpoint /getdatades secara langsung di production
 */

require_once __DIR__ . '/vendor/autoload.php';

// Load Laravel environment
$app = require_once __DIR__ . '/bootstrap/app.php';

// Set database connection ke MySQL untuk production
putenv('DB_CONNECTION=mysql');

// Bootstrap Laravel
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Http\Controllers\dataController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

echo "=== PRODUCTION CHART API DEBUG ===" . PHP_EOL;

try {
    // Test database connection
    $connection = DB::connection();
    $dbName = $connection->getDatabaseName();
    echo "✅ Connected to database: {$dbName}" . PHP_EOL;
    
    // Check statistik table and data
    if (DB::getSchemaBuilder()->hasTable('statistik')) {
        $totalRecords = DB::table('statistik')->count();
        echo "✅ Statistik table exists with {$totalRecords} records" . PHP_EOL;
        
        // Show data by category
        $categories = ['jenis_kelamin', 'agama', 'pekerjaan'];
        foreach ($categories as $kategori) {
            $count = DB::table('statistik')->where('kategori', $kategori)->count();
            echo "  - {$kategori}: {$count} records" . PHP_EOL;
            
            if ($count > 0) {
                $data = DB::table('statistik')->where('kategori', $kategori)->get(['label', 'jumlah']);
                foreach ($data as $row) {
                    echo "    * {$row->label}: {$row->jumlah}" . PHP_EOL;
                }
            }
        }
    } else {
        echo "❌ Statistik table does NOT exist!" . PHP_EOL;
        return;
    }
    
    echo PHP_EOL . "=== TESTING API ENDPOINTS ===" . PHP_EOL;
    
    // Create dataController instance
    $controller = new dataController();
    
    // Test each endpoint
    $endpoints = [
        'penduduk' => 'jenis_kelamin',
        'agama' => 'agama', 
        'pekerjaan' => 'pekerjaan'
    ];
    
    foreach ($endpoints as $type => $kategori) {
        echo "Testing type: {$type} (kategori: {$kategori})" . PHP_EOL;
        
        // Create fake request
        $request = new Request(['type' => $type]);
        
        try {
            // Call controller method directly
            $response = $controller->getChartData($request);
            $responseData = $response->getData(true); // Get as array
            
            echo "  Response: " . json_encode($responseData) . PHP_EOL;
            
            // Analyze response
            if (empty($responseData['labels']) && empty($responseData['data'])) {
                echo "  ❌ EMPTY RESPONSE - No data returned!" . PHP_EOL;
                
                // Debug why empty
                $directData = DB::table('statistik')->where('kategori', $kategori)->get();
                echo "  Direct DB query for '{$kategori}': " . $directData->count() . " records" . PHP_EOL;
                
            } else {
                echo "  ✅ SUCCESS - Data returned!" . PHP_EOL;
                echo "    Labels: " . implode(', ', $responseData['labels']) . PHP_EOL;
                echo "    Data: " . implode(', ', $responseData['data']) . PHP_EOL;
            }
            
        } catch (Exception $e) {
            echo "  ❌ ERROR: " . $e->getMessage() . PHP_EOL;
        }
        
        echo PHP_EOL;
    }
    
    echo "=== URL ENDPOINTS FOR BROWSER TEST ===" . PHP_EOL;
    $baseUrl = 'https://mekarmukti.id'; // Change this to your actual domain
    echo "🌐 Test these URLs in browser:" . PHP_EOL;
    echo "1. {$baseUrl}/getdatades?type=penduduk" . PHP_EOL;
    echo "2. {$baseUrl}/getdatades?type=agama" . PHP_EOL; 
    echo "3. {$baseUrl}/getdatades?type=pekerjaan" . PHP_EOL;
    echo PHP_EOL;
    
    echo "📋 Chart page: {$baseUrl}/data/penduduk" . PHP_EOL;
    
} catch (Exception $e) {
    echo "❌ FATAL ERROR: " . $e->getMessage() . PHP_EOL;
    echo "File: " . $e->getFile() . ":" . $e->getLine() . PHP_EOL;
}

echo PHP_EOL . "=== DEBUG COMPLETED ===" . PHP_EOL;
?>
