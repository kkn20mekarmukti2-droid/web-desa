<?php
require_once 'vendor/autoload.php';

// Bootstrap Laravel app
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Majalah;
use App\Models\MajalahPage;

echo "🔍 Debugging Majalah Image Paths...\n\n";

// Get all magazines
$majalah = Majalah::with('pages')->get();

foreach ($majalah as $mag) {
    echo "📚 Majalah: {$mag->judul}\n";
    echo "Cover Image Path: {$mag->cover_image}\n";
    
    // Check if cover file exists
    $coverPath = public_path('storage/' . $mag->cover_image);
    $coverExists = file_exists($coverPath);
    echo "Cover Exists: " . ($coverExists ? "✅ YES" : "❌ NO") . "\n";
    echo "Full Cover Path: {$coverPath}\n";
    
    // Check URL
    $coverUrl = asset('storage/' . $mag->cover_image);
    echo "Cover URL: {$coverUrl}\n\n";
    
    // Check pages
    echo "📄 Pages:\n";
    foreach ($mag->pages->sortBy('page_number') as $page) {
        $pagePath = public_path('storage/' . $page->image_path);
        $pageExists = file_exists($pagePath);
        echo "  Page {$page->page_number}: {$page->image_path} - " . ($pageExists ? "✅" : "❌") . "\n";
    }
    
    echo "\n" . str_repeat("-", 50) . "\n\n";
}

// Check directory structure
echo "📁 Directory Structure Check:\n";
$storagePath = storage_path('app/public/majalah');
$publicPath = public_path('storage/majalah');

echo "Storage Path: {$storagePath} - " . (is_dir($storagePath) ? "✅" : "❌") . "\n";
echo "Public Symlink: {$publicPath} - " . (is_dir($publicPath) ? "✅" : "❌") . "\n";

if (is_dir($storagePath)) {
    echo "\nFiles in storage/app/public/majalah:\n";
    $files = glob($storagePath . '/*');
    foreach ($files as $file) {
        echo "  " . basename($file) . " - " . (is_file($file) ? "FILE" : "DIR") . "\n";
        if (is_dir($file) && basename($file) === 'pages') {
            $pageFiles = glob($file . '/*/*');
            foreach ($pageFiles as $pageFile) {
                echo "    " . str_replace($storagePath . '/', '', $pageFile) . "\n";
            }
        }
    }
}

// Test URL accessibility
echo "\n🌐 URL Accessibility Test:\n";
$testUrls = [
    asset('storage/majalah/sample-cover.jpg'),
    asset('storage/majalah/sample-cover-2.jpg'),
    asset('storage/majalah/pages/1/page-1.jpg'),
];

foreach ($testUrls as $url) {
    echo "Testing: {$url}\n";
    $headers = @get_headers($url);
    $accessible = $headers && strpos($headers[0], '200') !== false;
    echo "Accessible: " . ($accessible ? "✅ YES" : "❌ NO") . "\n\n";
}

echo "🎯 Summary:\n";
echo "- Total Magazines: " . $majalah->count() . "\n";
echo "- Total Pages: " . $majalah->sum(fn($m) => $m->pages->count()) . "\n";
echo "- Storage Directory: " . (is_dir($storagePath) ? "OK" : "MISSING") . "\n";
echo "- Public Symlink: " . (is_dir($publicPath) ? "OK" : "MISSING") . "\n";

echo "\n✨ Debugging Complete!\n";
