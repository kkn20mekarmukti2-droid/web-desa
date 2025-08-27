<?php
require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "=== FINAL USER SETUP ===\n";

try {
    // Pastikan hanya 2 user yang ada
    User::truncate(); // Hapus semua user
    
    // User 1: ASFHA NUGRAHA ARIFIN (Admin - role 0)
    $adminUser = User::create([
        'name' => 'ASFHA NUGRAHA ARIFIN',
        'email' => 'asfha.nugraha@webdesa.com',
        'password' => Hash::make('admin123'),
        'role' => 0, // Admin role (sama dengan Rasyid Shiddiq yang kemungkinan admin)
    ]);
    
    // User 2: Mohammad Nabil Abyyu (Writer - role 1)  
    $writerUser = User::create([
        'name' => 'Mohammad Nabil Abyyu',
        'email' => 'nabil.abyyu@webdesa.com',
        'password' => Hash::make('writer123'),
        'role' => 1, // Writer role
    ]);
    
    echo "✅ Successfully created users:\n";
    echo "1. ASFHA NUGRAHA ARIFIN (Admin) - Email: asfha.nugraha@webdesa.com - Password: admin123\n";
    echo "2. Mohammad Nabil Abyyu (Writer) - Email: nabil.abyyu@webdesa.com - Password: writer123\n";
    
    echo "\n=== VERIFICATION ===\n";
    $users = User::all();
    foreach ($users as $user) {
        $roleText = $user->role == 0 ? 'Admin' : 'Writer';
        echo "✓ ID: {$user->id} | Name: {$user->name} | Role: {$roleText}\n";
    }
    
    echo "\nUser management completed successfully!\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
