<?php
// 🔍 APBDes Debug Script untuk Production
// File: debug-apbdes-production.php
// Untuk debugging mengapa data tidak muncul di halaman transparansi

echo "<h1>🔍 APBDes Production Debug</h1>";
echo "<style>body{font-family:Arial;line-height:1.6;} .ok{color:green;} .error{color:red;} .warn{color:orange;}</style>";

echo "<h2>📋 System Check</h2>";

// 1. Check Database Connection
try {
    require_once 'vendor/autoload.php';
    $app = require_once 'bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    
    echo "<p class='ok'>✅ Laravel Bootstrap: OK</p>";
    
    // Test database connection
    $pdo = DB::connection()->getPdo();
    echo "<p class='ok'>✅ Database Connection: OK</p>";
    
} catch (Exception $e) {
    echo "<p class='error'>❌ Laravel/DB Error: " . $e->getMessage() . "</p>";
    exit;
}

// 2. Check APBDes Table
try {
    $tableExists = DB::select("SHOW TABLES LIKE 'apbdes'");
    if (count($tableExists) > 0) {
        echo "<p class='ok'>✅ APBDes Table: EXISTS</p>";
        
        // Check table structure
        $columns = DB::select("DESCRIBE apbdes");
        echo "<p class='ok'>✅ Table Columns: " . count($columns) . " columns</p>";
        echo "<details><summary>Show Columns</summary><ul>";
        foreach ($columns as $col) {
            echo "<li>{$col->Field} ({$col->Type}) - {$col->Null} - {$col->Key}</li>";
        }
        echo "</ul></details>";
        
    } else {
        echo "<p class='error'>❌ APBDes Table: NOT FOUND</p>";
        echo "<p class='warn'>⚠️ Run migration: php artisan migrate</p>";
        exit;
    }
} catch (Exception $e) {
    echo "<p class='error'>❌ Table Check Error: " . $e->getMessage() . "</p>";
}

// 3. Check APBDes Data
try {
    $totalCount = DB::table('apbdes')->count();
    $activeCount = DB::table('apbdes')->where('is_active', 1)->count();
    $inactiveCount = DB::table('apbdes')->where('is_active', 0)->count();
    
    echo "<h3>📊 Data Statistics</h3>";
    echo "<p>📄 Total APBDes Records: <strong>$totalCount</strong></p>";
    echo "<p class='ok'>✅ Active Records: <strong>$activeCount</strong></p>";
    echo "<p class='warn'>⚠️ Inactive Records: <strong>$inactiveCount</strong></p>";
    
    if ($totalCount == 0) {
        echo "<p class='error'>❌ NO DATA FOUND - Table is empty!</p>";
        echo "<p>🔧 Add data via admin: <a href='/admin/apbdes'>/admin/apbdes</a></p>";
    }
    
} catch (Exception $e) {
    echo "<p class='error'>❌ Data Check Error: " . $e->getMessage() . "</p>";
}

// 4. Check Recent Records
if ($totalCount > 0) {
    echo "<h3>📋 Recent Records</h3>";
    try {
        $records = DB::table('apbdes')
                    ->select('id', 'title', 'tahun', 'is_active', 'image_path', 'created_at')
                    ->orderBy('created_at', 'desc')
                    ->limit(10)
                    ->get();
        
        echo "<table border='1' cellpadding='5' style='border-collapse:collapse;width:100%;'>";
        echo "<tr><th>ID</th><th>Title</th><th>Tahun</th><th>Active</th><th>Image</th><th>Created</th></tr>";
        
        foreach ($records as $record) {
            $activeStatus = $record->is_active ? '<span class="ok">✅ Active</span>' : '<span class="error">❌ Inactive</span>';
            $imageStatus = file_exists("storage/{$record->image_path}") ? '✅ Exists' : '❌ Missing';
            
            echo "<tr>";
            echo "<td>{$record->id}</td>";
            echo "<td>{$record->title}</td>";
            echo "<td>{$record->tahun}</td>";
            echo "<td>{$activeStatus}</td>";
            echo "<td>{$imageStatus}</td>";
            echo "<td>{$record->created_at}</td>";
            echo "</tr>";
        }
        echo "</table>";
        
    } catch (Exception $e) {
        echo "<p class='error'>❌ Records Query Error: " . $e->getMessage() . "</p>";
    }
}

