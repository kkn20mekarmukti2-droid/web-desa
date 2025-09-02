<?php

/**
 * CPANEL USER ROLE UPDATE SCRIPT
 * Script untuk mengupdate user roles dari numeric (0,1) ke string (SuperAdmin, Admin, dll)
 * 
 * Usage:
 * - Via Browser: buka http://yourdomain.com/cpanel-update-user-roles.php
 * - Via Terminal: php cpanel-update-user-roles.php
 */

echo "=================================\n";
echo "  CPANEL USER ROLE UPDATE SCRIPT  \n";
echo "=================================\n\n";

try {
    // Load Laravel
    require_once 'vendor/autoload.php';
    $app = require_once 'bootstrap/app.php';
    $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
    
    echo "📋 Checking current users and roles...\n\n";
    
    // Get all users
    $users = App\Models\User::select('id', 'name', 'email', 'role', 'created_at')->get();
    
    if ($users->isEmpty()) {
        echo "❌ No users found in database!\n";
        exit(1);
    }
    
    echo "=== CURRENT USERS ===\n";
    echo sprintf("%-4s | %-20s | %-25s | %-12s | %s\n", 'ID', 'Name', 'Email', 'Role', 'Created');
    echo str_repeat('-', 80) . "\n";
    
    foreach($users as $user) {
        echo sprintf("%-4s | %-20s | %-25s | %-12s | %s\n", 
            $user->id, 
            substr($user->name, 0, 20), 
            substr($user->email, 0, 25), 
            "'{$user->role}'", 
            $user->created_at->format('d/m/Y')
        );
    }
    
    echo "\n🔄 Starting role updates...\n\n";
    
    // Define role mappings
    $roleMappings = [
        // Numeric to String mappings
        ['from' => [0, '0'], 'to' => 'SuperAdmin', 'desc' => 'Numeric 0 → SuperAdmin'],
        ['from' => [1, '1'], 'to' => 'Admin', 'desc' => 'Numeric 1 → Admin'],
        ['from' => [2, '2'], 'to' => 'Writer', 'desc' => 'Numeric 2 → Writer'],
        ['from' => [3, '3'], 'to' => 'Editor', 'desc' => 'Numeric 3 → Editor'],
        
        // String normalization
        ['from' => ['admin'], 'to' => 'Admin', 'desc' => 'Normalize admin → Admin'],
        ['from' => ['writer'], 'to' => 'Writer', 'desc' => 'Normalize writer → Writer'],
        ['from' => ['editor'], 'to' => 'Editor', 'desc' => 'Normalize editor → Editor'],
        ['from' => ['superadmin'], 'to' => 'SuperAdmin', 'desc' => 'Normalize superadmin → SuperAdmin'],
    ];
    
    $totalUpdated = 0;
    $updateLog = [];
    
    foreach ($roleMappings as $mapping) {
        $usersToUpdate = App\Models\User::whereIn('role', $mapping['from'])->get();
        
        if ($usersToUpdate->count() > 0) {
            $updated = App\Models\User::whereIn('role', $mapping['from'])
                ->update(['role' => $mapping['to']]);
            
            if ($updated > 0) {
                echo "✅ {$mapping['desc']}: {$updated} users\n";
                $totalUpdated += $updated;
                $updateLog[] = $mapping['desc'] . ": {$updated} users";
                
                // Log which users were updated
                foreach($usersToUpdate as $user) {
                    echo "   → {$user->name} ({$user->email})\n";
                }
            }
        }
    }
    
    if ($totalUpdated === 0) {
        echo "ℹ️  No users needed role updates.\n";
        echo "   All roles are already in correct string format.\n";
    } else {
        echo "\n🎉 Successfully updated {$totalUpdated} user roles!\n";
    }
    
    echo "\n=== UPDATED USERS ===\n";
    echo sprintf("%-4s | %-20s | %-25s | %-12s | %s\n", 'ID', 'Name', 'Email', 'Role', 'Status');
    echo str_repeat('-', 80) . "\n";
    
    $finalUsers = App\Models\User::select('id', 'name', 'email', 'role')->get();
    foreach($finalUsers as $user) {
        $status = in_array($user->role, ['SuperAdmin', 'Admin', 'Writer', 'Editor']) ? '✅ Valid' : '⚠️  Check';
        echo sprintf("%-4s | %-20s | %-25s | %-12s | %s\n", 
            $user->id, 
            substr($user->name, 0, 20), 
            substr($user->email, 0, 25), 
            $user->role, 
            $status
        );
    }
    
    // Clear Laravel caches
    echo "\n🧹 Clearing Laravel caches...\n";
    try {
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        echo "✅ Caches cleared successfully!\n";
    } catch (Exception $e) {
        echo "⚠️  Cache clearing failed (non-critical): " . $e->getMessage() . "\n";
    }
    
    echo "\n" . str_repeat('=', 50) . "\n";
    echo "           ✅ UPDATE COMPLETED!           \n";
    echo str_repeat('=', 50) . "\n";
    
    echo "\n📊 SUMMARY:\n";
    echo "• Total users processed: " . $users->count() . "\n";
    echo "• Users updated: {$totalUpdated}\n";
    echo "• Available roles: SuperAdmin, Admin, Writer, Editor\n";
    
    if (!empty($updateLog)) {
        echo "\n📝 CHANGES MADE:\n";
        foreach($updateLog as $log) {
            echo "• {$log}\n";
        }
    }
    
    echo "\n🎯 NEXT STEPS:\n";
    echo "• Test login to admin panel\n";
    echo "• Visit: " . (isset($_SERVER['HTTP_HOST']) ? 'http://' . $_SERVER['HTTP_HOST'] . '/admin/manage-akun' : 'your-domain.com/admin/manage-akun') . "\n";
    echo "• Verify all user roles are correct\n";
    echo "• Delete this script file for security\n";
    
} catch (Exception $e) {
    echo "\n❌ ERROR: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
    exit(1);
}

// If running via browser, add HTML formatting
if (isset($_SERVER['HTTP_HOST'])) {
    echo "\n\n<!-- Script completed. You can safely delete this file now. -->";
}

?>
