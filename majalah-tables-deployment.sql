-- =============================================
-- SQL Script untuk Deployment Sistem Majalah Digital
-- Website Desa Mekarmukti
-- Created: September 4, 2025
-- =============================================

-- Drop tables if exists (untuk fresh installation)
DROP TABLE IF EXISTS `majalah_pages`;
DROP TABLE IF EXISTS `majalah`;

-- =============================================
-- 1. Tabel: majalah
-- =============================================
CREATE TABLE `majalah` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `cover_image` varchar(255) NOT NULL,
  `tanggal_terbit` date NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_majalah_active` (`is_active`),
  INDEX `idx_majalah_tanggal` (`tanggal_terbit`),
  INDEX `idx_majalah_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- 2. Tabel: majalah_pages
-- =============================================
CREATE TABLE `majalah_pages` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `majalah_id` bigint(20) UNSIGNED NOT NULL,
  `page_number` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`majalah_id`) REFERENCES `majalah`(`id`) ON DELETE CASCADE,
  INDEX `idx_pages_majalah` (`majalah_id`),
  INDEX `idx_pages_number` (`page_number`),
  UNIQUE KEY `unique_majalah_page` (`majalah_id`, `page_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- 3. Sample Data untuk Testing
-- =============================================

-- Insert sample magazine
INSERT INTO `majalah` (`judul`, `deskripsi`, `cover_image`, `tanggal_terbit`, `is_active`, `created_at`, `updated_at`) VALUES
('Majalah Desa Edisi Perdana', 'Edisi perdana majalah desa yang berisi informasi terkini tentang perkembangan desa, kegiatan masyarakat, dan berbagai program pembangunan yang sedang berjalan.', 'majalah/sample-cover.jpg', '2025-08-28', 1, NOW(), NOW()),
('Info Desa Edisi September', 'Majalah bulanan yang memuat berita terkini, program kerja, dan prestasi warga desa pada bulan September 2025.', 'majalah/sample-cover-2.jpg', '2025-09-01', 1, NOW(), NOW());

-- Insert sample pages for first magazine
INSERT INTO `majalah_pages` (`majalah_id`, `page_number`, `image_path`, `title`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 'majalah/pages/1/page-1.jpg', 'Cover Depan', 'Cover majalah edisi perdana', NOW(), NOW()),
(1, 2, 'majalah/pages/1/page-2.jpg', 'Kata Pengantar', 'Sambutan dari Kepala Desa', NOW(), NOW()),
(1, 3, 'majalah/pages/1/page-3.jpg', 'Berita Utama', 'Program pembangunan infrastruktur desa', NOW(), NOW()),
(1, 4, 'majalah/pages/1/page-4.jpg', 'Kegiatan Masyarakat', 'Gotong royong pembersihan lingkungan', NOW(), NOW()),
(1, 5, 'majalah/pages/1/page-5.jpg', 'UMKM Desa', 'Profil pengusaha UMKM sukses di desa', NOW(), NOW()),
(1, 6, 'majalah/pages/1/page-6.jpg', 'Pendidikan', 'Prestasi siswa sekolah dasar desa', NOW(), NOW()),
(1, 7, 'majalah/pages/1/page-7.jpg', 'Kesehatan', 'Program vaksinasi dan posyandu', NOW(), NOW()),
(1, 8, 'majalah/pages/1/page-8.jpg', 'Pariwisata', 'Destinasi wisata alam di sekitar desa', NOW(), NOW()),
(1, 9, 'majalah/pages/1/page-9.jpg', 'Teknologi', 'Digitalisasi pelayanan desa', NOW(), NOW()),
(1, 10, 'majalah/pages/1/page-10.jpg', 'Cover Belakang', 'Penutup dan kontak informasi', NOW(), NOW());

-- Insert sample pages for second magazine
INSERT INTO `majalah_pages` (`majalah_id`, `page_number`, `image_path`, `title`, `description`, `created_at`, `updated_at`) VALUES
(2, 1, 'majalah/pages/2/page-1.jpg', 'Cover September', 'Cover majalah edisi September', NOW(), NOW()),
(2, 2, 'majalah/pages/2/page-2.jpg', 'Editorial', 'Catatan redaksi bulan September', NOW(), NOW()),
(2, 3, 'majalah/pages/2/page-3.jpg', 'Laporan Keuangan', 'Transparansi APBDes September', NOW(), NOW()),
(2, 4, 'majalah/pages/2/page-4.jpg', 'Prestasi Desa', 'Penghargaan yang diraih bulan ini', NOW(), NOW()),
(2, 5, 'majalah/pages/2/page-5.jpg', 'Program Kerja', 'Rencana kegiatan Oktober 2025', NOW(), NOW()),
(2, 6, 'majalah/pages/2/page-6.jpg', 'Galeri Kegiatan', 'Dokumentasi acara bulan September', NOW(), NOW()),
(2, 7, 'majalah/pages/2/page-7.jpg', 'Tips Sehat', 'Menjaga kesehatan di musim pancaroba', NOW(), NOW()),
(2, 8, 'majalah/pages/2/page-8.jpg', 'Penutup', 'Salam dari tim redaksi', NOW(), NOW());

-- =============================================
-- 4. Verification Queries
-- =============================================

-- Cek data majalah
SELECT 
    m.id,
    m.judul,
    m.deskripsi,
    m.tanggal_terbit,
    m.is_active,
    COUNT(mp.id) as total_pages,
    m.created_at
FROM majalah m 
LEFT JOIN majalah_pages mp ON m.id = mp.majalah_id 
GROUP BY m.id
ORDER BY m.tanggal_terbit DESC;

-- Cek halaman majalah
SELECT 
    mp.id,
    m.judul as majalah_title,
    mp.page_number,
    mp.title as page_title,
    mp.description,
    mp.created_at
FROM majalah_pages mp
JOIN majalah m ON mp.majalah_id = m.id
ORDER BY m.id, mp.page_number;

-- =============================================
-- 5. Maintenance Queries
-- =============================================

-- Query untuk membersihkan data (jika diperlukan)
-- DELETE FROM majalah_pages WHERE majalah_id = ?;
-- DELETE FROM majalah WHERE id = ?;

-- Query untuk toggle status majalah
-- UPDATE majalah SET is_active = !is_active WHERE id = ?;

-- Query untuk mendapatkan majalah aktif dengan jumlah halaman
-- SELECT m.*, COUNT(mp.id) as total_pages 
-- FROM majalah m 
-- LEFT JOIN majalah_pages mp ON m.id = mp.majalah_id 
-- WHERE m.is_active = 1 
-- GROUP BY m.id 
-- ORDER BY m.tanggal_terbit DESC;

-- =============================================
-- Installation Notes:
-- =============================================
-- 1. Pastikan direktori storage/app/public/majalah sudah dibuat
-- 2. Jalankan: php artisan storage:link (jika belum)
-- 3. Set permissions untuk direktori storage: chmod -R 755 storage/
-- 4. Pastikan file gambar sample ada di storage/app/public/majalah/
-- 5. Test akses admin: /admin/majalah
-- 6. Test akses public: /majalah-desa
-- 
-- Struktur direktori yang diperlukan:
-- storage/app/public/
-- ├── majalah/
-- │   ├── sample-cover.jpg
-- │   ├── sample-cover-2.jpg
-- │   └── pages/
-- │       ├── 1/
-- │       │   ├── page-1.jpg
-- │       │   ├── page-2.jpg
-- │       │   └── ...
-- │       └── 2/
-- │           ├── page-1.jpg
-- │           └── ...
-- =============================================
