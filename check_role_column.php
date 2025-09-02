<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== CHECKING ROLE COLUMN STRUCTURE ===\n\n";

try {
    // Get database connection info
    $connection = DB::connection();
    $database = $connection->getDatabaseName();
    
    echo "Database: {$database}\n";
    echo "Connection: " . config('database.default') . "\n\n";
    
    // Check table structure
    if (config('database.default') === 'mysql') {
        $columns = DB::select("DESCRIBE users");
        
        echo "=== USERS TABLE STRUCTURE ===\n";
        echo sprintf("%-15s | %-15s | %-8s | %-8s | %-10s | %s\n", 
            'Field', 'Type', 'Null', 'Key', 'Default', 'Extra');
        echo str_repeat('-', 80) . "\n";
        
        foreach($columns as $column) {
            echo sprintf("%-15s | %-15s | %-8s | %-8s | %-10s | %s\n",
                $column->Field,
                $column->Type,
                $column->Null,
                $column->Key ?: '',
                $column->Default ?: '',
                $column->Extra ?: ''
            );
            
            // Check if role column
            if ($column->Field === 'role') {
                echo "\n🔍 ROLE COLUMN DETAILS:\n";
                echo "   Type: {$column->Type}\n";
                echo "   Allows NULL: {$column->Null}\n";
                echo "   Default: " . ($column->Default ?: 'NULL') . "\n";
                
                if (strpos(strtolower($column->Type), 'int') !== false) {
                    echo "   ❌ PROBLEM: Role column is INTEGER type!\n";
                    echo "   ✅ SOLUTION: Need to ALTER to VARCHAR\n";
                } else {
                    echo "   ✅ Good: Role column accepts strings\n";
                }
            }
        }
        
    } else {
        // SQLite
        $columns = DB::select("PRAGMA table_info(users)");
        
        echo "=== USERS TABLE STRUCTURE (SQLite) ===\n";
        foreach($columns as $column) {
            echo "Column: {$column->name}, Type: {$column->type}, NotNull: {$column->notnull}\n";
        }
    }
    
    // Check current users
    echo "\n=== CURRENT USER DATA ===\n";
    $users = DB::select("SELECT id, name, email, role FROM users LIMIT 5");
    
    foreach($users as $user) {
        $roleType = gettype($user->role);
        echo "ID: {$user->id}, Role: '{$user->role}' (type: {$roleType})\n";
    }
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}

?>
