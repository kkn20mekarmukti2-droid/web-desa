-- 🏛️ APBDes Transparency System - Manual SQL Installation
-- Untuk deployment via phpMyAdmin di cPanel
-- Tanggal: 1 September 2025

-- ============================================
-- 1. CREATE APBDES TABLE
-- ============================================

CREATE TABLE IF NOT EXISTS `apbdes` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Judul dokumen APBDes',
  `image_path` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Path file gambar APBDes',
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Deskripsi dokumen',
  `tahun` int(11) NOT NULL COMMENT 'Tahun anggaran',
  `is_active` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Status publikasi (1=aktif, 0=nonaktif)',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_tahun` (`tahun`),
  KEY `idx_is_active` (`is_active`),
  KEY `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Tabel dokumen APBDes untuk transparansi anggaran';

-- ============================================
-- 2. INSERT SAMPLE DATA (OPTIONAL)
-- ============================================

-- Sample APBDes data untuk testing
INSERT IGNORE INTO `apbdes` (`id`, `title`, `image_path`, `description`, `tahun`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'APBDes Desa Mekarmukti Tahun 2024', 'apbdes/sample-apbdes-2024.jpg', 'Rincian Anggaran Pendapatan dan Belanja Desa Mekarmukti untuk tahun anggaran 2024, mencakup program pembangunan infrastruktur, pemberdayaan masyarakat, dan pelayanan publik.', 2024, 1, NOW(), NOW()),
(2, 'APBDes Desa Mekarmukti Tahun 2025', 'apbdes/sample-apbdes-2025.jpg', 'Anggaran Pendapatan dan Belanja Desa untuk tahun 2025 dengan fokus pada pengembangan digital village dan peningkatan kesejahteraan masyarakat.', 2025, 1, NOW(), NOW());

-- ============================================
-- 3. ADD TO MIGRATIONS TABLE (IF NEEDED)
-- ============================================

-- Tambahkan record migration agar Laravel tahu migration sudah dijalankan
INSERT IGNORE INTO `migrations` (`migration`, `batch`) VALUES
('2025_09_01_000000_create_apbdes_table', (SELECT IFNULL(MAX(batch), 0) + 1 FROM (SELECT * FROM `migrations`) AS temp));

-- ============================================
-- 4. VERIFICATION QUERIES
-- ============================================

-- Check if table created successfully
DESCRIBE `apbdes`;

-- Check sample data
SELECT 
    id,
    title,
    LEFT(description, 50) as short_description,
    tahun,
    is_active,
    created_at
FROM `apbdes`
ORDER BY created_at DESC;

-- Count total records
SELECT COUNT(*) as total_apbdes FROM `apbdes`;

-- Count by status
SELECT 
    is_active,
    COUNT(*) as count,
    CASE 
        WHEN is_active = 1 THEN 'Aktif (Published)'
        ELSE 'Non-Aktif (Draft)'
    END as status_label
FROM `apbdes`
GROUP BY is_active;

-- Count by year
SELECT 
    tahun,
    COUNT(*) as count
FROM `apbdes`
GROUP BY tahun
ORDER BY tahun DESC;

-- ============================================
-- 5. CLEANUP QUERIES (IF NEEDED)
-- ============================================

-- Uncomment jika perlu reset data:
-- DELETE FROM `apbdes` WHERE id > 0;
-- ALTER TABLE `apbdes` AUTO_INCREMENT = 1;

-- Drop table (hanya jika perlu install ulang):
-- DROP TABLE IF EXISTS `apbdes`;

-- ============================================
-- 6. MAINTENANCE QUERIES
-- ============================================

-- Activate all APBDes
-- UPDATE `apbdes` SET is_active = 1;

-- Deactivate specific year
-- UPDATE `apbdes` SET is_active = 0 WHERE tahun = 2023;

-- Update specific record
-- UPDATE `apbdes` SET 
--     title = 'New Title',
--     description = 'New Description',
--     updated_at = NOW()
-- WHERE id = 1;

-- ============================================
-- NOTES FOR CPANEL DEPLOYMENT:
-- ============================================

/*
1. CARA INSTALL:
   - Login cPanel → phpMyAdmin
   - Pilih database website
   - Tab "SQL" → Copy paste query di atas
   - Klik "Go" untuk eksekusi

2. DIRECTORY SETUP:
   Pastikan folder berikut ada dan writable:
   - storage/app/public/apbdes/
   - public/storage/apbdes/

3. FILE PERMISSIONS:
   Set permission 755 untuk:
   - storage/app/public/
   - public/storage/

4. TESTING:
   Setelah install, test:
   - Admin: /admin/apbdes
   - Public: /transparansi-anggaran

5. TROUBLESHOOTING:
   Jika error, check:
   - Database connection di .env
   - File permissions
   - Storage link existence
   - Route cache (php artisan route:clear)
*/

-- ✅ APBDes Table Installation Complete!
-- 🎯 Ready for transparency and accountability!
