# Panduan Deploy Sistem Produk UMKM ke cPanel

## 1. Upload Files ke cPanel
Upload semua files yang sudah diupdate ke server cPanel:
- `app/Http/Controllers/ProdukUmkmController.php`
- `app/Models/ProdukUmkm.php` 
- `resources/views/produk-umkm*.blade.php` (4 files)
- `routes/web.php` (updated)
- Semua file layout yang sudah diupdate

## 2. Buat Tabel di Database cPanel

### Cara 1: Via phpMyAdmin
1. Login ke cPanel → phpMyAdmin
2. Pilih database website desa
3. Klik tab "SQL" 
4. Copy paste script dari file `cpanel-produk-umkm-table.sql`
5. Klik "Go" untuk menjalankan

### Cara 2: Via Laravel Artisan (jika ada akses terminal)
```bash
php artisan migrate
```

## 3. Set Permission Folder Storage
Pastikan folder `storage/app/public/umkm` dapat diakses untuk upload gambar:
```bash
chmod 755 storage/app/public/
mkdir storage/app/public/umkm
chmod 755 storage/app/public/umkm
```

## 4. Create Symbolic Link (jika belum ada)
```bash
php artisan storage:link
```

## 5. Clear Cache
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
```

## 6. Test Fitur
1. Akses website → Menu "Produk UMKM" 
2. Login admin → Tambah produk UMKM
3. Test WhatsApp link pada produk
4. Test upload gambar produk

## 7. Sample Data
Script SQL sudah include 3 sample data produk UMKM:
- Keripik Singkong
- Gula Aren Murni  
- Emping Melinjo

## Fitur yang Tersedia:
✅ **Public**: Lihat daftar produk UMKM dengan pagination
✅ **Public**: Klik WhatsApp untuk langsung chat penjual
✅ **Admin**: CRUD lengkap (Create, Read, Update, Delete)
✅ **Admin**: Upload gambar produk
✅ **Admin**: Manajemen nomor WhatsApp per produk
✅ **Responsive**: Desain mobile-friendly dengan centered layout

Sistem siap untuk production! 🚀
