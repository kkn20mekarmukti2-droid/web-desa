<?php

/**
 * PRODUCTION-READY USER ROLE UPDATE SCRIPT
 * Dengan pengecekan struktur database dan error handling
 */

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=================================\n";
echo "    USER ROLE UPDATE SCRIPT      \n";
echo "=================================\n\n";

try {
    // Step 1: Check database structure
    echo "🔍 Step 1: Checking database structure...\n";
    
    $connection = DB::connection();
    $database = $connection->getDatabaseName();
    echo "   Database: {$database}\n";
    
    // Check if role column accepts strings by testing
    try {
        // Test with a dummy ID that doesn't exist
        DB::table('users')->where('id', 999999)->update(['role' => 'TestStringRole']);
        echo "   ✅ Database structure: Role column accepts strings\n\n";
    } catch (Exception $e) {
        if (strpos($e->getMessage(), 'Incorrect integer value') !== false || 
            strpos($e->getMessage(), 'Invalid datetime format') !== false) {
            
            echo "   ❌ ERROR: Role column is INTEGER type!\n";
            echo "   🛠️  SOLUTION: Run database structure fix first:\n";
            echo "       php fix_database_structure.php\n\n";
            echo "   Or execute this SQL manually:\n";
            echo "       ALTER TABLE users MODIFY COLUMN role VARCHAR(50) DEFAULT 'Admin';\n\n";
            exit(1);
        }
        // Other errors are fine (like record not found)
    }

    // Step 2: Display current users  
    echo "📋 Step 2: Current users and roles...\n";
    $users = App\Models\User::select('id', 'name', 'email', 'role')->get();

    if ($users->isEmpty()) {
        echo "   ❌ No users found in database!\n";
        exit(1);
    }

    echo sprintf("   %-4s | %-20s | %-25s | %s\n", 'ID', 'Name', 'Email', 'Role');
    echo "   " . str_repeat('-', 65) . "\n";
    
    foreach ($users as $user) {
        $roleType = gettype($user->role);
        echo sprintf("   %-4s | %-20s | %-25s | %s (%s)\n", 
            $user->id, 
            substr($user->name, 0, 20), 
            substr($user->email, 0, 25), 
            $user->role, 
            $roleType
        );
    }

    // Step 3: Convert roles
    echo "\n🔄 Step 3: Converting roles to string format...\n";

    // Define comprehensive role mappings
    $roleMappings = [
        // Numeric to string mappings
        ['from' => [0, '0'], 'to' => 'SuperAdmin', 'desc' => 'Super Admin'],
        ['from' => [1, '1'], 'to' => 'Admin', 'desc' => 'Administrator'],
        ['from' => [2, '2'], 'to' => 'Writer', 'desc' => 'Content Writer'],
        ['from' => [3, '3'], 'to' => 'Editor', 'desc' => 'Content Editor'],
        
        // String normalization (case insensitive)
        ['from' => ['admin'], 'to' => 'Admin', 'desc' => 'Normalize admin'],
        ['from' => ['superadmin'], 'to' => 'SuperAdmin', 'desc' => 'Normalize superadmin'],
        ['from' => ['writer'], 'to' => 'Writer', 'desc' => 'Normalize writer'],
        ['from' => ['editor'], 'to' => 'Editor', 'desc' => 'Normalize editor'],
    ];

    $totalUpdated = 0;
    $updateDetails = [];

    foreach ($roleMappings as $mapping) {
        $usersToUpdate = App\Models\User::whereIn('role', $mapping['from'])->get();
        
        if ($usersToUpdate->count() > 0) {
            $updated = App\Models\User::whereIn('role', $mapping['from'])
                ->update(['role' => $mapping['to']]);
                
            if ($updated > 0) {
                $fromList = implode(', ', array_map(function($r) { return "'$r'"; }, $mapping['from']));
                echo "   ✅ {$mapping['desc']}: {$updated} users [{$fromList}] → '{$mapping['to']}'\n";
                
                $totalUpdated += $updated;
                $updateDetails[] = $mapping['desc'] . ": {$updated} users";
                
                // Show which users were updated
                foreach($usersToUpdate as $user) {
                    echo "      → {$user->name} ({$user->email})\n";
                }
            }
        }
    }

    if ($totalUpdated === 0) {
        echo "   ℹ️  No users needed role conversion.\n";
        echo "      All roles are already in correct string format.\n";
    } else {
        echo "\n   🎉 Successfully converted {$totalUpdated} user roles!\n";
    }

    // Step 4: Verify results
    echo "\n✅ Step 4: Final verification...\n";
    $finalUsers = App\Models\User::select('id', 'name', 'email', 'role')->get();

    echo sprintf("   %-4s | %-20s | %-25s | %-12s | %s\n", 'ID', 'Name', 'Email', 'Role', 'Status');
    echo "   " . str_repeat('-', 75) . "\n";
    
    $validRoles = ['SuperAdmin', 'Admin', 'Writer', 'Editor'];
    $validCount = 0;
    
    foreach($finalUsers as $user) {
        $isValid = in_array($user->role, $validRoles);
        $status = $isValid ? '✅ Valid' : '⚠️  Check';
        if ($isValid) $validCount++;
        
        echo sprintf("   %-4s | %-20s | %-25s | %-12s | %s\n", 
            $user->id, 
            substr($user->name, 0, 20), 
            substr($user->email, 0, 25), 
            $user->role, 
            $status
        );
    }

    // Step 5: Clear caches
    echo "\n🧹 Step 5: Clearing Laravel caches...\n";
    try {
        Artisan::call('config:clear');
        Artisan::call('cache:clear'); 
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        echo "   ✅ All caches cleared successfully!\n";
    } catch (Exception $e) {
        echo "   ⚠️  Cache clearing failed (non-critical): " . $e->getMessage() . "\n";
    }

    // Final summary
    echo "\n" . str_repeat('=', 50) . "\n";
    echo "           🎉 UPDATE COMPLETED!           \n";
    echo str_repeat('=', 50) . "\n";
    
    echo "\n📊 SUMMARY:\n";
    echo "• Total users: " . $users->count() . "\n";
    echo "• Users updated: {$totalUpdated}\n";
    echo "• Valid roles: {$validCount}/{$users->count()}\n";
    echo "• Available roles: " . implode(', ', $validRoles) . "\n";
    
    if (!empty($updateDetails)) {
        echo "\n📝 CHANGES MADE:\n";
        foreach($updateDetails as $detail) {
            echo "• {$detail}\n";
        }
    }
    
    echo "\n🎯 NEXT STEPS:\n";
    echo "1. Test login to admin panel\n";
    echo "2. Visit manage user page: /admin/manage-akun\n";
    echo "3. Verify role dropdown works correctly\n";
    echo "4. Test user permissions\n";
    echo "5. Delete this script file for security\n";

    // Additional validation
    if ($validCount !== $users->count()) {
        echo "\n⚠️  WARNING: Some users have invalid roles!\n";
        echo "   Please check and manually fix invalid roles.\n";
    }

} catch (Exception $e) {
    echo "\n❌ CRITICAL ERROR: " . $e->getMessage() . "\n";
    echo "\nStack trace:\n" . $e->getTraceAsString() . "\n";
    
    echo "\n🛠️  TROUBLESHOOTING:\n";
    echo "1. Check database connection\n";
    echo "2. Verify users table exists\n"; 
    echo "3. Run database structure fix: php fix_database_structure.php\n";
    echo "4. Check Laravel configuration\n";
    
    exit(1);
}

?>
