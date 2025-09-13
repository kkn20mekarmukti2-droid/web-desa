<?php
/**
 * Final Cleanup Script - Web Desa
 * Menghapus file debugging dan dokumentasi yang tersisa
 */

echo "=== FINAL CLEANUP SCRIPT - WEB DESA ===\n";
echo "Menghapus file debugging dan dokumentasi yang tersisa...\n\n";

// File debugging PHP yang tersisa
$debug_files = [
    'cpanel-verify-users.php',
    'create-pengaduan-table-modern.php',
    'create-pengaduan-table.php',
    'create-visitor-tables-fixed.php',
    'create-visitor-tables.php',
    'create_rtrw_data.php',
    'create_sample_apbdes.php',
    'create_sample_data.php',
    'create_second_superadmin.php',
    'create_test_data.php',
    'create_test_users.php',
    'curl_debug.php',
    'database-diagnostic.php',
    'debug-apbdes-images-complete.php',
    'debug-apbdes-images-production.php',
    'debug-apbdes-production.php',
    'debug-image-display.php',
    'debug-section-fix.php',
    'debug-visitor-counter.php',
    'debug-web-access.php',
    'debug_admin_modern.php',
    'debug_apbdes_images.php',
    'debug_artikel.php',
    'debug_data_table.php',
    'debug_edit_page.php',
    'debug_images.php',
    'debug_statistik.php',
    'debug_umkm_images.php',
    'export_data.php',
    'final_user_setup.php',
    'find-gallery-data.php',
    'fix-apbdes-images.php',
    'fix-apbdes-paths.php',
    'fix-image-display.php',
    'fix-laravel-env.php',
    'fix-production-routes.php',
    'fix_database_structure.php',
    'fix_homepage_articles.php',
    'fix_user_roles.php',
    'laravel-data-deploy.php',
    'manage_users.php',
    'manual-copy-images.php',
    'move-apbdes-to-img.php',
    'optimize_images.php',
    'production-deploy-data.php',
    'serve-image.php',
    'simple-deploy-data.php',
    'simple_debug.php',
    'test-apbdes-admin.php',
    'test-apbdes-production.php',
    'test-apbdes-simple.php',
    'test-api-endpoints.php',
    'test-centered-layout.php',
    'test-image-access.php',
    'test-layout-fix.php',
    'test-role-system.php',
    'test-routes.php',
    'test-variable-fix.php',
    'test-visitor-counter.php',
    'test_apbdes_data.php',
    'test_edit.php',
    'test_fixes.php',
    'test_models.php',
    'update-visitor-stats.php',
    'update_images.php',
    'update_rt_rw_data.php',
    'update_struktur_from_hardcode.php',
    'update_user_5_to_superadmin.php',
    'update_user_roles.php',
    'update_user_roles_production.php',
    'user-cleanup.php',
    'verify-authcontroller.php',
    'visitor-api.php',
    'visitor-counter-planning.php'
];

// File shell script yang tidak diperlukan
$shell_files = [
    'cpanel-user-cleanup.sh',
    'debug-cpanel-deployment.sh',
    'deploy-apbdes-cpanel.sh',
    'deploy-apbdes-image-fix.ps1',
    'deploy-apbdes-image-fix.sh',
    'deploy-cpanel-user-cleanup.sh',
    'deploy-mobile-nav.sh',
    'deploy-pengaduan-cpanel.sh',
    'deploy-real-data.sh',
    'deploy-section-fix.ps1',
    'deploy-section-fix.sh',
    'deploy-statistik-admin.sh',
    'deploy-statistik-to-cpanel.ps1',
    'deploy-statistik-to-cpanel.sh',
    'deploy-to-cpanel.sh',
    'deploy.sh',
    'emergency-deployment.sh',
    'enhanced-cpanel-deploy.sh',
    'fix-apbdes-production.sh',
    'fix-storage-link.sh',
    'force-cleanup-update.sh',
    'force-sync-to-target.sh',
    'manual-copy-images.sh',
    'production-admin-fix.sh',
    'production-deploy.sh',
    'production-route-fix.sh',
    'quick-deploy-artisan.sh',
    'quick-deploy.sh',
    'resolve-server-conflict.sh',
    'safe-deployment.sh',
    'simple-cleanup.sh',
    'user-cleanup.sh',
    'verify-file-updates.sh'
];

