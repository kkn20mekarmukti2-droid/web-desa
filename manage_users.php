<?php
require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "=== USER MANAGEMENT SCRIPT ===\n";

try {
    // Cek user yang ada
    echo "Current users:\n";
    $users = User::all();
    foreach ($users as $user) {
        echo "- ID: {$user->id}, Name: {$user->name}, Email: {$user->email}, Role: {$user->role}\n";
    }
    
    echo "\n=== CLEANING UP USERS ===\n";
    
    // Hapus semua user kecuali yang diminta (jika ada)
    $keepUsers = ['ASFHA NUGRAHA ARIFIN', 'Mohammad Nabil Abyyu', 'Rasyid Shiddiq'];
    
    $deletedCount = User::whereNotIn('name', $keepUsers)->delete();
    echo "Deleted {$deletedCount} users\n";
    
    // Cek apakah user yang diminta ada
    $asfhaUser = User::where('name', 'ASFHA NUGRAHA ARIFIN')->first();
    $nabilUser = User::where('name', 'Mohammad Nabil Abyyu')->first();
    $rasyidUser = User::where('name', 'Rasyid Shiddiq')->first();
    
    // Cek role dari Rasyid jika ada
    $rasyidRole = null;
    if ($rasyidUser) {
        $rasyidRole = $rasyidUser->role;
        echo "Rasyid Shiddiq role: {$rasyidRole}\n";
    }
    
    // Buat atau update user ASFHA NUGRAHA ARIFIN
    if (!$asfhaUser) {
        $asfhaUser = User::create([
            'name' => 'ASFHA NUGRAHA ARIFIN',
            'email' => 'asfha.nugraha@webdesa.com',
            'password' => Hash::make('admin123'),
            'role' => $rasyidRole ?? 0, // Role yang sama dengan Rasyid atau default 0 (admin)
        ]);
        echo "Created user: ASFHA NUGRAHA ARIFIN with role {$asfhaUser->role}\n";
    } else {
        // Update role agar sama dengan Rasyid
        if ($rasyidRole !== null) {
            $asfhaUser->role = $rasyidRole;
            $asfhaUser->save();
            echo "Updated ASFHA NUGRAHA ARIFIN role to {$rasyidRole}\n";
        }
    }
    
    // Buat user Mohammad Nabil Abyyu jika belum ada
    if (!$nabilUser) {
        $nabilUser = User::create([
            'name' => 'Mohammad Nabil Abyyu',
            'email' => 'nabil.abyyu@webdesa.com',
            'password' => Hash::make('writer123'),
            'role' => 1, // Role writer
        ]);
        echo "Created user: Mohammad Nabil Abyyu with role {$nabilUser->role}\n";
    }
    
    echo "\n=== FINAL USER LIST ===\n";
    $finalUsers = User::all();
    foreach ($finalUsers as $user) {
        $roleText = '';
        switch($user->role) {
            case 0:
                $roleText = 'Admin';
                break;
            case 1:
                $roleText = 'Writer';
                break;
            default:
                $roleText = 'Unknown';
        }
        echo "- ID: {$user->id}, Name: {$user->name}, Email: {$user->email}, Role: {$user->role} ({$roleText})\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
