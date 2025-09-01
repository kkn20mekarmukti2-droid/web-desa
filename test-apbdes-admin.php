<?php
// 🧪 APBDes Admin Test Script
// Test script untuk verifikasi sistem APBDes admin berfungsi dengan benar
// File: test-apbdes-admin.php

echo "🏛️ ========================================\n";
echo "   APBDes Admin System Test\n";
echo "======================================== 🏛️\n\n";

// Test 1: Check if we're in Laravel project
if (!file_exists('artisan')) {
    echo "❌ ERROR: Not in Laravel project directory!\n";
    exit(1);
}
echo "✅ Laravel project detected\n";

// Test 2: Check Apbdes Model
try {
    require_once 'vendor/autoload.php';
    $app = require_once 'bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    
    if (class_exists('App\Models\Apbdes')) {
        echo "✅ Apbdes Model: EXISTS\n";
    } else {
        echo "❌ Apbdes Model: NOT FOUND\n";
    }
} catch (Exception $e) {
    echo "⚠️ Model test skipped: " . $e->getMessage() . "\n";
}

// Test 3: Check ApbdesController
if (file_exists('app/Http/Controllers/ApbdesController.php')) {
    echo "✅ ApbdesController: EXISTS\n";
    
    // Check if transparansi method exists
    $content = file_get_contents('app/Http/Controllers/ApbdesController.php');
    if (strpos($content, 'function transparansi') !== false) {
        echo "✅ transparansi method: EXISTS\n";
    } else {
        echo "❌ transparansi method: NOT FOUND\n";
    }
} else {
    echo "❌ ApbdesController: NOT FOUND\n";
}

// Test 4: Check Migration
if (file_exists('database/migrations/2025_09_01_000000_create_apbdes_table.php')) {
    echo "✅ APBDes Migration: EXISTS\n";
} else {
    echo "❌ APBDes Migration: NOT FOUND\n";
}

// Test 5: Check Views
$views = [
    'resources/views/transparansi-anggaran.blade.php' => 'Public View',
    'resources/views/admin/apbdes/index.blade.php' => 'Admin Index',
    'resources/views/admin/apbdes/create.blade.php' => 'Admin Create',
    'resources/views/admin/apbdes/edit.blade.php' => 'Admin Edit'
];

foreach ($views as $path => $name) {
    if (file_exists($path)) {
        echo "✅ $name: EXISTS\n";
        
        // Check extends directive
        $content = file_get_contents($path);
        if (strpos($content, '@extends(') !== false) {
            if (strpos($content, 'layout.admin-modern') !== false) {
                echo "   ✅ Uses correct layout (layout.admin-modern)\n";
            } elseif (strpos($content, 'layout.app') !== false) {
                echo "   ✅ Uses correct layout (layout.app)\n";
            } else {
                echo "   ⚠️ Layout directive found but path unclear\n";
            }
        }
    } else {
        echo "❌ $name: NOT FOUND\n";
    }
}

// Test 6: Check Layout File
if (file_exists('resources/views/layout/admin-modern.blade.php')) {
    echo "✅ Admin Layout: EXISTS\n";
} else {
    echo "❌ Admin Layout: NOT FOUND\n";
}

// Test 7: Check Routes (basic check)
if (file_exists('routes/web.php')) {
    echo "✅ Routes file: EXISTS\n";
    
    $routes = file_get_contents('routes/web.php');
    if (strpos($routes, 'transparansi-anggaran') !== false) {
        echo "   ✅ Public route: FOUND\n";
    }
    if (strpos($routes, 'admin/apbdes') !== false) {
        echo "   ✅ Admin routes: FOUND\n";
    }
}

// Test 8: Check Storage Directories
$storageDirectories = [
    'storage/app/public' => 'Storage Directory',
    'public/storage' => 'Public Storage Link'
];

foreach ($storageDirectories as $dir => $name) {
    if (is_dir($dir) || is_link($dir)) {
        echo "✅ $name: EXISTS\n";
    } else {
        echo "⚠️ $name: NOT FOUND (create if needed)\n";
    }
}

echo "\n📊 ========================================\n";
echo "           TEST SUMMARY\n";
echo "======================================== 📊\n";

echo "\n🎯 NEXT STEPS:\n";
echo "1. Test admin login: /admin/login\n";
echo "2. Access APBDes admin: /admin/apbdes\n";
echo "3. Test create APBDes: /admin/apbdes/create\n";
echo "4. Test public page: /transparansi-anggaran\n";

echo "\n🔧 IF ISSUES FOUND:\n";
echo "- Run: php artisan migrate\n";
echo "- Run: php artisan storage:link\n";
echo "- Run: php artisan view:clear\n";
echo "- Run: php artisan route:clear\n";

echo "\n🌐 BROWSER TEST URLs:\n";
echo "- Public: https://mekarmukti.id/transparansi-anggaran\n";
echo "- Admin:  https://mekarmukti.id/admin/apbdes\n";

echo "\n✅ APBDes System Test Completed!\n";
?>
