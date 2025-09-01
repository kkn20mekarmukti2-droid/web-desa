<?php
// Sample data untuk produk UMKM
try {
    $pdo = new PDO('mysql:host=localhost;dbname=web_desa', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "INSERT INTO produk_umkms (nama_produk, deskripsi, gambar, nomor_telepon, created_at, updated_at) VALUES 
    ('Keripik Singkong Renyah', 'Keripik singkong renyah dengan berbagai varian rasa pedas, manis, dan asin. Dibuat dari singkong lokal berkualitas tinggi dengan proses pengolahan yang higienis. Cocok untuk camilan sehari-hari atau oleh-oleh khas desa.', NULL, '6281234567890', NOW(), NOW()),
    ('Gula Aren Murni Original', 'Gula aren murni 100% tanpa campuran bahan kimia, diolah secara tradisional dari nira kelapa aren pilihan. Memiliki rasa manis alami dan aroma khas yang cocok untuk minuman tradisional, kue, dan masakan.', NULL, '6281234567891', NOW(), NOW()),
    ('Emping Melinjo Gurih', 'Emping melinjo renyah dan gurih, dibuat dari biji melinjo pilihan dengan proses pengolahan higienis. Tanpa pengawet dan pewarna buatan. Cocok untuk lauk pendamping nasi atau camilan saat santai.', NULL, '6281234567892', NOW(), NOW()),
    ('Dodol Betawi Khas Desa', 'Dodol betawi dengan cita rasa autentik, dibuat dari bahan-bahan pilihan seperti santan kelapa segar, gula aren, dan tepung ketan berkualitas. Tekstur kenyal dan rasa manis yang pas di lidah.', NULL, '6281234567893', NOW(), NOW())";
    
    $pdo->exec($sql);
    echo "Sample data produk UMKM berhasil ditambahkan!\n";
    echo "Total 4 produk telah dimasukkan ke database.\n";
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
