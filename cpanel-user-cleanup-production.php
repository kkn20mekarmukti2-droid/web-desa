<?php
/**
 * Production Database User Cleanup Script for cPanel
 * This script will clean up the production database to keep only 2 specific users
 */

require_once __DIR__ . '/vendor/autoload.php';

// Load Laravel environment
$app = require_once __DIR__ . '/bootstrap/app.php';

// Set environment to production for cPanel database
putenv('DB_CONNECTION=mysql');

// Bootstrap Laravel
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

echo "=== PRODUCTION DATABASE USER CLEANUP SCRIPT ===" . PHP_EOL;
echo "This script will clean up users in the production database" . PHP_EOL;
echo "Only keeping: ASFHA NUGRAHA ARIFIN and Mohammad Nabil Abyyu" . PHP_EOL . PHP_EOL;

try {
    // Test database connection
    echo "Testing database connection..." . PHP_EOL;
    $connection = DB::connection();
    $pdo = $connection->getPdo();
    echo "✓ Connected to database: " . $connection->getDatabaseName() . PHP_EOL;
    
    // Show current users
    echo PHP_EOL . "=== CURRENT USERS IN PRODUCTION DATABASE ===" . PHP_EOL;
    $currentUsers = User::all();
    
    if ($currentUsers->isEmpty()) {
        echo "No users found in database." . PHP_EOL;
        exit;
    }
    
    foreach ($currentUsers as $user) {
        echo "ID: {$user->id} | Name: {$user->name} | Email: {$user->email} | Role: {$user->role}" . PHP_EOL;
    }
    
    echo PHP_EOL . "Total users before cleanup: " . $currentUsers->count() . PHP_EOL;
    
    // Define users to keep
    $usersToKeep = [
        'ASFHA NUGRAHA ARIFIN',
        'Mohammad Nabil Abyyu'
    ];
    
    // Delete all users except the ones we want to keep
    echo PHP_EOL . "=== STARTING USER CLEANUP ===" . PHP_EOL;
    
    $deletedCount = 0;
    foreach ($currentUsers as $user) {
        if (!in_array($user->name, $usersToKeep)) {
            echo "Deleting user: {$user->name} (ID: {$user->id})" . PHP_EOL;
            $user->delete();
            $deletedCount++;
        } else {
            echo "Keeping user: {$user->name} (ID: {$user->id})" . PHP_EOL;
        }
    }
    
    echo PHP_EOL . "Deleted {$deletedCount} users from production database." . PHP_EOL;
    
    // Ensure the users we want to keep exist with correct data
    echo PHP_EOL . "=== ENSURING TARGET USERS EXIST ===" . PHP_EOL;
    
    // User 1: ASFHA NUGRAHA ARIFIN (Admin)
    $admin = User::where('name', 'ASFHA NUGRAHA ARIFIN')->first();
    if (!$admin) {
        echo "Creating admin user: ASFHA NUGRAHA ARIFIN" . PHP_EOL;
        $admin = User::create([
            'name' => 'ASFHA NUGRAHA ARIFIN',
            'email' => 'admin@webdesa.com',
            'password' => Hash::make('admin123'),
            'role' => 0, // Admin role
        ]);
    } else {
        echo "Updating admin user: ASFHA NUGRAHA ARIFIN" . PHP_EOL;
        $admin->update([
            'email' => 'admin@webdesa.com',
            'password' => Hash::make('admin123'),
            'role' => 0, // Admin role
        ]);
    }
    
    // User 2: Mohammad Nabil Abyyu (Writer)
    $writer = User::where('name', 'Mohammad Nabil Abyyu')->first();
    if (!$writer) {
        echo "Creating writer user: Mohammad Nabil Abyyu" . PHP_EOL;
        $writer = User::create([
            'name' => 'Mohammad Nabil Abyyu',
            'email' => 'writer@webdesa.com',
            'password' => Hash::make('writer123'),
            'role' => 1, // Writer role
        ]);
    } else {
        echo "Updating writer user: Mohammad Nabil Abyyu" . PHP_EOL;
        $writer->update([
            'email' => 'writer@webdesa.com',
            'password' => Hash::make('writer123'),
            'role' => 1, // Writer role
        ]);
    }
    
    // Show final results
    echo PHP_EOL . "=== FINAL USER LIST IN PRODUCTION DATABASE ===" . PHP_EOL;
    $finalUsers = User::all();
    
    foreach ($finalUsers as $user) {
        $roleText = $user->role == 0 ? 'Admin' : 'Writer';
        echo "ID: {$user->id} | Name: {$user->name} | Email: {$user->email} | Role: {$roleText}" . PHP_EOL;
    }
    
    echo PHP_EOL . "Total users after cleanup: " . $finalUsers->count() . PHP_EOL;
    echo PHP_EOL . "=== PRODUCTION DATABASE CLEANUP COMPLETED SUCCESSFULLY ===" . PHP_EOL;
    echo "Login credentials:" . PHP_EOL;
    echo "1. Admin - Email: admin@webdesa.com, Password: admin123" . PHP_EOL;
    echo "2. Writer - Email: writer@webdesa.com, Password: writer123" . PHP_EOL;
    
} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . PHP_EOL;
    echo "Line: " . $e->getLine() . PHP_EOL;
    echo "File: " . $e->getFile() . PHP_EOL;
    
    if ($e instanceof PDOException) {
        echo "Database Error Details: " . $e->errorInfo[2] ?? 'Unknown database error' . PHP_EOL;
    }
}

echo PHP_EOL . "=== SCRIPT EXECUTION COMPLETED ===" . PHP_EOL;
?>
