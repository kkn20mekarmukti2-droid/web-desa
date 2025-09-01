-- SQL Script untuk membuat tabel produk_umkms di cPanel/phpMyAdmin
-- Copy dan jalankan script ini di phpMyAdmin cPanel

CREATE TABLE `produk_umkms` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_produk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor_telepon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Script untuk menambahkan data sample (opsional)
INSERT INTO `produk_umkms` (`nama_produk`, `deskripsi`, `gambar`, `nomor_telepon`, `created_at`, `updated_at`) VALUES
('Keripik Singkong', 'Keripik singkong renyah dengan berbagai varian rasa. Produk unggulan UMKM Desa Mekarmukti yang dibuat dari singkong lokal berkualitas tinggi.', NULL, '6281234567890', NOW(), NOW()),
('Gula Aren Murni', 'Gula aren murni tanpa campuran, diolah secara tradisional dari nira kelapa aren pilihan. Cocok untuk minuman dan masakan tradisional.', NULL, '6281234567891', NOW(), NOW()),
('Emping Melinjo', 'Emping melinjo renyah dan gurih, dibuat dari biji melinjo pilihan dengan proses pengolahan higienis. Cocok untuk lauk atau camilan.', NULL, '6281234567892', NOW(), NOW());

-- Alternatif: Jika ingin menjalankan migrasi Laravel via SQL
-- Gunakan script di atas untuk membuat tabel manual di cPanel
