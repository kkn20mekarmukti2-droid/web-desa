<?php
require_once __DIR__ . '/vendor/autoload.php';

// Load Laravel configuration
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

try {
    echo "=== CHECKING USERS TABLE STRUCTURE ===\n";
    
    // Check table structure
    $columns = Schema::getColumnListing('users');
    echo "Columns in users table: " . implode(', ', $columns) . "\n\n";
    
    // Check current role values
    echo "=== CURRENT ROLE VALUES ===\n";
    $users = DB::table('users')->select('id', 'name', 'email', 'role')->get();
    
    foreach ($users as $user) {
        echo "ID: {$user->id} | Name: {$user->name} | Email: {$user->email} | Role: {$user->role}\n";
    }
    
    echo "\n=== ROLE VALUE DISTRIBUTION ===\n";
    $roleStats = DB::table('users')
        ->select('role', DB::raw('COUNT(*) as count'))
        ->groupBy('role')
        ->get();
    
    foreach ($roleStats as $stat) {
        echo "Role '{$stat->role}': {$stat->count} users\n";
    }
    
    echo "\nScript completed successfully!\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}
