<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\artikelModel;

class CleanupUsers extends Command
{
    protected $signature = 'admin:cleanup-users {--dry-run : Show what would be deleted without actually deleting}';
    protected $description = 'Cleanup duplicate admin accounts safely';

    public function handle()
    {
        $this->info('🧹 Admin Users Cleanup Tool');
        $this->line('');

        // Show all users
        $users = User::orderBy('id')->get();
        
        $this->info('📋 Current Users in Database:');
        $this->table(
            ['ID', 'Name', 'Email', 'Created At', 'Articles Count'],
            $users->map(function ($user) {
                $articleCount = artikelModel::where('user_id', $user->id)->count();
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
        $byName = $users->groupBy('name');
        $duplicateNames = $byName->filter(fn($group) => $group->count() > 1);
        
        if ($duplicateNames->isEmpty()) {
            $this->comment('✅ No duplicate names found');
        } else {
            foreach ($duplicateNames as $name => $group) {
                $this->warn("⚠️  Duplicate name '{$name}': {$group->count()} accounts");
                foreach ($group as $user) {
                    $articleCount = artikelModel::where('user_id', $user->id)->count();
                    $this->line("   - ID:{$user->id} | {$user->email} | Articles:{$articleCount}");
                }
            }
        }

        $this->line('');
    }

    private function showRecommendations($users)
    {
        $this->info('💡 Cleanup Recommendations:');
        
        // Rasyid Shiddiq duplicates
        $rasyidAccounts = $users->filter(fn($u) => stripos($u->name, 'rasyid') !== false);
        
        if ($rasyidAccounts->count() > 1) {
            $this->comment('👤 Rasyid Shiddiq Accounts:');
            foreach ($rasyidAccounts as $user) {
                $articleCount = artikelModel::where('user_id', $user->id)->count();
                $isPrimary = $user->id == 1 ? ' (PRIMARY)' : '';
                $hasArticles = $articleCount > 0 ? ' (HAS ARTICLES!)' : '';
                
                $this->line("   - ID:{$user->id} | {$user->email}{$isPrimary}{$hasArticles}");
            }
            
            $this->line('');
            $this->comment('🎯 Recommendation for Rasyid accounts:');
            
            $primary = $rasyidAccounts->firstWhere('id', 1);
            $secondary = $rasyidAccounts->where('id', '!=', 1)->first();
            
            if ($primary && $secondary) {
                $primaryArticles = artikelModel::where('user_id', 1)->count();
                $secondaryArticles = artikelModel::where('user_id', $secondary->id)->count();
                
                if ($primaryArticles > 0 && $secondaryArticles == 0) {
                    $this->comment("   ✅ KEEP: {$primary->email} (ID:1, has {$primaryArticles} articles)");
                    $this->comment("   ❌ DELETE: {$secondary->email} (ID:{$secondary->id}, no articles)");
                } elseif ($secondaryArticles > 0 && $primaryArticles == 0) {
                    $this->comment("   ⚠️  MIGRATE articles from ID:{$secondary->id} to ID:1 first");
                    $this->comment("   ✅ KEEP: {$primary->email} (ID:1, primary admin)");
                    $this->comment("   ❌ DELETE: {$secondary->email} (after migration)");
                } else {
                    $this->comment("   ✅ KEEP: {$primary->email} (ID:1, primary admin)");
                    $this->comment("   ⚠️  REVIEW: {$secondary->email} (has {$secondaryArticles} articles)");
                }
            }
        }

        $this->line('');
        $this->comment('🛡️  Safety Rules:');
        $this->comment('   - Never delete users with articles');
        $this->comment('   - Always keep primary admin (ID:1)');
        $this->comment('   - Migrate articles before deletion');
        $this->comment('   - Backup database first');

        return 0;
    }

    private function interactiveCleanup($users)
    {
        $this->warn('⚠️  INTERACTIVE CLEANUP MODE');
        $this->comment('This will permanently delete users!');
        $this->line('');

        if (!$this->confirm('Do you want to proceed with cleanup?')) {
            $this->info('Cancelled by user.');
            return 0;
        }

        // Show cleanup options
        $action = $this->choice(
            'What cleanup action do you want to perform?',
            [
                'Remove specific user by ID',
                'Auto-cleanup safe duplicates (no articles)',
                'Migrate articles and cleanup',
                'Create standard admin@webdesa.com and cleanup',
                'Cancel'
            ],
            4
        );

        switch ($action) {
            case 'Remove specific user by ID':
                return $this->removeSpecificUser($users);
            case 'Auto-cleanup safe duplicates (no articles)':
                return $this->autoCleanupSafe($users);
            case 'Migrate articles and cleanup':
                return $this->migrateAndCleanup($users);
            case 'Create standard admin@webdesa.com and cleanup':
                return $this->createStandardAndCleanup($users);
            case 'Cancel':
                $this->info('Cleanup cancelled.');
                return 0;
        }

        return 0;
    }

    private function removeSpecificUser($users)
    {
        $this->table(
            ['ID', 'Name', 'Email', 'Articles'],
            $users->map(function ($user) {
                $articleCount = artikelModel::where('user_id', $user->id)->count();
                return [$user->id, $user->name, $user->email, $articleCount];
            })->toArray()
        );

        $userId = $this->ask('Enter user ID to delete');
        $user = $users->firstWhere('id', $userId);

        if (!$user) {
            $this->error("❌ User ID {$userId} not found!");
            return 1;
        }

        if ($user->id == 1) {
            $this->error("❌ Cannot delete primary admin (ID:1)!");
            return 1;
        }

        $articleCount = artikelModel::where('user_id', $user->id)->count();
        if ($articleCount > 0) {
            $this->error("❌ Cannot delete user with {$articleCount} articles!");
            $this->comment('💡 Use "Migrate articles and cleanup" option instead');
            return 1;
        }

        if ($this->confirm("Delete user: {$user->name} ({$user->email})?")) {
            $user->delete();
            $this->info("✅ User deleted successfully!");
        }

        return 0;
    }

    private function autoCleanupSafe($users)
    {
        $this->info('🔍 Finding safe duplicates to remove...');
        
        $safeToDelete = $users->filter(function ($user) {
            // Don't delete primary admin
            if ($user->id == 1) return false;
            
            // Don't delete users with articles
            $articleCount = artikelModel::where('user_id', $user->id)->count();
            if ($articleCount > 0) return false;
            
            // Find if this user has a duplicate name
            $duplicates = User::where('name', $user->name)->where('id', '!=', $user->id)->count();
            
            return $duplicates > 0;
        });

        if ($safeToDelete->isEmpty()) {
            $this->info('✅ No safe duplicates found to delete');
            return 0;
        }

        $this->comment('Found safe duplicates:');
        foreach ($safeToDelete as $user) {
            $this->line("   - {$user->name} ({$user->email}) - ID:{$user->id}");
        }

        if ($this->confirm('Delete these safe duplicate accounts?')) {
            foreach ($safeToDelete as $user) {
                $user->delete();
                $this->info("✅ Deleted: {$user->email}");
            }
            $this->info('🎉 Safe cleanup completed!');
        }

        return 0;
    }

    private function migrateAndCleanup($users)
    {
        $this->comment('🔄 This feature will migrate articles from one user to another, then delete the source user');
        
        $fromId = $this->ask('Enter source user ID (articles will be moved FROM this user)');
        $toId = $this->ask('Enter target user ID (articles will be moved TO this user)', '1');

        $fromUser = $users->firstWhere('id', $fromId);
        $toUser = $users->firstWhere('id', $toId);

        if (!$fromUser || !$toUser) {
            $this->error('❌ One or both users not found!');
            return 1;
        }

        $articleCount = artikelModel::where('user_id', $fromId)->count();
        
        $this->info("Migration preview:");
        $this->line("FROM: {$fromUser->name} ({$fromUser->email}) - {$articleCount} articles");
        $this->line("TO: {$toUser->name} ({$toUser->email})");

        if ($this->confirm('Proceed with migration and deletion?')) {
            // Migrate articles
            artikelModel::where('user_id', $fromId)->update(['user_id' => $toId]);
            
            // Delete user
            $fromUser->delete();
            
            $this->info("✅ Migrated {$articleCount} articles and deleted user!");
        }

        return 0;
    }

    private function createStandardAndCleanup($users)
    {
        // Create admin@webdesa.com if doesn't exist
        $standardAdmin = User::where('email', 'admin@webdesa.com')->first();
        
        if (!$standardAdmin) {
            $standardAdmin = User::create([
                'name' => 'Admin Desa Mekarmukti',
                'email' => 'admin@webdesa.com',
                'password' => bcrypt('admin123'),
                'email_verified_at' => now()
            ]);
            $this->info("✅ Created admin@webdesa.com account");
        }

        // Migrate all articles to standard admin
        $articleCount = artikelModel::where('user_id', '!=', $standardAdmin->id)->count();
        
        if ($articleCount > 0 && $this->confirm("Migrate {$articleCount} articles to admin@webdesa.com?")) {
            artikelModel::where('user_id', '!=', $standardAdmin->id)->update(['user_id' => $standardAdmin->id]);
            $this->info("✅ Migrated {$articleCount} articles");
        }

        // Delete other users
        $toDelete = $users->where('id', '!=', $standardAdmin->id);
        
        if ($this->confirm("Delete {$toDelete->count()} other admin accounts?")) {
            foreach ($toDelete as $user) {
                $user->delete();
                $this->info("✅ Deleted: {$user->email}");
            }
        }

        $this->info('🎉 Standardization completed!');
        $this->comment('New standard admin: admin@webdesa.com / admin123');

        return 0;
    }
}
