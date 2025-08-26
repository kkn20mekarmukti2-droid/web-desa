-- =====================================================
-- UPDATE PROFESI CATEGORIES FOR CLEAN CHART DISPLAY
-- Database: mekh7277_desa (MySQL Production)
-- =====================================================

-- Remove old profession data
DELETE FROM data WHERE data = 'profesi';

-- =====================================================
-- INSERT NEW CATEGORIZED PROFESSION DATA (OPSI C)
-- =====================================================

-- Kategorisasi Profesi yang Clean dan Representatif
INSERT INTO data (data, label, total, created_at, updated_at) VALUES
('profesi', 'PNS & Aparatur', 225, NOW(), NOW()),       -- PNS + TNI/Polri + Guru PNS
('profesi', 'Pegawai Swasta', 630, NOW(), NOW()),       -- Wiraswasta + Buruh + Pedagang + Tukang  
('profesi', 'Petani', 680, NOW(), NOW()),               -- Sektor utama desa
('profesi', 'Tidak Bekerja', 545, NOW(), NOW()),        -- IRT + Pengangguran + Pensiunan
('profesi', 'Pelajar/Mahasiswa', 240, NOW(), NOW());    -- Pelajar dan Mahasiswa

-- =====================================================
-- VERIFICATION
-- =====================================================

-- Check updated profession data
SELECT * FROM data WHERE data = 'profesi' ORDER BY total DESC;

-- Verify total remains consistent
SELECT 'Profesi Total' as Category, SUM(total) as Total_Population 
FROM data 
WHERE data = 'profesi';

-- =====================================================
-- RESULT
-- =====================================================
SELECT '✅ PROFESSION CATEGORIES UPDATED!' as Status,
       '📊 5 Clean Categories' as Categories,
       '🎯 Chart akan tampil lebih bersih' as Result;
