<?php
/**
 * Magazine System Cleanup Script - Web Desa
 * Menghapus file debugging majalah yang tidak diperlukan
 */

echo "=== MAGAZINE CLEANUP SCRIPT - WEB DESA ===\n";
echo "Menghapus file debugging dan dokumentasi sistem majalah...\n\n";

// File debugging majalah yang tidak diperlukan
$magazine_files = [
    'MAJALAH_DEPLOYMENT_GUIDE.md',
    'add_sample_majalah.php',
    'check-db-content.php',
    'check_majalah_simple.php',
    'check_majalah_structure.php',
    'copy_majalah_to_public.php',
    'cpanel-deploy-majalah.sh',
    'create_additional_magazines.php',
    'create_sample_majalah.php',
    'debug-majalah-images.php',
    'debug_majalah_data.php',
    'debug_majalah_images.php',
    'deploy-majalah.php',
    'fix-magazine-data.php',
    'fix_cover_paths.php',
    'majalah-tables-deployment.sql',
    'setup_motekart_magazine.php',
    'update_majalah_paths.php'
];

$deleted_count = 0;

echo "🗑️  Menghapus file debugging majalah...\n";

foreach ($magazine_files as $file) {
    if (file_exists($file)) {
        if (unlink($file)) {
            echo "   ✅ Dihapus: $file\n";
            $deleted_count++;
        } else {
            echo "   ❌ Gagal menghapus: $file\n";
        }
    }
}

echo "\n=== RINGKASAN MAGAZINE CLEANUP ===\n";
echo "✅ File debugging majalah dihapus: $deleted_count\n\n";

echo "🎉 Magazine cleanup selesai!\n";
echo "💡 Sistem majalah tetap berfungsi, hanya file debugging yang dihapus\n\n";

// Self-delete countdown
echo "⏰ File cleanup ini akan menghapus dirinya sendiri dalam 3 detik...\n";

for ($i = 3; $i > 0; $i--) {
    echo "   $i...\n";
    sleep(1);
}

// Hapus file ini sendiri
if (unlink(__FILE__)) {
    echo "✅ File magazine cleanup berhasil dihapus.\n";
} else {
    echo "❌ Gagal menghapus file magazine cleanup.\n";
}
