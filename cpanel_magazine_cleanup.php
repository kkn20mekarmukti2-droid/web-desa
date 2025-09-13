<?php
/**
 * CPANEL MAGAZINE CLEANUP SCRIPT
 * Web Desa Mekarmukti - Magazine System Removal
 * 
 * This script removes all magazine-related files and database entries
 * Safe to run in production environment (cPanel)
 * 
 * Author: KKN Development Team 2024-2025
 */

echo "=== CPANEL MAGAZINE CLEANUP SCRIPT ===\n";
echo "Web Desa Mekarmukti - Magazine System Removal\n";
echo "Removing all magazine-related components...\n\n";

$errors = [];
$deleted_files = 0;
$deleted_dirs = 0;

// Files to delete
$files_to_delete = [
    // Models
    'app/Models/Majalah.php',
    'app/Models/MajalahPage.php',
    
    // Controller
    'app/Http/Controllers/MajalahController.php',
    
    // Migrations
    'database/migrations/2025_09_03_231712_create_majalah_table.php',
    'database/migrations/2025_09_03_231949_create_majalah_pages_table.php',
    
    // Views
    'resources/views/public/majalah.blade.php',
    'resources/views/index.blade.php',
    
    // Debugging files (if any remaining)
    'debug_majalah_data.php',
    'fix_cover_paths.php',
    'create_additional_magazines.php',
    'add_sample_majalah.php',
    'check_majalah_simple.php',
    'check_majalah_structure.php',
    'copy_majalah_to_public.php',
    'create_sample_majalah.php',
    'debug-majalah-images.php',
    'debug_majalah_images.php',
    'deploy-majalah.php',
    'fix-magazine-data.php',
    'setup_motekart_magazine.php',
    'update_majalah_paths.php',
    'MAJALAH_DEPLOYMENT_GUIDE.md',
    'majalah-tables-deployment.sql',
    
    // Shell scripts
    'cpanel-deploy-majalah.sh'
];

// Directories to delete
$dirs_to_delete = [
    'resources/views/admin/majalah',
    'public/img/majalah',
    'public/majalah'
];

echo "🗑️  Removing individual files...\n";
foreach ($files_to_delete as $file) {
    if (file_exists($file)) {
        if (unlink($file)) {
            echo "   ✅ Deleted: $file\n";
            $deleted_files++;
        } else {
            echo "   ❌ Failed to delete: $file\n";
            $errors[] = "Failed to delete file: $file";
        }
    } else {
        echo "   ℹ️  Not found: $file\n";
    }
}

echo "\n📁 Removing directories...\n";
foreach ($dirs_to_delete as $dir) {
    if (is_dir($dir)) {
        if (deleteDirectory($dir)) {
            echo "   ✅ Deleted directory: $dir\n";
            $deleted_dirs++;
        } else {
            echo "   ❌ Failed to delete directory: $dir\n";
            $errors[] = "Failed to delete directory: $dir";
        }
    } else {
        echo "   ℹ️  Directory not found: $dir\n";
    }
}

echo "\n🗄️  Cleaning database tables...\n";
try {
    // Connect to SQLite database
    $db_path = 'database/database.sqlite';
    if (file_exists($db_path)) {
        $pdo = new PDO("sqlite:$db_path");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Drop magazine tables if they exist
        $tables_to_drop = ['majalah', 'majalah_pages'];
        
        foreach ($tables_to_drop as $table) {
            try {
                $pdo->exec("DROP TABLE IF EXISTS $table");
                echo "   ✅ Dropped table: $table\n";
            } catch (PDOException $e) {
                echo "   ℹ️  Table $table not found or already dropped\n";
            }
        }
        
        // Remove magazine entries from migrations table
        try {
            $stmt = $pdo->prepare("DELETE FROM migrations WHERE migration LIKE '%majalah%'");
            $stmt->execute();
            echo "   ✅ Cleaned migration records\n";
        } catch (PDOException $e) {
            echo "   ℹ️  Migration records already clean\n";
        }
        
    } else {
        echo "   ℹ️  Database file not found\n";
    }
} catch (Exception $e) {
    echo "   ❌ Database cleanup error: " . $e->getMessage() . "\n";
    $errors[] = "Database cleanup error: " . $e->getMessage();
}

echo "\n🧹 Clearing Laravel caches...\n";
$cache_commands = [
    'php artisan config:clear' => 'Configuration cache',
    'php artisan route:clear' => 'Route cache',
    'php artisan view:clear' => 'View cache',
    'php artisan cache:clear' => 'Application cache'
];

foreach ($cache_commands as $command => $description) {
    $output = shell_exec($command . ' 2>&1');
    if (strpos($output, 'cleared') !== false || empty(trim($output))) {
        echo "   ✅ Cleared: $description\n";
    } else {
        echo "   ⚠️  Warning: $description - $output\n";
    }
}

echo "\n=== CLEANUP SUMMARY ===\n";
echo "✅ Files deleted: $deleted_files\n";
echo "✅ Directories deleted: $deleted_dirs\n";

if (!empty($errors)) {
    echo "\n⚠️  WARNINGS/ERRORS:\n";
    foreach ($errors as $error) {
        echo "   - $error\n";
    }
}

echo "\n🎉 Magazine system cleanup completed!\n";
echo "💡 The website should now function without magazine components\n";
echo "🔧 If you encounter any issues, check the Laravel logs\n\n";

echo "📝 NEXT STEPS:\n";
echo "1. Test website functionality\n";
echo "2. Verify admin panel works correctly\n";
echo "3. Check that all menus are working\n";
echo "4. Remove this cleanup script: " . __FILE__ . "\n\n";

/**
 * Recursive directory deletion function
 */
function deleteDirectory($dir) {
    if (!is_dir($dir)) {
        return false;
    }
    
    $files = array_diff(scandir($dir), array('.', '..'));
    
    foreach ($files as $file) {
        $path = $dir . DIRECTORY_SEPARATOR . $file;
        if (is_dir($path)) {
            deleteDirectory($path);
        } else {
            unlink($path);
        }
    }
    
    return rmdir($dir);
}

// Self-delete option
echo "⏰ This cleanup script will self-delete in 10 seconds...\n";
echo "   Press Ctrl+C to cancel self-deletion\n";

for ($i = 10; $i > 0; $i--) {
    echo "   Deleting in $i seconds...\r";
    sleep(1);
}

echo "\n";
if (unlink(__FILE__)) {
    echo "✅ Cleanup script successfully deleted itself.\n";
} else {
    echo "❌ Failed to delete cleanup script. Please remove manually: " . __FILE__ . "\n";
}

echo "\n🚀 Magazine cleanup process completed successfully!\n";
?>
