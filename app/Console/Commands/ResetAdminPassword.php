<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ResetAdminPassword extends Command
{
    protected $signature = 'admin:reset-password {--show-users : Show existing users}';
    protected $description = 'Reset admin password or show existing users';

    public function handle()
    {
        if ($this->option('show-users')) {
            $this->showExistingUsers();
            return;
        }

        $this->info('🔐 Admin Password Reset Tool');
        $this->line('');

        // Show existing users first
        $this->showExistingUsers();
        
        $choice = $this->choice(
            'What would you like to do?',
            [
                'Reset existing admin password',
                'Create new admin user',
                'Show password hints'
            ],
            0
        );

        switch ($choice) {
            case 'Reset existing admin password':
                $this->resetExistingPassword();
                break;
            case 'Create new admin user':
                $this->createNewAdmin();
                break;
            case 'Show password hints':
                $this->showPasswordHints();
                break;
        }
    }

    private function showExistingUsers()
    {
        $users = User::select('id', 'name', 'email', 'created_at')->get();
        
        $this->info('📋 Existing Users:');
        $this->table(
            ['ID', 'Name', 'Email', 'Created At'],
            $users->map(function ($user) {
                return [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->created_at->format('Y-m-d H:i:s')
                ];
            })->toArray()
        );
        $this->line('');
    }

    private function resetExistingPassword()
    {
        $users = User::all();
        
        if ($users->count() === 1) {
            $user = $users->first();
            $this->info("Resetting password for: {$user->name} ({$user->email})");
        } else {
            $userChoices = $users->pluck('email', 'id')->toArray();
            $userId = $this->choice('Select user to reset:', $userChoices);
            $user = User::find($userId);
        }

        $newPassword = $this->secret('Enter new password (or leave empty for auto-generated)');
        
        if (empty($newPassword)) {
            $newPassword = 'admin123'; // Default password
            $this->warn("Using default password: admin123");
        }

        $user->password = Hash::make($newPassword);
        $user->save();

        $this->info('✅ Password reset successfully!');
        $this->line("👤 Username/Email: {$user->email}");
        $this->line("🔑 New Password: {$newPassword}");
        $this->warn('⚠️  Please change this password after login!');
    }

    private function createNewAdmin()
    {
        $name = $this->ask('Admin name', 'Admin Desa');
        $email = $this->ask('Admin email', 'admin@mekarmukti.id');
        $password = $this->secret('Admin password (leave empty for "admin123")');
        
        if (empty($password)) {
            $password = 'admin123';
        }

        // Check if email already exists
        if (User::where('email', $email)->exists()) {
            $this->error('❌ Email already exists!');
            return;
        }

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'email_verified_at' => now(),
        ]);

        $this->info('✅ New admin created successfully!');
        $this->line("👤 Name: {$user->name}");
        $this->line("📧 Email: {$user->email}");
        $this->line("🔑 Password: {$password}");
        $this->warn('⚠️  Please change this password after login!');
    }

    private function showPasswordHints()
    {
        $this->info('🔍 Common Password Patterns for Village Admin:');
        $this->line('• admin123');
        $this->line('• mekarmukti123');
        $this->line('• desa2024');
        $this->line('• admin2024');
        $this->line('• password');
        $this->line('• 123456');
        $this->line('• desamekar');
        $this->line('');
        $this->warn('💡 Try these common passwords, or use reset option above!');
    }
}