// 5. Test Model Method
echo "<h3>🧪 Model Method Test</h3>";
try {
    if (class_exists('App\Models\Apbdes')) {
        echo "<p class='ok'>✅ Apbdes Model: EXISTS</p>";
        
        // Test getActive method
        $activeApbdes = App\Models\Apbdes::getActive();
        echo "<p>📊 getActive() method returns: <strong>" . count($activeApbdes) . "</strong> records</p>";
        
        if (count($activeApbdes) > 0) {
            echo "<h4>Active Records Details:</h4>";
            echo "<ul>";
            foreach ($activeApbdes as $item) {
                $imageExists = file_exists("storage/{$item->image_path}") ? "✅" : "❌";
                echo "<li><strong>{$item->title}</strong> ({$item->tahun}) - Image: $imageExists</li>";
            }
            echo "</ul>";
        } else {
            echo "<p class='error'>❌ No active records found!</p>";
            echo "<p class='warn'>🔧 Check if records are set to active (is_active = 1)</p>";
        }
        
    } else {
        echo "<p class='error'>❌ Apbdes Model: NOT FOUND</p>";
    }
} catch (Exception $e) {
    echo "<p class='error'>❌ Model Test Error: " . $e->getMessage() . "</p>";
}

// 6. Check Storage and Images
echo "<h3>📁 Storage Check</h3>";
$storagePaths = [
    'storage/app/public' => 'Storage Directory',
    'public/storage' => 'Public Storage Link',
    'storage/app/public/apbdes' => 'APBDes Storage Folder'
];

foreach ($storagePaths as $path => $name) {
    if (is_dir($path) || is_link($path)) {
        echo "<p class='ok'>✅ $name: EXISTS</p>";
        
        if ($path === 'storage/app/public/apbdes' && is_dir($path)) {
            $files = scandir($path);
            $imageCount = count($files) - 2; // exclude . and ..
            echo "<p>📸 Images in folder: <strong>$imageCount</strong></p>";
        }
    } else {
        echo "<p class='error'>❌ $name: NOT FOUND</p>";
        if ($path === 'public/storage') {
            echo "<p class='warn'>🔧 Run: php artisan storage:link</p>";
        }
    }
}

// 7. Test Route
echo "<h3>🛣️ Route Test</h3>";
try {
    $routes = file_get_contents('routes/web.php');
    if (strpos($routes, 'transparansi-anggaran') !== false) {
        echo "<p class='ok'>✅ Transparansi Route: FOUND in routes/web.php</p>";
    } else {
        echo "<p class='error'>❌ Transparansi Route: NOT FOUND</p>";
    }
} catch (Exception $e) {
    echo "<p class='error'>❌ Route Check Error: " . $e->getMessage() . "</p>";
}

// 8. Check View File
if (file_exists('resources/views/transparansi-anggaran.blade.php')) {
    echo "<p class='ok'>✅ View File: EXISTS</p>";
} else {
    echo "<p class='error'>❌ View File: NOT FOUND</p>";
}

// 9. Environment Check
echo "<h3>🌍 Environment Info</h3>";
echo "<p>📍 PHP Version: " . PHP_VERSION . "</p>";
echo "<p>📍 Laravel Version: " . app()->version() . "</p>";
echo "<p>📍 Environment: " . app()->environment() . "</p>";
echo "<p>📍 Debug Mode: " . (config('app.debug') ? 'ON' : 'OFF') . "</p>";

echo "<h2>🎯 Summary & Next Steps</h2>";

if ($totalCount == 0) {
    echo "<div style='background:#ffeeee;padding:15px;border:1px solid #ff0000;border-radius:5px;'>";
    echo "<h3>❌ PROBLEM: No Data in Database</h3>";
    echo "<p><strong>Solution:</strong> Add APBDes data via admin panel</p>";
    echo "<p>1. Login to admin: <a href='/admin/login'>/admin/login</a></p>";
    echo "<p>2. Go to APBDes: <a href='/admin/apbdes'>/admin/apbdes</a></p>";
    echo "<p>3. Click 'Tambah APBDes' and upload documents</p>";
    echo "</div>";
} elseif ($activeCount == 0) {
    echo "<div style='background:#fff8ee;padding:15px;border:1px solid #ff8800;border-radius:5px;'>";
    echo "<h3>⚠️ PROBLEM: No Active Records</h3>";
    echo "<p><strong>Solution:</strong> Activate existing records</p>";
    echo "<p>1. Go to admin: <a href='/admin/apbdes'>/admin/apbdes</a></p>";
    echo "<p>2. Toggle the status to 'Active' for records you want to publish</p>";
    echo "</div>";
} else {
    echo "<div style='background:#eeffee;padding:15px;border:1px solid #00aa00;border-radius:5px;'>";
    echo "<h3>✅ SYSTEM LOOKS GOOD</h3>";
    echo "<p>Data exists and is active. If still not showing:</p>";
    echo "<p>1. Clear cache: <code>php artisan view:clear && php artisan route:clear</code></p>";
    echo "<p>2. Check browser cache (hard refresh: Ctrl+F5)</p>";
    echo "<p>3. Test direct link: <a href='/transparansi-anggaran'>/transparansi-anggaran</a></p>";
    echo "</div>";
}

echo "<hr>";
echo "<p><small>Debug script generated on " . date('Y-m-d H:i:s') . "</small></p>";
?>
