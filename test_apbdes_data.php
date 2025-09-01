<?php
require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$request = Illuminate\Http\Request::capture();
$response = $kernel->handle($request);

// Now test the APBDes data
try {
    $apbdes = \App\Models\Apbdes::getActive();
    echo "=== APBDes Data Test ===\n";
    echo "Active APBDes count: " . count($apbdes) . "\n\n";
    
    if ($apbdes->isEmpty()) {
        echo "❌ No active APBDes data found\n";
    } else {
        echo "✅ Found active APBDes data:\n";
        foreach ($apbdes->take(3) as $item) {
            echo "- Title: " . $item->title . "\n";
            echo "  Year: " . $item->tahun . "\n";
            echo "  Status: " . ($item->is_active ? 'Active' : 'Inactive') . "\n";
            echo "  File: " . ($item->file_path ?: 'No file') . "\n";
            echo "  Created: " . $item->created_at . "\n\n";
        }
    }
    
    // Test the controller method
    echo "\n=== Controller Test ===\n";
    $controller = new \App\Http\Controllers\ApbdesController();
    
    // Use reflection to call the transparansi method
    $reflection = new ReflectionClass($controller);
    $method = $reflection->getMethod('transparansi');
    
    // Create a mock request if needed
    $request = new \Illuminate\Http\Request();
    
    $response = $method->invoke($controller);
    
    if ($response instanceof \Illuminate\View\View) {
        $viewData = $response->getData();
        echo "✅ Controller transparansi method works\n";
        echo "View name: " . $response->getName() . "\n";
        echo "Data keys: " . implode(', ', array_keys($viewData)) . "\n";
        
        if (isset($viewData['apbdes'])) {
            echo "APBDes data passed to view: " . count($viewData['apbdes']) . " items\n";
        }
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " line " . $e->getLine() . "\n";
}

echo "\n=== Section Fix Verification ===\n";
$viewContent = file_get_contents(__DIR__ . '/resources/views/transparansi-anggaran.blade.php');
if (strpos($viewContent, '@section(\'content\')') !== false) {
    echo "✅ View uses @section('content')\n";
} else {
    echo "❌ View does not use @section('content')\n";
}

$layoutContent = file_get_contents(__DIR__ . '/resources/views/layout/app.blade.php');
if (strpos($layoutContent, '@yield(\'content\')') !== false) {
    echo "✅ Layout uses @yield('content')\n";
} else {
    echo "❌ Layout does not use @yield('content')\n";
}

echo "\n=== Route Test ===\n";
try {
    $url = route('transparansi.anggaran');
    echo "✅ Route transparansi.anggaran exists: $url\n";
} catch (Exception $e) {
    echo "❌ Route error: " . $e->getMessage() . "\n";
}
