<?php

/**
 * SCRIPT UNTUK MEMBUAT USER BARU SEBAGAI SUPERADMIN
 * Akan menjadi SuperAdmin kedua dalam sistem
 */

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=================================\n";
echo "    CREATE NEW SUPERADMIN USER    \n";
echo "=================================\n\n";

try {
    // Check current users
    echo "📋 Current users in system:\n";
    $users = App\Models\User::all();
    foreach($users as $user) {
        echo "   ID: {$user->id}, Name: {$user->name}, Email: {$user->email}, Role: {$user->role}\n";
    }
    
    // Create new SuperAdmin user
    echo "\n🔧 Creating new SuperAdmin user...\n";
    
    $newUser = App\Models\User::create([
        'name' => 'Mohammad Nabil Abyyu',
        'email' => 'writer@webdesa.com',
        'password' => Hash::make('password123'),
        'role' => 'SuperAdmin',
    ]);
    
    echo "✅ New SuperAdmin user created successfully!\n";
    echo "   ID: {$newUser->id}\n";
    echo "   Name: {$newUser->name}\n";
    echo "   Email: {$newUser->email}\n";
    echo "   Role: {$newUser->role}\n";
    echo "   Password: password123 (change after first login)\n";
    echo "   Created: " . $newUser->created_at->format('d M Y, H:i') . "\n";
    
    // Show all SuperAdmins
    echo "\n📊 All SuperAdmins in system:\n";
    $superAdmins = App\Models\User::where('role', 'SuperAdmin')->get();
    
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
    
    // Update specific user if ID is different
    if ($newUser->id !== 5) {
        echo "\n📝 Note: User created with ID {$newUser->id} instead of ID 5\n";
        echo "   This is normal and will work perfectly.\n";
    }
    
    echo "\n" . str_repeat('=', 50) . "\n";
    echo "        ✅ SUPERADMIN CREATED!        \n";
    echo str_repeat('=', 50) . "\n";
    
    echo "\n🔑 LOGIN CREDENTIALS:\n";
    echo "• Email: writer@webdesa.com\n";
    echo "• Password: password123\n";
    echo "• Role: SuperAdmin\n";
    
    echo "\n🎯 NEXT STEPS:\n";
    echo "1. Login dengan credentials di atas\n";
    echo "2. Change password setelah first login\n";
    echo "3. Test all SuperAdmin permissions\n";
    echo "4. Verify user management access\n";
    echo "5. Delete this script file for security\n";
    
} catch (Exception $e) {
    // Check if user already exists
    if (strpos($e->getMessage(), 'Duplicate entry') !== false || strpos($e->getMessage(), 'UNIQUE constraint failed') !== false) {
        echo "⚠️  User dengan email 'writer@webdesa.com' sudah ada!\n\n";
        
        // Try to find and update existing user
        $existingUser = App\Models\User::where('email', 'writer@webdesa.com')->first();
        if ($existingUser) {
            echo "📋 Found existing user:\n";
            echo "   ID: {$existingUser->id}\n";
            echo "   Name: {$existingUser->name}\n";
            echo "   Email: {$existingUser->email}\n";
            echo "   Current Role: {$existingUser->role}\n";
            
            if ($existingUser->role !== 'SuperAdmin') {
                echo "\n🔧 Updating existing user to SuperAdmin...\n";
                $oldRole = $existingUser->role;
                $existingUser->role = 'SuperAdmin';
                $existingUser->save();
                
                echo "✅ User updated successfully!\n";
                echo "   Role changed: {$oldRole} → SuperAdmin\n";
            } else {
                echo "\n✅ User already has SuperAdmin role!\n";
            }
            
            echo "\n🔑 LOGIN CREDENTIALS:\n";
            echo "• Email: {$existingUser->email}\n";
            echo "• Password: [existing password]\n";
            echo "• Role: SuperAdmin\n";
        }
    } else {
        echo "\n❌ ERROR: " . $e->getMessage() . "\n";
        exit(1);
    }
}

?>
