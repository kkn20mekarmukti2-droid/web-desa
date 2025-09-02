<?php

/**
 * SCRIPT UPDATE USER ID 5 MENJADI SUPERADMIN
 * Untuk cPanel phpMyAdmin deployment
 */

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=================================\n";
echo "  UPDATE USER ID 5 TO SUPERADMIN  \n";
echo "=================================\n\n";

try {
    // Check if user ID 5 exists
    $user = App\Models\User::find(5);
    
    if (!$user) {
        echo "❌ User dengan ID 5 tidak ditemukan!\n";
        
        // Show available users
        $users = App\Models\User::all();
        echo "\n📋 Users yang tersedia:\n";
        foreach($users as $u) {
            echo "   ID: {$u->id}, Name: {$u->name}, Email: {$u->email}, Role: {$u->role}\n";
        }
        
        echo "\n💡 Tip: Update script dengan ID yang benar.\n";
        exit(1);
    }
    
    echo "📋 User ditemukan:\n";
    echo "   ID: {$user->id}\n";
    echo "   Name: {$user->name}\n";
    echo "   Email: {$user->email}\n";
    echo "   Current Role: {$user->role}\n";
    echo "   Created: {$user->created_at->format('d M Y, H:i')}\n\n";
    
    // Check if already SuperAdmin
    if ($user->role === 'SuperAdmin') {
        echo "ℹ️  User sudah memiliki role SuperAdmin!\n";
        echo "   Tidak perlu update.\n";
    } else {
        // Update to SuperAdmin
        $oldRole = $user->role;
        $user->role = 'SuperAdmin';
        $user->save();
        
        echo "✅ Success! User berhasil diupdate:\n";
        echo "   Role lama: {$oldRole}\n";
        echo "   Role baru: SuperAdmin\n";
        echo "   Updated at: " . now()->format('d M Y, H:i') . "\n";
    }
    
    // Show current SuperAdmins
    echo "\n📊 Current SuperAdmins:\n";
    $superAdmins = App\Models\User::where('role', 'SuperAdmin')->get();
    
    if ($superAdmins->count() > 0) {
        echo sprintf("   %-4s | %-25s | %-30s | %s\n", 'ID', 'Name', 'Email', 'Created');
        echo "   " . str_repeat('-', 75) . "\n";
        
        foreach($superAdmins as $admin) {
            echo sprintf("   %-4s | %-25s | %-30s | %s\n", 
                $admin->id, 
                substr($admin->name, 0, 25), 
                substr($admin->email, 0, 30), 
                $admin->created_at->format('d/m/Y')
            );
        }
        
        echo "\n🎉 Total SuperAdmins: " . $superAdmins->count() . "\n";
    } else {
        echo "   ⚠️  Tidak ada SuperAdmin ditemukan!\n";
    }
    
    // Clear Laravel caches
    echo "\n🧹 Clearing Laravel caches...\n";
    try {
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        echo "   ✅ Caches cleared successfully!\n";
    } catch (Exception $e) {
        echo "   ⚠️  Cache clearing failed (non-critical): " . $e->getMessage() . "\n";
    }
    
    echo "\n" . str_repeat('=', 50) . "\n";
    echo "           ✅ UPDATE COMPLETED!           \n";
    echo str_repeat('=', 50) . "\n";
    
    echo "\n🎯 NEXT STEPS:\n";
    echo "1. Test login dengan user ID 5\n";
    echo "2. Verify SuperAdmin permissions\n";
    echo "3. Check admin panel access\n";
    echo "4. Delete this script file for security\n";
    
    echo "\n🔐 SECURITY REMINDER:\n";
    echo "• Both SuperAdmins can manage all users\n";
    echo "• SuperAdmins can create/edit other SuperAdmins\n";
    echo "• Regular Admins cannot modify SuperAdmins\n";
    
} catch (Exception $e) {
    echo "\n❌ ERROR: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
    
    echo "\n🛠️  MANUAL ALTERNATIVE:\n";
    echo "Execute this SQL in cPanel phpMyAdmin:\n";
    echo "UPDATE users SET role = 'SuperAdmin' WHERE id = 5;\n";
    
    exit(1);
}

?>
