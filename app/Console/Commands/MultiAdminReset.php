<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class MultiAdminReset extends Command
{
    protected $signature = 'admin:multi-reset {--email= : Specific email to reset}';
    protected $description = 'Reset password for multiple admin users in production';

    public function handle()
    {
        $this->info('🔐 Multi-Admin Password Reset for Production');
        $this->line('');

        // Show all users
        $users = User::orderBy('id')->get();
        
        $this->info('📋 All Users in Database:');
        $this->table(
            ['ID', 'Name', 'Email', 'Created At'],
            $users->map(function ($user) {
                return [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->created_at ? $user->created_at->format('Y-m-d H:i:s') : 'N/A'
                ];
            })->toArray()
        );
        
        $this->line('');

        // Check if specific email provided
        if ($this->option('email')) {
            return $this->resetSpecificUser($this->option('email'));
        }

        // Interactive selection
        $choice = $this->choice(
            'What would you like to do?',
            [
                'Reset all admin users to same password',
                'Reset specific user by email',
                'Create standard admin@webdesa.com account',
                'Show suggested login credentials'
            ],
            0
        );

        switch ($choice) {
            case 'Reset all admin users to same password':
                return $this->resetAllAdmins();
            case 'Reset specific user by email':
                return $this->resetSpecificUserInteractive();
            case 'Create standard admin@webdesa.com account':
                return $this->createStandardAdmin();
            case 'Show suggested login credentials':
                return $this->showSuggestedCredentials();
        }
    }

    private function resetAllAdmins()
    {
        $password = $this->secret('Enter password for all admins (leave empty for "admin123")');
        
        if (empty($password)) {
            $password = 'admin123';
            $this->warn("Using default password: admin123");
        }

        $users = User::all();
        $resetCount = 0;

        foreach ($users as $user) {
            $user->password = Hash::make($password);
            $user->save();
            $resetCount++;
            
            $this->info("✅ Reset: {$user->name} ({$user->email})");
        }

        $this->line('');
        $this->info("🎉 Reset {$resetCount} users successfully!");
        $this->line("🔑 Password for all users: {$password}");
        
        $this->line('');
        $this->comment('💡 You can now login with any of these emails:');
        foreach ($users as $user) {
            $this->comment("  - {$user->email}");
        }

        return 0;
    }

    private function resetSpecificUser($email)
    {
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            $this->error("❌ User not found: {$email}");
            return 1;
        }

        $password = $this->secret("Enter new password for {$user->name} (leave empty for \"admin123\")");
        
        if (empty($password)) {
            $password = 'admin123';
        }

        $user->password = Hash::make($password);
        $user->save();

        $this->info("✅ Password reset successfully!");
        $this->line("👤 Name: {$user->name}");
        $this->line("📧 Email: {$user->email}");
        $this->line("🔑 Password: {$password}");

        return 0;
    }

    private function resetSpecificUserInteractive()
    {
        $users = User::all();
        $emailChoices = $users->pluck('email', 'email')->toArray();
        
        $selectedEmail = $this->choice('Select user to reset:', $emailChoices);
        
        return $this->resetSpecificUser($selectedEmail);
    }

    private function createStandardAdmin()
    {
        $email = 'admin@webdesa.com';
        
        if (User::where('email', $email)->exists()) {
            $this->error("❌ User {$email} already exists!");
            
            if ($this->confirm('Reset password for existing admin@webdesa.com?')) {
                return $this->resetSpecificUser($email);
            }
            
            return 1;
        }

        $password = $this->secret('Password for new admin (leave empty for "admin123")');
        
        if (empty($password)) {
            $password = 'admin123';
        }

        $user = User::create([
            'name' => 'Admin Desa',
            'email' => $email,
            'password' => Hash::make($password),
            'email_verified_at' => now(),
        ]);

        $this->info("✅ Created new admin successfully!");
        $this->line("👤 Name: {$user->name}");
        $this->line("📧 Email: {$user->email}");
        $this->line("🔑 Password: {$password}");

        return 0;
    }

    private function showSuggestedCredentials()
    {
        $users = User::orderBy('id')->get();
        
        $this->info('🔑 Suggested Login Credentials:');
        $this->line('');
        
        $this->comment('💡 Primary Admin (ID: 1):');
        $primary = $users->first();
        $this->line("  Email: {$primary->email}");
        $this->line("  Password: admin123 (if reset with our scripts)");
        
        $this->line('');
        $this->comment('💡 All Available Admin Accounts:');
        foreach ($users as $user) {
            $this->line("  - {$user->name} ({$user->email})");
        }
        
        $this->line('');
        $this->warn('⚠️  If you can\'t login with any account:');
        $this->comment('  1. Run: php artisan admin:multi-reset --email=rasidokai@gmail.com');
        $this->comment('  2. Or reset all: php artisan admin:multi-reset');
        $this->comment('  3. Or create new: php artisan admin:multi-reset (option 3)');

        return 0;
    }
}
