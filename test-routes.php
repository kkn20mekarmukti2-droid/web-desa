<?php
// Test all routes used in layout

echo "=== TESTING ROUTES USED IN LAYOUT ===\n";

$routesToTest = [
    'home',
    'sejarah', 
    'visi',
    'pemerintahan',
    'berita',
    'galeri',
    'potensidesa', 
    'data.penduduk',
    'kontak'
];

foreach ($routesToTest as $routeName) {
    try {
        $url = route($routeName);
        echo "✅ Route '{$routeName}' -> {$url}\n";
    } catch (Exception $e) {
        echo "❌ Route '{$routeName}' FAILED: " . $e->getMessage() . "\n";
    }
}

echo "\n=== ROUTES TEST COMPLETED ===\n";
?>
