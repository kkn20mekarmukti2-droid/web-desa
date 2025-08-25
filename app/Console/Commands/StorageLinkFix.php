<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class StorageLinkFix extends Command
{
    protected $signature = 'storage:link-fix {--force : Force recreation of storage link}';
    protected $description = 'Create storage link for cPanel hosting without symlink function';

    public function handle()
    {
        $this->info('🔗 cPanel Storage Link Fix');
        $this->line('');

        $publicStoragePath = public_path('storage');
        $storagePath = storage_path('app/public');

        // Check if storage/app/public exists
        if (!File::exists($storagePath)) {
            File::makeDirectory($storagePath, 0755, true);
            $this->info("📁 Created storage/app/public directory");
        }

        // Remove existing storage link/directory
        if (File::exists($publicStoragePath)) {
            if ($this->option('force') || $this->confirm('Remove existing public/storage?')) {
                File::deleteDirectory($publicStoragePath);
                $this->info("🗑️  Removed existing public/storage");
            } else {
                $this->warn("Aborted. Use --force to overwrite existing storage link.");
                return;
            }
        }

        // Try to create symbolic link first
        try {
            if (function_exists('symlink') && symlink($storagePath, $publicStoragePath)) {
                $this->info("✅ Symbolic link created successfully!");
                return;
            }
        } catch (\Exception $e) {
            $this->warn("⚠️  Symlink failed: " . $e->getMessage());
        }

        // Fallback: Create directory and copy files
        $this->info("📋 Using copy method as fallback...");
        
        File::makeDirectory($publicStoragePath, 0755, true);
        
        // Copy existing files
        if (File::exists($storagePath) && count(File::allFiles($storagePath)) > 0) {
            File::copyDirectory($storagePath, $publicStoragePath);
            $this->info("📁 Copied existing files to public/storage");
        }

        // Test the setup
        $testFile = $storagePath . '/test.txt';
        $publicTestFile = $publicStoragePath . '/test.txt';
        
        File::put($testFile, 'test');
        
        if (File::exists($publicTestFile)) {
            $this->info("✅ Storage link test: PASSED (using symlink)");
            File::delete([$testFile, $publicTestFile]);
        } else {
            // Manual copy for testing
            File::copy($testFile, $publicTestFile);
            if (File::exists($publicTestFile)) {
                $this->warn("⚠️  Storage link test: Using manual copy method");
                $this->line("💡 You'll need to manually sync files when uploading to storage");
                File::delete([$testFile, $publicTestFile]);
            } else {
                $this->error("❌ Storage setup failed!");
                return 1;
            }
        }

        $this->line('');
        $this->info("🎉 Storage link setup completed!");
        $this->line('');
        $this->comment("💡 For cPanel hosting without symlink support:");
        $this->comment("  - Files uploaded to storage/app/public won't automatically appear in public/storage");
        $this->comment("  - Run this command again after uploading files, or");
        $this->comment("  - Manually copy files from storage/app/public to public/storage");

        return 0;
    }
}
