<?php
/**
 * Simple verification script for cPanel production database
 * This script checks the current users in production database
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

echo "=== PRODUCTION DATABASE USER VERIFICATION ===" . PHP_EOL;

try {
    // Test database connection
    $connection = DB::connection();
    echo "✓ Connected to database: " . $connection->getDatabaseName() . PHP_EOL . PHP_EOL;
    
    // Get all users
    $users = User::all();
    echo "Total users in production database: " . $users->count() . PHP_EOL . PHP_EOL;
    
    if ($users->isEmpty()) {
        echo "❌ No users found in database!" . PHP_EOL;
    } else {
        echo "Current users:" . PHP_EOL;
        foreach ($users as $user) {
            $role = $user->role == 0 ? 'Admin' : ($user->role == 1 ? 'Writer' : 'Unknown');
            echo "• ID: {$user->id} | {$user->name} | {$user->email} | Role: {$role}" . PHP_EOL;
        }
        
        echo PHP_EOL;
        
        // Check if we have the expected users
        $expectedUsers = ['ASFHA NUGRAHA ARIFIN', 'Mohammad Nabil Abyyu'];
        $foundUsers = [];
        
        foreach ($users as $user) {
            if (in_array($user->name, $expectedUsers)) {
                $foundUsers[] = $user->name;
            }
        }
        
        echo "=== VERIFICATION RESULTS ===" . PHP_EOL;
        if (count($foundUsers) == 2 && $users->count() == 2) {
            echo "✅ SUCCESS: Database cleanup completed correctly!" . PHP_EOL;
            echo "✅ Only the 2 required users exist in production" . PHP_EOL;
        } else {
            echo "❌ ISSUE: Database cleanup may need to be run" . PHP_EOL;
            echo "Expected 2 users, found: " . $users->count() . PHP_EOL;
            echo "Missing users: " . implode(', ', array_diff($expectedUsers, $foundUsers)) . PHP_EOL;
        }
    }
    
} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . PHP_EOL;
    echo "This might indicate database connection issues." . PHP_EOL;
}

echo PHP_EOL . "=== VERIFICATION COMPLETED ===" . PHP_EOL;
?>
