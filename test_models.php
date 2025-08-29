<?php
// Test file untuk memastikan model berfungsi
require_once __DIR__ . '/vendor/autoload.php';

use App\Models\artikelModel;
use App\Models\galleryModel;
use App\Models\kategoriModel;
use App\Models\User;

echo "<h1>🧪 Model Test - Admin Modern</h1>";

try {
    echo "<h2>✅ Testing Model Classes:</h2>";
    
    // Test artikelModel
    if (class_exists('App\Models\artikelModel')) {
        echo "✅ artikelModel: EXISTS<br>";
        try {
            $artikel_count = artikelModel::count();
            echo "&nbsp;&nbsp;📊 Total Articles: {$artikel_count}<br>";
        } catch (Exception $e) {
            echo "&nbsp;&nbsp;❌ Error counting articles: " . $e->getMessage() . "<br>";
        }
    } else {
        echo "❌ artikelModel: NOT FOUND<br>";
    }
    
    // Test galleryModel
    if (class_exists('App\Models\galleryModel')) {
        echo "✅ galleryModel: EXISTS<br>";
        try {
            $gallery_count = galleryModel::count();
            echo "&nbsp;&nbsp;📊 Total Gallery Items: {$gallery_count}<br>";
        } catch (Exception $e) {
            echo "&nbsp;&nbsp;❌ Error counting gallery: " . $e->getMessage() . "<br>";
        }
    } else {
        echo "❌ galleryModel: NOT FOUND<br>";
    }
    
    // Test kategoriModel
    if (class_exists('App\Models\kategoriModel')) {
        echo "✅ kategoriModel: EXISTS<br>";
        try {
            $kategori_count = kategoriModel::count();
            echo "&nbsp;&nbsp;📊 Total Categories: {$kategori_count}<br>";
        } catch (Exception $e) {
            echo "&nbsp;&nbsp;❌ Error counting categories: " . $e->getMessage() . "<br>";
        }
    } else {
        echo "❌ kategoriModel: NOT FOUND<br>";
    }
    
    // Test User
    if (class_exists('App\Models\User')) {
        echo "✅ User Model: EXISTS<br>";
        try {
            $user_count = User::count();
            echo "&nbsp;&nbsp;📊 Total Users: {$user_count}<br>";
        } catch (Exception $e) {
            echo "&nbsp;&nbsp;❌ Error counting users: " . $e->getMessage() . "<br>";
        }
    } else {
        echo "❌ User Model: NOT FOUND<br>";
    }
    
    echo "<hr>";
    echo "<h2>🔗 Testing Relationships:</h2>";
    
    try {
        $artikel_with_kategori = artikelModel::with('getKategori')->first();
        if ($artikel_with_kategori) {
            echo "✅ artikelModel->getKategori: WORKING<br>";
        } else {
            echo "⚠️ artikelModel->getKategori: No data to test<br>";
        }
    } catch (Exception $e) {
        echo "❌ artikelModel->getKategori: ERROR - " . $e->getMessage() . "<br>";
    }
    
    echo "<hr>";
    echo "<h2>🎯 Direct Route Test:</h2>";
    echo "Try these URLs:<br>";
    echo "• <a href='/admin/dashboard-modern' target='_blank'>/admin/dashboard-modern</a><br>";
    echo "• <a href='/admin/content/manage-modern' target='_blank'>/admin/content/manage-modern</a><br>";
    echo "• <a href='/admin/gallery-modern' target='_blank'>/admin/gallery-modern</a><br>";
    echo "• <a href='/admin/users-modern' target='_blank'>/admin/users-modern</a><br>";
    
} catch (Exception $e) {
    echo "❌ CRITICAL ERROR: " . $e->getMessage() . "<br>";
    echo "Stack trace: <pre>" . $e->getTraceAsString() . "</pre>";
}

echo "<hr>";
echo "<p><strong>If all models show ✅ EXISTS, the admin modern should work now!</strong></p>";
?>
