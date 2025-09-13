<?php
/**
 * CLEANUP SCRIPT - Pembersihan File Debugging dan Dokumentasi
 * Script ini akan menghapus semua file debugging dan dokumentasi yang tidak diperlukan
 * Jalankan sekali saja di cPanel atau server production
 */

echo "=== CLEANUP SCRIPT - WEB DESA ===\n";
echo "Memulai pembersihan file debugging dan dokumentasi...\n\n";

// Daftar file yang akan dihapus
$filesToDelete = [
    // File debugging PHP
    'add_hero_images_simple.php',
    'add_hero_images.sql',
    'add_sample_hero_images.php',
    'add_sample_majalah.php',
    'add_sample_umkm.php',
    'add_struktur_pemerintahan.php',
    'add_umkm_images.php',
    'add-sample-gallery.php',
    'api-test-direct.php',
    'app-blade-backup-with-slide-drawer.php',
    'apply-role-middleware.php',
    'check_all_apbdes.php',
    'check_data_table.php',
    'check_database.php',
    'check_datades.php',
    'check_gallery_structure.php',
    'check_majalah_simple.php',
    'check_majalah_structure.php',
    'check_role_column.php',
    'check_sqlite_data.php',
    'check_statistik_data.php',
    'check_table_structure.php',
    'check_tables.php',
    'check_user_roles.php',
    'check_users_detail.php',
    'check_users.php',
    'check-all-tables.php',
    'check-apbdes-data.php',
    'check-db-content.php',
    'check-gallery-data.php',
    'check-visitor-tracking.php',
    'clear_legacy_data.php',
    'clear_statistik.php',
    'compare-images.php',
    'copy_majalah_to_public.php',
    'copy-apbdes-to-images.php',
    'correct_articles.php',
    'create_sample_majalah.php',
    'debug-majalah-images.php',
    'debug_majalah_images.php',
    'debug_majalah_data.php',
    'fix_cover_paths.php',
    'create_additional_magazines.php',
    'setup_motekart_magazine.php',
    'fix-magazine-data.php',
    'update_majalah_paths.php',
    
    // File deployment dan setup
    'deploy-majalah.php',
    'cpanel-data-statistik-deploy.php',
    'cpanel-debug-charts.php',
    'cpanel-deploy.php',
    'cpanel-update-articles.php',
    'cpanel-update-user-roles.php',
    'cpanel-user-cleanup-production.php',
    
    // File SQL manual
    'apbdes-manual-install.sql',
    'majalah-tables-deployment.sql',
    'cpanel-produk-umkm-table.sql',
    'cpanel-struktur-pemerintahan-table.sql',
    
    // File shell scripts
    'clear-all-cache.sh',
    'cpanel-database-cleanup.sh',
    'cpanel-debug.sh',
    'cpanel-deploy-majalah.sh',
    'cpanel-deploy.sh',
    'cpanel-deployment-commands.sh',
    'cpanel-deployment-instructions.sh',
    'cpanel-file-cleanup.sh',
    'cpanel-pre-check.sh',
    'cpanel-update-user-roles.sh',
];

// Daftar file dokumentasi MD yang akan dihapus
$mdFilesToDelete = [
    'ADMIN_MODERN_DOCUMENTATION.md',
    'ADMIN_PASSWORD_RESET.md',
    'ADMIN_UI_MODERNIZATION_DOCS.md',
    'APBDES_CPANEL_DEPLOYMENT.md',
    'APBDES_FINAL_FIX.md',
    'APBDES_IMAGE_DISPLAY_FIX.md',
    'APBDES_PRODUCTION_TROUBLESHOOTING.md',
    'APBDES_SIMPLE_FIX.md',
    'ARTICLE_MANAGEMENT_ENHANCEMENT.md',
    'BREAKTHROUGH_SOLUTION.md',
    'CLEAN_REBUILD_DOCUMENTATION.md',
    'CLEANUP_SUMMARY.md',
    'CPANEL_APBDES_IMAGE_FIX_DEPLOYMENT.md',
    'CPANEL_DATA_STATISTIK_DEPLOYMENT.md',
    'CPANEL_DEPLOYMENT_GUIDE.md',
    'CPANEL_DEPLOYMENT_TROUBLESHOOTING.md',
    'CPANEL_IMAGE_FIX_FINAL.md',
    'CPANEL_PRODUK_UMKM_DEPLOYMENT.md',
    'CPANEL_STATISTIK_DEPLOYMENT.md',
    'CPANEL_USER_CLEANUP_GUIDE.md',
    'MAJALAH_DEPLOYMENT_GUIDE.md',
];

