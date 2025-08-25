<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\artikelModel;

class CleanupUsersFixed extends Command
{
    protected $signature = 'admin:cleanup-users-fixed {--dry-run : Show what would be deleted without actually deleting}';
    protected $description = 'Cleanup duplicate admin accounts safely (FIXED VERSION)';

    public function handle()
    {
        $this->info('🧹 Admin Users Cleanup Tool (FIXED)');
        $this->line('');

        // Show all users
        $users = User::orderBy('id')->get();
        
        $this->info('📋 Current Users in Database:');
        $this->table(
            ['ID', 'Name', 'Email', 'Created At', 'Articles Count'],
            $users->map(function ($user) {
                $articleCount = artikelModel::where('created_by', $user->id)->count();
                return [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->created_at ? $user->created_at->format('Y-m-d H:i:s') : 'N/A',
                    $articleCount
                ];
            })->toArray()
        );
        
        $this->line('');

        // Analyze duplicates
        $this->analyzeDuplicates($users);

        if ($this->option('dry-run')) {
            $this->warn('🔍 DRY RUN MODE - No changes will be made');
            return $this->showRecommendations($users);
        }

        // Interactive cleanup
        return $this->interactiveCleanup($users);
    }

    private function analyzeDuplicates($users)
    {
        $this->info('🔍 Duplicate Analysis:');
        
        // Group by name
        $nameGroups = $users->groupBy('name');
        $duplicateNames = $nameGroups->filter(function($group) {
            return $group->count() > 1;
        });
        
        if ($duplicateNames->isEmpty()) {
            $this->line('   ✅ No duplicate names found');
        } else {
            foreach ($duplicateNames as $name => $duplicates) {
                $this->warn("   ⚠️  Duplicate name: {$name} ({$duplicates->count()} users)");
                foreach ($duplicates as $user) {
                    $articleCount = artikelModel::where('created_by', $user->id)->count();
                    $this->line("      - ID {$user->id}: {$user->email} ({$articleCount} articles)");
                }
            }
        }
        
        // Group by email
        $emailGroups = $users->groupBy('email');
        $duplicateEmails = $emailGroups->filter(function($group) {
            return $group->count() > 1;
        });
        
        if ($duplicateEmails->isEmpty()) {
            $this->line('   ✅ No duplicate emails found');
        } else {
            foreach ($duplicateEmails as $email => $duplicates) {
                $this->warn("   ⚠️  Duplicate email: {$email} ({$duplicates->count()} users)");
            }
        }
        
        $this->line('');
    }

    private function showRecommendations($users)
    {
        $this->info('💡 CLEANUP RECOMMENDATIONS:');
        
        // Check for obvious duplicates
        $primary = $users->first();
        $secondary = $users->skip(1)->first();
        
        if ($primary && $secondary) {
            if ($primary->name === $secondary->name) {
                $primaryArticles = artikelModel::where('created_by', $primary->id)->count();
                $secondaryArticles = artikelModel::where('created_by', $secondary->id)->count();
                
                $this->line("1. 🎯 MERGE DUPLICATES:");
                $this->line("   - Keep: {$primary->email} ({$primaryArticles} articles)");
                $this->line("   - Merge from: {$secondary->email} ({$secondaryArticles} articles)");
                $this->line("   - Safe to delete: " . ($secondaryArticles == 0 ? 'YES' : 'NO'));
            }
        }
        
        $this->line("2. 🏗️  CREATE STANDARD ADMIN:");
        $this->line("   - Create admin@webdesa.com");
        $this->line("   - Migrate all articles");
        $this->line("   - Delete all current users");
        $this->line("   - Result: 1 clean admin account");
        
        $this->line('');
        return 0;
    }

    private function interactiveCleanup($users)
    {
        $this->info('🛠️  Interactive Cleanup Options:');
        $this->line('');
        
        $choice = $this->choice(
            'What would you like to do?',
            [
                'Show users only',
                'Remove safe duplicates',
                'Merge specific users', 
                'Create standard admin account',
                'Exit without changes'
            ],
            4
        );

        switch ($choice) {
            case 'Show users only':
                return $this->showUsersOnly($users);
                
            case 'Remove safe duplicates':
                return $this->removeSafeDuplicates($users);
                
            case 'Merge specific users':
                return $this->mergeUsers($users);
                
            case 'Create standard admin account':
                return $this->createStandardAdmin($users);
                
            default:
                $this->info('👋 Exiting without changes');
                return 0;
        }
    }

