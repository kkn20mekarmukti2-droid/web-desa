<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== Current Users and Roles ===\n";
$users = App\Models\User::select('id', 'name', 'email', 'role')->get();

foreach($users as $user) {
    echo "ID: {$user->id}, Name: {$user->name}, Email: {$user->email}, Role: {$user->role}\n";
}

echo "\n=== Updating Roles to SuperAdmin ===\n";

// Update users with role 0 or 1 to 'SuperAdmin'  
$updated = App\Models\User::whereIn('role', [0, 1])
    ->update(['role' => 'SuperAdmin']);

echo "Updated {$updated} users to SuperAdmin role\n";

echo "\n=== Updated Users and Roles ===\n";
$users = App\Models\User::select('id', 'name', 'email', 'role')->get();

foreach($users as $user) {
    echo "ID: {$user->id}, Name: {$user->name}, Email: {$user->email}, Role: {$user->role}\n";
}

echo "\nRole update completed successfully!\n";

?>
