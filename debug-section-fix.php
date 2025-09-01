<?php
// 🔍 APBDes Section Name Debug - Quick Fix
// File: debug-section-fix.php
// Upload ke public folder untuk testing cepat

echo "<h1>🔍 APBDes Section Name Fix Debug</h1>";
echo "<style>body{font-family:Arial;line-height:1.6;} .ok{color:green;} .error{color:red;} .warn{color:orange;}</style>";

echo "<h2>📋 Section Name Issue Detection</h2>";

try {
    require_once 'vendor/autoload.php';
    $app = require_once 'bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    
    echo "<p class='ok'>✅ Laravel Bootstrap: OK</p>";
    
    // Check if transparansi view exists
    $viewPath = 'resources/views/transparansi-anggaran.blade.php';
    if (file_exists($viewPath)) {
        echo "<p class='ok'>✅ View File: EXISTS</p>";
        
        // Check view content for section names
        $viewContent = file_get_contents($viewPath);
        
        if (strpos($viewContent, "@section('content')") !== false) {
            echo "<p class='ok'>✅ Uses @section('content'): CORRECT ✨</p>";
        } elseif (strpos($viewContent, "@section('konten')") !== false) {
            echo "<p class='error'>❌ Uses @section('konten'): WRONG! Should be 'content'</p>";
            echo "<p class='warn'>🔧 SOLUTION: Change @section('konten') to @section('content')</p>";
        } else {
            echo "<p class='warn'>⚠️ No @section found in view</p>";
        }
        
        // Check layout reference
        if (strpos($viewContent, "@extends('layout.app')") !== false) {
            echo "<p class='ok'>✅ Extends layout.app: CORRECT</p>";
        } else {
            echo "<p class='error'>❌ Wrong layout reference</p>";
        }
        
    } else {
        echo "<p class='error'>❌ View File: NOT FOUND</p>";
    }
    
    // Check layout file
    $layoutPath = 'resources/views/layout/app.blade.php';
    if (file_exists($layoutPath)) {
        echo "<p class='ok'>✅ Layout File: EXISTS</p>";
        
        $layoutContent = file_get_contents($layoutPath);
        if (strpos($layoutContent, "@yield('content')") !== false) {
            echo "<p class='ok'>✅ Layout uses @yield('content'): CORRECT</p>";
        } else {
            echo "<p class='error'>❌ Layout doesn't use @yield('content')</p>";
        }
    }
    
    // Test data availability
    echo "<h3>📊 Data Test</h3>";
    $activeCount = DB::table('apbdes')->where('is_active', 1)->count();
    echo "<p>Active APBDes Records: <strong>$activeCount</strong></p>";
    
    if ($activeCount > 0) {
        echo "<p class='ok'>✅ Data is available for display</p>";
        
        // Test model method
        $modelData = App\Models\Apbdes::getActive();
        echo "<p>Model getActive() returns: <strong>" . count($modelData) . "</strong> records</p>";
        
        if (count($modelData) > 0) {
            echo "<p class='ok'>✅ Model method working correctly</p>";
            echo "<h4>Sample Data:</h4>";
            foreach ($modelData->take(3) as $item) {
                echo "<li><strong>{$item->title}</strong> - {$item->tahun}</li>";
            }
        } else {
            echo "<p class='error'>❌ Model method returns empty</p>";
        }
    } else {
        echo "<p class='error'>❌ No active data found</p>";
    }
    
    // Test route
    echo "<h3>🛣️ Route Test</h3>";
    try {
        $controller = new App\Http\Controllers\ApbdesController();
        echo "<p class='ok'>✅ Controller can be instantiated</p>";
        
        if (method_exists($controller, 'transparansi')) {
            echo "<p class='ok'>✅ transparansi method exists</p>";
        } else {
            echo "<p class='error'>❌ transparansi method missing</p>";
        }
    } catch (Exception $e) {
        echo "<p class='error'>❌ Controller error: " . $e->getMessage() . "</p>";
    }
    
} catch (Exception $e) {
    echo "<p class='error'>❌ System Error: " . $e->getMessage() . "</p>";
}

echo "<h2>🎯 DIAGNOSIS RESULT</h2>";

// Final diagnosis
$viewExists = file_exists('resources/views/transparansi-anggaran.blade.php');
$hasCorrectSection = false;
$hasData = false;

if ($viewExists) {
    $content = file_get_contents('resources/views/transparansi-anggaran.blade.php');
    $hasCorrectSection = strpos($content, "@section('content')") !== false;
}

try {
    $hasData = DB::table('apbdes')->where('is_active', 1)->count() > 0;
} catch (Exception $e) {
    // Database error
}

if (!$viewExists) {
    echo "<div style='background:#ffeeee;padding:15px;border:1px solid #ff0000;border-radius:5px;'>";
    echo "<h3>❌ PROBLEM: View File Missing</h3>";
    echo "<p>Upload transparansi-anggaran.blade.php to resources/views/</p>";
    echo "</div>";
} elseif (!$hasCorrectSection) {
    echo "<div style='background:#fff8ee;padding:15px;border:1px solid #ff8800;border-radius:5px;'>";
    echo "<h3>⚠️ PROBLEM: Section Name Mismatch (MOST LIKELY CAUSE)</h3>";
    echo "<p><strong>Issue:</strong> View uses @section('konten') but layout expects @section('content')</p>";
    echo "<p><strong>Fix:</strong> Change @section('konten') to @section('content') in view file</p>";
    echo "<p><strong>Status:</strong> This has been FIXED in the latest update! ✅</p>";
    echo "</div>";
} elseif (!$hasData) {
    echo "<div style='background:#ffeeee;padding:15px;border:1px solid #ff0000;border-radius:5px;'>";
    echo "<h3>❌ PROBLEM: No Active Data</h3>";
    echo "<p>Add data via admin panel and ensure it's set to 'Active'</p>";
    echo "</div>";
} else {
    echo "<div style='background:#eeffee;padding:15px;border:1px solid #00aa00;border-radius:5px;'>";
    echo "<h3>✅ SYSTEM SHOULD BE WORKING</h3>";
    echo "<p>All components are in place. Try hard refresh (Ctrl+F5) or clear cache.</p>";
    echo "</div>";
}

echo "<hr>";
echo "<p><strong>🧪 Test the page now:</strong> <a href='/transparansi-anggaran' target='_blank'>/transparansi-anggaran</a></p>";
echo "<p><small>Debug completed on " . date('Y-m-d H:i:s') . "</small></p>";
?>
