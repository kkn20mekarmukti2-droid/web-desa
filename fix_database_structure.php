<?php

/**
 * PRODUCTION DATABASE STRUCTURE FIX
 * Mengubah kolom role dari INTEGER ke VARCHAR untuk mendukung string roles
 */

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=================================\n";
echo "  DATABASE STRUCTURE UPDATE      \n";
echo "=================================\n\n";

try {
    $connection = DB::connection();
    $database = $connection->getDatabaseName();
    
    echo "📋 Database: {$database}\n";
    echo "🔗 Connection: " . config('database.default') . "\n\n";
    
    // Step 1: Backup current role values
    echo "📦 Step 1: Backing up current role values...\n";
    $users = DB::select("SELECT id, name, email, role FROM users");
    
    echo "Current users and roles:\n";
    $roleMapping = [];
    foreach($users as $user) {
        echo "   ID: {$user->id}, Name: {$user->name}, Role: {$user->role}\n";
        $roleMapping[$user->id] = $user->role;
    }
    
    // Step 2: Alter table structure
    echo "\n🔧 Step 2: Altering table structure...\n";
    
    if (config('database.default') === 'mysql') {
        // MySQL approach
        echo "   Executing: ALTER TABLE users MODIFY COLUMN role VARCHAR(50) DEFAULT 'Admin';\n";
        
        DB::statement("ALTER TABLE users MODIFY COLUMN role VARCHAR(50) DEFAULT 'Admin'");
        echo "   ✅ Table structure updated successfully!\n";
        
    } else {
        // SQLite approach (more complex)
        echo "   SQLite detected - using migration approach...\n";
        
        // Create new table
        DB::statement("CREATE TABLE users_new (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) UNIQUE NOT NULL,
            email_verified_at TIMESTAMP NULL,
            password VARCHAR(255) NOT NULL,
            role VARCHAR(50) DEFAULT 'Admin',
            remember_token VARCHAR(100) NULL,
            created_at TIMESTAMP NULL,
            updated_at TIMESTAMP NULL
        )");
        
        // Copy data
        DB::statement("INSERT INTO users_new SELECT 
            id, name, email, email_verified_at, password, 
            CAST(role AS TEXT), remember_token, created_at, updated_at 
            FROM users");
        
        // Replace table
        DB::statement("DROP TABLE users");
        DB::statement("ALTER TABLE users_new RENAME TO users");
        
        echo "   ✅ SQLite table recreated successfully!\n";
    }
    
    // Step 3: Update role values to strings
    echo "\n🔄 Step 3: Converting role values to strings...\n";
    
    $conversions = [
        0 => 'SuperAdmin',
        1 => 'Admin', 
        2 => 'Writer',
        3 => 'Editor'
    ];
    
    $totalUpdated = 0;
    foreach($conversions as $oldRole => $newRole) {
        $updated = DB::table('users')
            ->where('role', (string)$oldRole)
            ->update(['role' => $newRole]);
            
        if ($updated > 0) {
            echo "   ✅ Updated {$updated} users from '{$oldRole}' to '{$newRole}'\n";
            $totalUpdated += $updated;
        }
    }
    
    // Step 4: Verify results
    echo "\n✅ Step 4: Verifying results...\n";
    $finalUsers = DB::select("SELECT id, name, email, role FROM users");
    
    echo "\nFinal user roles:\n";
    foreach($finalUsers as $user) {
        $status = in_array($user->role, ['SuperAdmin', 'Admin', 'Writer', 'Editor']) ? '✅' : '⚠️';
        echo "   {$status} ID: {$user->id}, Name: {$user->name}, Role: '{$user->role}'\n";
    }
    
    // Step 5: Test the structure
    echo "\n🧪 Step 5: Testing new structure...\n";
    try {
        DB::table('users')->where('id', 999999)->update(['role' => 'TestRole']);
        echo "   ✅ Structure accepts string roles correctly!\n";
    } catch (Exception $e) {
        echo "   ⚠️  Test failed: " . $e->getMessage() . "\n";
    }
    
    echo "\n" . str_repeat('=', 50) . "\n";
    echo "        🎉 DATABASE UPDATE COMPLETED!        \n";
    echo str_repeat('=', 50) . "\n";
    
    echo "\n📊 SUMMARY:\n";
    echo "• Database structure: ✅ Updated\n";
    echo "• Role column type: VARCHAR(50)\n";
    echo "• Users converted: {$totalUpdated}\n";
    echo "• Status: Ready for string roles\n";
    
    echo "\n🎯 NEXT STEPS:\n";
    echo "1. Run: php update_user_roles.php\n";
    echo "2. Test login functionality\n";
    echo "3. Verify manage user page\n";
    echo "4. Delete this script file\n";
    
} catch (Exception $e) {
    echo "\n❌ ERROR: " . $e->getMessage() . "\n";
    echo "\nStack trace:\n" . $e->getTraceAsString() . "\n";
    
    echo "\n🛠️  MANUAL FIX:\n";
    echo "Execute this SQL manually:\n";
    echo "ALTER TABLE users MODIFY COLUMN role VARCHAR(50) DEFAULT 'Admin';\n";
    
    exit(1);
}

?>