// Daftar direktori yang akan dihapus (jika kosong)
$directoriesToCheck = [
    'temp/',
    'debug/',
    'backup/',
    'old/',
];

$deletedFiles = 0;
$deletedDocs = 0;
$errors = [];

// Hapus file debugging PHP
echo "🗑️  Menghapus file debugging PHP...\n";
foreach($filesToDelete as $file) {
    if (file_exists($file)) {
        if (unlink($file)) {
            echo "   ✅ Dihapus: {$file}\n";
            $deletedFiles++;
        } else {
            echo "   ❌ Gagal: {$file}\n";
            $errors[] = $file;
        }
    }
}

// Hapus file dokumentasi MD
echo "\n📄 Menghapus file dokumentasi MD...\n";
foreach($mdFilesToDelete as $file) {
    if (file_exists($file)) {
        if (unlink($file)) {
            echo "   ✅ Dihapus: {$file}\n";
            $deletedDocs++;
        } else {
            echo "   ❌ Gagal: {$file}\n";
            $errors[] = $file;
        }
    }
}

// Cek dan hapus direktori kosong
echo "\n📁 Memeriksa direktori kosong...\n";
foreach($directoriesToCheck as $dir) {
    if (is_dir($dir)) {
        $files = scandir($dir);
        $files = array_diff($files, array('.', '..', '.gitkeep'));
        
        if (empty($files)) {
            if (rmdir($dir)) {
                echo "   ✅ Direktori kosong dihapus: {$dir}\n";
            } else {
                echo "   ❌ Gagal hapus direktori: {$dir}\n";
            }
        } else {
            echo "   ℹ️  Direktori tidak kosong: {$dir} (" . count($files) . " file)\n";
        }
    }
}

// Bersihkan cache Laravel jika artisan tersedia
echo "\n🧹 Membersihkan cache Laravel...\n";
if (file_exists('artisan')) {
    $commands = [
        'php artisan config:clear',
        'php artisan route:clear', 
        'php artisan view:clear',
        'php artisan cache:clear'
    ];
    
    foreach($commands as $command) {
        echo "   Menjalankan: {$command}\n";
        exec($command . ' 2>&1', $output, $return_var);
        if ($return_var === 0) {
            echo "   ✅ Berhasil\n";
        } else {
            echo "   ⚠️  Warning: " . implode(' ', $output) . "\n";
        }
    }
} else {
    echo "   ℹ️  File artisan tidak ditemukan, skip pembersihan cache\n";
}

// Summary
echo "\n=== RINGKASAN PEMBERSIHAN ===\n";
echo "✅ File debugging dihapus: {$deletedFiles}\n";
echo "✅ File dokumentasi dihapus: {$deletedDocs}\n";

if (!empty($errors)) {
    echo "❌ File yang gagal dihapus: " . count($errors) . "\n";
    foreach($errors as $error) {
        echo "   - {$error}\n";
    }
}

echo "\n🎉 Pembersihan selesai!\n";
echo "💡 Untuk dokumentasi lengkap, lihat file: DOKUMENTASI_LENGKAP.md\n";

// Hapus file cleanup ini sendiri setelah 5 detik
echo "\n⏰ File cleanup ini akan menghapus dirinya sendiri dalam 5 detik...\n";
echo "   (Tekan Ctrl+C untuk membatalkan)\n";

for($i = 5; $i > 0; $i--) {
    echo "   {$i}...\n";
    sleep(1);
}

if (unlink(__FILE__)) {
    echo "✅ File cleanup berhasil dihapus.\n";
} else {
    echo "❌ Gagal menghapus file cleanup. Silakan hapus manual: " . basename(__FILE__) . "\n";
}
?>
