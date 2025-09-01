<?php
// Production APBDes Test Script
// Upload this to your website root and run via browser: http://yourdomain.com/test-apbdes-production.php

echo "<h1>🔧 APBDes Production Test</h1>";
echo "<style>body{font-family:Arial,sans-serif;margin:20px;} .success{color:green;} .error{color:red;} .info{color:blue;} .warning{color:orange;} pre{background:#f5f5f5;padding:10px;border-radius:5px;}</style>";

echo "<h2>1. Section Fix Verification</h2>";

// Check if view file exists and has correct section name
$viewFile = __DIR__ . '/resources/views/transparansi-anggaran.blade.php';
if (file_exists($viewFile)) {
    $viewContent = file_get_contents($viewFile);
    if (strpos($viewContent, '@section(\'content\')') !== false) {
        echo "<p class='success'>✅ View file uses @section('content')</p>";
    } elseif (strpos($viewContent, '@section(\'konten\')') !== false) {
        echo "<p class='error'>❌ View still uses @section('konten') - fix not deployed</p>";
    } else {
        echo "<p class='warning'>⚠️ Cannot find section declaration in view</p>";
    }
} else {
    echo "<p class='error'>❌ View file not found at: $viewFile</p>";
}

// Check layout file
$layoutFile = __DIR__ . '/resources/views/layout/app.blade.php';
if (file_exists($layoutFile)) {
    $layoutContent = file_get_contents($layoutFile);
    if (strpos($layoutContent, '@yield(\'content\')') !== false) {
        echo "<p class='success'>✅ Layout uses @yield('content')</p>";
    } else {
        echo "<p class='error'>❌ Layout missing @yield('content')</p>";
    }
} else {
    echo "<p class='error'>❌ Layout file not found</p>";
}

echo "<h2>2. Laravel Bootstrap Test</h2>";

try {
    // Try to bootstrap Laravel
    if (file_exists(__DIR__ . '/vendor/autoload.php')) {
        require_once __DIR__ . '/vendor/autoload.php';
        echo "<p class='success'>✅ Autoloader found</p>";
        
        if (file_exists(__DIR__ . '/bootstrap/app.php')) {
            $app = require_once __DIR__ . '/bootstrap/app.php';
            echo "<p class='success'>✅ Laravel app bootstrapped</p>";
            
            // Test database connection
            try {
                $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
                $request = Illuminate\Http\Request::capture();
                $response = $kernel->handle($request);
                
                echo "<h2>3. Database & APBDes Data Test</h2>";
                
                // Check APBDes data
                $apbdes = \App\Models\Apbdes::getActive();
                echo "<p class='info'>Active APBDes count: " . count($apbdes) . "</p>";
                
                if ($apbdes->isEmpty()) {
                    echo "<p class='warning'>⚠️ No active APBDes data found</p>";
                    
                    // Check for any APBDes data
                    $allApbdes = \App\Models\Apbdes::all();
                    if ($allApbdes->isEmpty()) {
                        echo "<p class='error'>❌ No APBDes data at all - add data through admin panel</p>";
                    } else {
                        echo "<p class='warning'>⚠️ Found " . count($allApbdes) . " APBDes records but none are active</p>";
                        echo "<p class='info'>💡 Set some records to active (is_active=1) in admin panel</p>";
                    }
                } else {
                    echo "<p class='success'>✅ Found active APBDes data:</p>";
                    echo "<ul>";
                    foreach ($apbdes->take(3) as $item) {
                        echo "<li><strong>" . htmlspecialchars($item->title) . "</strong> (" . $item->tahun . ")</li>";
                    }
                    echo "</ul>";
                }
                
                echo "<h2>4. Route Test</h2>";
                $url = route('transparansi.anggaran');
                echo "<p class='success'>✅ Route exists: <a href='$url' target='_blank'>$url</a></p>";
                
            } catch (Exception $e) {
                echo "<p class='error'>❌ Database/Route error: " . htmlspecialchars($e->getMessage()) . "</p>";
            }
            
        } else {
            echo "<p class='error'>❌ Laravel bootstrap file not found</p>";
        }
    } else {
        echo "<p class='error'>❌ Vendor autoload not found - run composer install</p>";
    }
    
} catch (Exception $e) {
    echo "<p class='error'>❌ Bootstrap error: " . htmlspecialchars($e->getMessage()) . "</p>";
}

echo "<h2>5. Next Steps</h2>";
echo "<div class='info'>";
echo "<p><strong>If everything shows green checkmarks:</strong></p>";
echo "<ul>";
echo "<li>Visit your transparency page: <a href='/transparansi-anggaran'>Transparency Page</a></li>";
echo "<li>Your APBDes data should now display properly</li>";
echo "</ul>";
echo "<p><strong>If issues remain:</strong></p>";
echo "<ul>";
echo "<li>Ensure the fixed view file was uploaded correctly</li>";
echo "<li>Check that APBDes data exists and is set to active</li>";
echo "<li>Verify file permissions (644 for PHP files)</li>";
echo "</ul>";
echo "</div>";

echo "<hr>";
echo "<p><small>🕐 Test run at: " . date('Y-m-d H:i:s') . "</small></p>";
?>
