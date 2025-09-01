-- =====================================================
-- CPANEL DEPLOYMENT: STRUKTUR PEMERINTAHAN TABLE
-- Database: web_desa
-- Date: September 1, 2025
-- =====================================================

-- Create struktur_pemerintahans table
CREATE TABLE IF NOT EXISTS `struktur_pemerintahans` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `urutan` int(11) NOT NULL DEFAULT 1,
  `kategori` enum('kepala_desa','sekretaris','kepala_urusan','kepala_seksi','kepala_dusun') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'kepala_seksi',
  `pendidikan` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tugas_pokok` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_sk` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_sk` date DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `struktur_pemerintahans_kategori_index` (`kategori`),
  KEY `struktur_pemerintahans_is_active_index` (`is_active`),
  KEY `struktur_pemerintahans_urutan_index` (`urutan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert sample data
INSERT INTO `struktur_pemerintahans` (`id`, `nama`, `jabatan`, `foto`, `urutan`, `kategori`, `pendidikan`, `tugas_pokok`, `no_sk`, `tgl_sk`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'ANDRIAWAN BURHANUDIN, SH', 'Kepala Desa', 'img/perangkat/kades.jpg', 1, 'kepala_desa', 'S1 Hukum', 'Memimpin penyelenggaraan pemerintahan desa, pembangunan, pembinaan kemasyarakatan, dan pemberdayaan masyarakat desa.', NULL, NULL, 1, '2025-09-01 12:05:00', '2025-09-01 12:05:00'),
(2, 'YADI DAMANHURI, ST', 'Sekretaris Desa', 'img/perangkat/sekdes.jpg', 2, 'sekretaris', 'S1 Teknik', 'Membantu kepala desa dalam melaksanakan tugas dan wewenangnya serta menyelenggarakan administrasi pemerintahan desa.', NULL, NULL, 1, '2025-09-01 12:05:00', '2025-09-01 12:05:00'),
(3, 'NENG IA FITRI A', 'Kepala Urusan Keuangan', 'img/perangkat/nengia.jpg', 3, 'kepala_urusan', NULL, 'Menyelenggarakan urusan keuangan desa, pengelolaan anggaran, dan pertanggungjawaban keuangan desa.', NULL, NULL, 1, '2025-09-01 12:05:00', '2025-09-01 12:05:00'),
(4, 'WAHYU HADIAN, SE', 'Kepala Urusan Perencanaan', 'img/perangkat/wahyu.jpg', 4, 'kepala_urusan', 'S1 Ekonomi', 'Menyelenggarakan urusan perencanaan desa, penyusunan program kerja, dan evaluasi pembangunan desa.', NULL, NULL, 1, '2025-09-01 12:05:00', '2025-09-01 12:05:00'),
(5, 'TISNA UNDAYA', 'Kepala Urusan Tata Usaha', 'img/perangkat/uun.jpg', 5, 'kepala_urusan', NULL, 'Menyelenggarakan urusan ketatausahaan desa, administrasi umum, dan kearsipan.', NULL, NULL, 1, '2025-09-01 12:05:00', '2025-09-01 12:05:00'),
(6, 'LALAN JAELANI', 'Kepala Seksi Kesejahteraan', 'img/perangkat/lalan.jpg', 6, 'kepala_seksi', NULL, 'Menyelenggarakan urusan kesejahteraan masyarakat, bantuan sosial, dan pemberdayaan ekonomi masyarakat.', NULL, NULL, 1, '2025-09-01 12:05:00', '2025-09-01 12:05:00'),
(7, 'ASFHA NUGRAHA ARIFIN', 'Kepala Seksi Pemerintahan', 'img/perangkat/asfa.jpg', 7, 'kepala_seksi', NULL, 'Menyelenggarakan urusan pemerintahan umum, ketertiban, dan keamanan desa.', NULL, NULL, 1, '2025-09-01 12:05:00', '2025-09-01 12:05:00'),
(8, 'DEWI LISTIANI ABIDIN', 'Kepala Seksi Pelayanan', 'img/perangkat/dewi.jpg', 8, 'kepala_seksi', NULL, 'Menyelenggarakan urusan pelayanan umum kepada masyarakat dan administrasi kependudukan.', NULL, NULL, 1, '2025-09-01 12:05:00', '2025-09-01 12:05:00'),
(9, 'ENCEP MULYANA', 'Kepala Dusun I', 'img/perangkat/encep.jpg', 9, 'kepala_dusun', NULL, 'Membantu kepala desa dalam melaksanakan tugasnya di wilayah Dusun I.', NULL, NULL, 1, '2025-09-01 12:05:00', '2025-09-01 12:05:00'),
(10, 'AGUS RIDWAN', 'Kepala Dusun II', 'img/perangkat/ridwan.jpg', 10, 'kepala_dusun', NULL, 'Membantu kepala desa dalam melaksanakan tugasnya di wilayah Dusun II.', NULL, NULL, 1, '2025-09-01 12:05:00', '2025-09-01 12:05:00'),
(11, 'FEBRI HARDIANSYAH', 'Kepala Dusun III', 'img/perangkat/febri.jpg', 11, 'kepala_dusun', NULL, 'Membantu kepala desa dalam melaksanakan tugasnya di wilayah Dusun III.', NULL, NULL, 1, '2025-09-01 12:05:00', '2025-09-01 12:05:00'),
(12, 'PERI', 'Kepala Dusun IV', 'img/perangkat/peri.jpg', 12, 'kepala_dusun', NULL, 'Membantu kepala desa dalam melaksanakan tugasnya di wilayah Dusun IV.', NULL, NULL, 1, '2025-09-01 12:05:00', '2025-09-01 12:05:00');

-- Update AUTO_INCREMENT
ALTER TABLE `struktur_pemerintahans` AUTO_INCREMENT = 13;

-- Verify installation
SELECT COUNT(*) as total_records, 
       SUM(CASE WHEN kategori = 'kepala_desa' THEN 1 ELSE 0 END) as kepala_desa,
       SUM(CASE WHEN kategori = 'sekretaris' THEN 1 ELSE 0 END) as sekretaris,
       SUM(CASE WHEN kategori = 'kepala_urusan' THEN 1 ELSE 0 END) as kepala_urusan,
       SUM(CASE WHEN kategori = 'kepala_seksi' THEN 1 ELSE 0 END) as kepala_seksi,
       SUM(CASE WHEN kategori = 'kepala_dusun' THEN 1 ELSE 0 END) as kepala_dusun
FROM struktur_pemerintahans;
