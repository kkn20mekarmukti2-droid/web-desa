<?php
require_once 'vendor/autoload.php';

// Load Laravel configuration
$app = require_once 'bootstrap/app.php';

// Boot the application
$app->boot();

// Check gallery table structure
echo "Gallery table structure:\n";
$columns = DB::select("SELECT name, type FROM pragma_table_info('gallery')");

foreach ($columns as $column) {
    echo "- {$column->name}: {$column->type}\n";
}

// Check sample data
echo "\nSample gallery data:\n";
$galleries = DB::table('gallery')->limit(3)->get();
foreach ($galleries as $gallery) {
    echo "ID: {$gallery->id}, Judul: {$gallery->judul}, URL: {$gallery->url}, Type: " . ($gallery->type ?? 'NULL') . "\n";
}