    private function showUsersOnly($users)
    {
        foreach ($users as $user) {
            $articleCount = artikelModel::where('created_by', $user->id)->count();
            $this->line("ID {$user->id}: {$user->name} ({$user->email}) - {$articleCount} articles");
        }
        return 0;
    }

    private function removeSafeDuplicates($users)
    {
        $this->info('🧹 Removing Safe Duplicates...');
        
        $deleted = 0;
        foreach ($users as $user) {
            $articleCount = artikelModel::where('created_by', $user->id)->count();
            
            // Only delete if no articles and duplicate name exists
            if ($articleCount == 0) {
                $duplicates = $users->where('name', $user->name)->where('id', '!=', $user->id);
                if ($duplicates->count() > 0) {
                    $this->warn("Deleting safe duplicate: {$user->email}");
                    $user->delete();
                    $deleted++;
                }
            }
        }
        
        $this->info("✅ Deleted {$deleted} safe duplicate(s)");
        return 0;
    }

    private function mergeUsers($users)
    {
        $this->info('👥 User Merge Tool');
        
        // Show users with IDs
        foreach ($users as $user) {
            $articleCount = artikelModel::where('created_by', $user->id)->count();
            $this->line("ID {$user->id}: {$user->name} ({$user->email}) - {$articleCount} articles");
        }
        
        $fromId = $this->ask('Enter ID of user to delete (FROM)');
        $toId = $this->ask('Enter ID of user to keep (TO)');
        
        $fromUser = $users->firstWhere('id', $fromId);
        $toUser = $users->firstWhere('id', $toId);
        
        if (!$fromUser || !$toUser) {
            $this->error('❌ Invalid user IDs');
            return 1;
        }
        
        $this->migrateArticles($fromId, $toId);
        
        $fromUser->delete();
        $this->info("✅ Merged {$fromUser->email} into {$toUser->email}");
        
        return 0;
    }

    private function migrateArticles($fromId, $toId)
    {
        $articleCount = artikelModel::where('created_by', $fromId)->count();
        
        if ($articleCount > 0) {
            $this->info("📄 Migrating {$articleCount} articles...");
            
            // Migrate created_by
            artikelModel::where('created_by', $fromId)->update(['created_by' => $toId]);
            
            // Migrate updated_by
            artikelModel::where('updated_by', $fromId)->update(['updated_by' => $toId]);
            
            $this->info("✅ Articles migrated successfully");
        } else {
            $this->info("📄 No articles to migrate");
        }
    }

    private function createStandardAdmin($users)
    {
        $this->warn('🎯 Creating Standard Admin Account');
        $this->line('This will:');
        $this->line('- Create admin@webdesa.com with password: admin123');
        $this->line('- Migrate ALL articles to this account'); 
        $this->line('- Delete ALL existing users');
        $this->line('');
        
        if (!$this->confirm('Are you sure you want to proceed?')) {
            $this->info('👋 Operation cancelled');
            return 0;
        }
        
        // Create standard admin
        $standardAdmin = User::firstOrCreate(
            ['email' => 'admin@webdesa.com'],
            [
                'name' => 'Admin Desa Mekarmukti',
                'password' => bcrypt('admin123'),
                'email_verified_at' => now()
            ]
        );
        
        $this->info("✅ Standard admin created: {$standardAdmin->email}");
        
        // Migrate articles
        $articleCount = artikelModel::where('created_by', '!=', $standardAdmin->id)->count();
        if ($articleCount > 0) {
            artikelModel::where('created_by', '!=', $standardAdmin->id)->update(['created_by' => $standardAdmin->id]);
            artikelModel::where('updated_by', '!=', $standardAdmin->id)->update(['updated_by' => $standardAdmin->id]);
            $this->info("✅ Migrated {$articleCount} articles");
        }
        
        // Delete other users
        $otherUsers = $users->where('id', '!=', $standardAdmin->id);
        foreach ($otherUsers as $user) {
            $this->line("Deleting: {$user->email}");
            $user->delete();
        }
        
        $this->info('');
        $this->info('🎉 STANDARD ADMIN SETUP COMPLETE!');
        $this->info('==================================');
        $this->info('Login Credentials:');
        $this->info('Email: admin@webdesa.com');
        $this->info('Password: admin123');
        
        return 0;
    }
}
