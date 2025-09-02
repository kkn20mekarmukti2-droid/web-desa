-- SQL Script untuk menambahkan sample hero images
-- Jalankan di phpMyAdmin atau command line MySQL
-- Pastikan tabel hero_images sudah ada

-- Menambahkan sample hero images berdasarkan gambar yang sudah ada di public/img/
INSERT INTO `hero_images` (`nama_gambar`, `gambar`, `deskripsi`, `urutan`, `is_active`, `created_at`, `updated_at`) VALUES
('Desa Mekarmukti - View 1', 'img/DSC_0070.JPG', 'Pemandangan indah Desa Mekarmukti - Foto utama untuk slideshow hero', 1, 1, NOW(), NOW()),
('Aktivitas Desa', 'img/DSC_0108.jpg', 'Aktivitas masyarakat Desa Mekarmukti dalam kehidupan sehari-hari', 2, 1, NOW(), NOW()),
('Infrastruktur Desa', 'img/DSC_0828.JPG', 'Perkembangan infrastruktur dan pembangunan di Desa Mekarmukti', 3, 1, NOW(), NOW()),
('Fasilitas Umum', 'img/IMG_9152.png', 'Fasilitas umum yang tersedia untuk masyarakat Desa Mekarmukti', 4, 1, NOW(), NOW()),
('Kepemimpinan Desa', 'img/kades.jpg', 'Kepala Desa Mekarmukti dalam menjalankan tugasnya melayani masyarakat', 5, 1, NOW(), NOW()),
('Kegiatan Pembangunan 1', 'img/P1560599.JPG', 'Berbagai kegiatan dan program pembangunan yang dilaksanakan di Desa Mekarmukti', 6, 1, NOW(), NOW()),
('Kegiatan Pembangunan 2', 'img/P1570155.JPG', 'Dokumentasi kegiatan pembangunan dan kemasyarakatan desa', 7, 1, NOW(), NOW());

-- Cek hasil insert
SELECT id, nama_gambar, gambar, urutan, is_active, created_at FROM `hero_images` ORDER BY `urutan` ASC;

-- Query untuk cek total data
SELECT COUNT(*) as total_hero_images FROM `hero_images`;
SELECT COUNT(*) as active_hero_images FROM `hero_images` WHERE is_active = 1;