// File SQL yang tidak diperlukan
$sql_files = [
    'database_migration.sql',
    'populate_production_data.sql',
    'update_profesi_categories.sql',
    'visitor-counter-tables.sql'
];

// File dokumentasi MD yang tersisa
$doc_files = [
    'DATABASE_CLEANUP_DEPLOYMENT.md',
    'DEPLOYMENT_COMPLETE_GUIDE.md',
    'DEPLOYMENT_GUIDE.md',
    'ENHANCED_UI_UX_DOCUMENTATION.md',
    'FOOTER_ENHANCEMENT.md',
    'GALLERY_REDESIGN_DOCUMENTATION.md',
    'HERO_COMPONENT_DOCS.md',
    'IMAGE_BLANK_DISPLAY_FIX.md',
    'manual-deployment-steps.md',
    'MOBILE_NAV_DEPLOYMENT.md',
    'PRODUCTION_DATA_DEPLOY.md',
    'PRODUCTION_ROLE_ERROR_FIX.md',
    'QUICK_DEPLOY_APBDES.md',
    'REDESIGN_COMPLETE_DOCUMENTATION.md',
    'ROUTE_FIX_DOCUMENTATION.md',
    'SCRIPTS_README.md',
    'SECTION_FIX_DEPLOYMENT.md',
    'STRUKTUR_PEMERINTAHAN_DEPLOYMENT.md',
    'UMKM_IMAGE_FIX_DEPLOYMENT.md',
    'USER_CLEANUP_GUIDE.md',
    'USER_CREDENTIALS.md',
    'USER_MANAGEMENT_DOCS.md',
    'USER_ROLE_DEPLOYMENT_GUIDE.md'
];

// File HTML test yang tidak diperlukan
$html_files = [
    'test-chart-debug.html',
    'test-dropdown-simple.html'
];

// File JS test yang tidak diperlukan
$js_files = [
    'test-dropdown.js'
];

// File PHP class yang tidak diperlukan
$class_files = [
    'ROLE_SYSTEM_COMPLETE_SUMMARY.php',
    'VISITOR_COUNTER_COMPLETE_SUMMARY.php'
];

$deleted_count = 0;

// Function untuk menghapus array file
function deleteFiles($files, $type) {
    global $deleted_count;
    echo "🗑️  Menghapus file $type...\n";
    
    foreach ($files as $file) {
        if (file_exists($file)) {
            if (unlink($file)) {
                echo "   ✅ Dihapus: $file\n";
                $deleted_count++;
            } else {
                echo "   ❌ Gagal menghapus: $file\n";
            }
        }
    }
    echo "\n";
}

// Hapus semua file debugging
deleteFiles($debug_files, 'debugging PHP');
deleteFiles($shell_files, 'shell script');
deleteFiles($sql_files, 'SQL debugging');
deleteFiles($doc_files, 'dokumentasi MD');
deleteFiles($html_files, 'HTML test');
deleteFiles($js_files, 'JavaScript test');
deleteFiles($class_files, 'PHP class debugging');

// Hapus folder web_desa jika ada (duplikat)
if (is_dir('web_desa')) {
    echo "📁 Menghapus folder duplikat...\n";
    function deleteDir($dirPath) {
        if (!is_dir($dirPath)) {
            throw new InvalidArgumentException("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }
    
    try {
        deleteDir('web_desa');
        echo "   ✅ Folder web_desa dihapus\n";
        $deleted_count++;
    } catch (Exception $e) {
        echo "   ❌ Gagal menghapus folder web_desa: " . $e->getMessage() . "\n";
    }
    echo "\n";
}

echo "=== RINGKASAN FINAL CLEANUP ===\n";
echo "✅ Total file dihapus: $deleted_count\n\n";

echo "🎉 Final cleanup selesai!\n";
echo "💡 Untuk dokumentasi lengkap, lihat file: DOKUMENTASI_LENGKAP.md\n\n";

// Self-delete countdown
echo "⏰ File cleanup ini akan menghapus dirinya sendiri dalam 5 detik...\n";
echo "   (Tekan Ctrl+C untuk membatalkan)\n";

for ($i = 5; $i > 0; $i--) {
    echo "   $i...\n";
    sleep(1);
}

// Hapus file ini sendiri
if (unlink(__FILE__)) {
    echo "✅ File final cleanup berhasil dihapus.\n";
} else {
    echo "❌ Gagal menghapus file final cleanup.\n";
}
