-- =====================================================
-- SCRIPT MIGRASI DATABASE SQLITE KE MYSQL
-- =====================================================
-- Jalankan script ini di phpMyAdmin cPanel Anda
-- =====================================================

-- 1. Buat database baru (lakukan di cPanel MySQL Databases)
-- Database name: your_cpanel_db_name

-- 2. Import data artikel yang sudah ada
-- NOTE: Data ini diambil dari SQLite yang sudah berisi 6 artikel

-- Export artikel dari SQLite dan import ke MySQL
-- Gunakan perintah ini di terminal local:
-- sqlite3 database/database.sqlite ".dump articles" > articles_export.sql
-- Kemudian edit dan import ke MySQL

-- 3. Setup tables yang diperlukan
-- Laravel migrations akan handle ini, tapi backup manual:

-- SAMPLE DATA ARTIKEL (sesuaikan dengan data Anda)
-- INSERT INTO articles (id, judul, header, deskripsi, sampul, kategori, created_at, updated_at, user_id) VALUES
-- (1, 'Sample Article 1', 'Sample header', 'Description...', 'sample.jpg', 1, NOW(), NOW(), 1);

-- 4. Verifikasi data
SELECT COUNT(*) as total_articles FROM articles;
SELECT * FROM categories;
SELECT * FROM users;

-- 5. Check database structure
SHOW TABLES;
DESCRIBE articles;
DESCRIBE users;

-- =====================================================
-- LANGKAH MANUAL DI CPANEL:
-- =====================================================
-- 1. Login ke cPanel
-- 2. MySQL Databases → Create New Database
-- 3. Create Database User dan assign privileges
-- 4. phpMyAdmin → Import → pilih file SQL
-- 5. Update .env dengan kredensial database baru
-- =====================================================
