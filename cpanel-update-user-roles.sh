#!/bin/bash

# CPANEL USER ROLE UPDATE SCRIPT
# Script untuk mengupdate role user dari numeric ke string
# Usage: bash cpanel-update-user-roles.sh

echo "==================================="
echo "   CPANEL USER ROLE UPDATE SCRIPT  "
echo "==================================="
echo ""

# Check if we're in the correct directory
if [ ! -f "artisan" ]; then
    echo "❌ Error: File artisan tidak ditemukan!"
    echo "   Pastikan Anda menjalankan script ini dari root directory Laravel"
    exit 1
fi

echo "📋 Memulai update user roles..."
echo ""

# Create PHP script for updating roles
cat > temp_update_roles.php << 'EOF'
<?php
require_once 'vendor/autoload.php';

try {
    $app = require_once 'bootstrap/app.php';
    $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
    
    echo "=== CURRENT USERS AND ROLES ===\n";
    $users = App\Models\User::select('id', 'name', 'email', 'role')->get();
    
    if ($users->isEmpty()) {
        echo "Tidak ada user ditemukan.\n";
        exit(1);
    }
    
    echo "Total users: " . $users->count() . "\n\n";
    
    foreach($users as $user) {
        echo "ID: {$user->id} | Name: {$user->name} | Email: {$user->email} | Role: '{$user->role}'\n";
    }
    
    echo "\n=== UPDATING ROLES ===\n";
    
    // Update users with role 0 or 1 to appropriate string roles
    $updates = [
        ['from' => [0, '0'], 'to' => 'SuperAdmin', 'description' => 'Admin roles to SuperAdmin'],
        ['from' => [1, '1'], 'to' => 'Writer', 'description' => 'Writer roles to Writer'],
        ['from' => ['admin', 'Admin'], 'to' => 'Admin', 'description' => 'Normalize Admin roles'],
        ['from' => ['writer', 'Writer'], 'to' => 'Writer', 'description' => 'Normalize Writer roles'],
    ];
    
    $totalUpdated = 0;
    
    foreach ($updates as $update) {
        $updated = App\Models\User::whereIn('role', $update['from'])
            ->update(['role' => $update['to']]);
        
        if ($updated > 0) {
            echo "✅ {$update['description']}: {$updated} users updated\n";
            $totalUpdated += $updated;
        }
    }
    
    if ($totalUpdated === 0) {
        echo "ℹ️  Tidak ada user yang perlu diupdate.\n";
    } else {
        echo "\n✅ Total {$totalUpdated} users berhasil diupdate!\n";
    }
    
    echo "\n=== UPDATED USERS AND ROLES ===\n";
    $updatedUsers = App\Models\User::select('id', 'name', 'email', 'role')->get();
    
    foreach($updatedUsers as $user) {
        echo "ID: {$user->id} | Name: {$user->name} | Email: {$user->email} | Role: '{$user->role}'\n";
    }
    
    echo "\n🎉 Role update completed successfully!\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
EOF

# Run the PHP script
echo "🔄 Menjalankan update script..."
php temp_update_roles.php

# Check if script ran successfully
if [ $? -eq 0 ]; then
    echo ""
    echo "✅ Script berhasil dijalankan!"
    
    # Clean up
    rm -f temp_update_roles.php
    
    echo ""
    echo "🔧 Membersihkan cache Laravel..."
    php artisan config:clear > /dev/null 2>&1
    php artisan cache:clear > /dev/null 2>&1
    php artisan route:clear > /dev/null 2>&1
    php artisan view:clear > /dev/null 2>&1
    
    echo "✅ Cache berhasil dibersihkan!"
    echo ""
    echo "🎯 SUMMARY:"
    echo "   • User roles telah diupdate dari numeric ke string"
    echo "   • Role 0 → SuperAdmin"
    echo "   • Role 1 → Writer"  
    echo "   • Cache Laravel telah dibersihkan"
    echo ""
    echo "📝 NEXT STEPS:"
    echo "   1. Login ke admin panel untuk test"
    echo "   2. Check halaman Manage Users"
    echo "   3. Verify semua user roles sudah benar"
    echo ""
    
else
    echo ""
    echo "❌ Script gagal dijalankan!"
    echo "   Periksa error di atas dan coba lagi."
    
    # Clean up on error
    rm -f temp_update_roles.php
    exit 1
fi

echo "==================================="
echo "        UPDATE COMPLETED!          "
echo "==================================="
