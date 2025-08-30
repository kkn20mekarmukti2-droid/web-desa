# 🚀 PANDUAN DEPLOYMENT cPANEL - Data Statistik Fix

## ❌ Problem yang akan diselesaikan:
```
SQLSTATE[42S02]: Base table or view not found: 1146 Table 'mekh7277_desa.data' doesn't exist
```
Di halaman: https://mekarmukti.id/admin/data-management

## 📋 LANGKAH-LANGKAH DEPLOYMENT

### 1. Persiapan Database Password
- Login ke cPanel hosting Anda
- Masuk ke **MySQL Databases** 
- Catat password database untuk user: `mekh7277_desa`
- Jika lupa password, bisa reset di cPanel

### 2. Upload Script ke Server
- Download file: `cpanel-data-statistik-deploy.php`
- Upload ke folder root website via **File Manager cPanel**
- Lokasi: `/public_html/cpanel-data-statistik-deploy.php`

### 3. Edit Konfigurasi Database
Buka file `cpanel-data-statistik-deploy.php` dan edit bagian ini:
```php
$db_config = [
    'host' => 'localhost',           
    'dbname' => 'mekh7277_desa',    
    'username' => 'mekh7277_desa',  
    'password' => 'PASSWORD_ANDA'   // ⚠️ GANTI INI!
];
```
**Ganti `PASSWORD_ANDA` dengan password database yang sesungguhnya!**

### 4. Jalankan Script Deployment
Buka browser dan akses:
```
https://mekarmukti.id/cpanel-data-statistik-deploy.php
```

Script akan:
- ✅ Cek koneksi database
- ✅ Buat tabel `data` jika belum ada
- ✅ Insert 28 data statistik lengkap
- ✅ Verifikasi hasil

### 5. Test Hasil
Setelah script berhasil, test halaman:
```
https://mekarmukti.id/admin/data-management
```

Seharusnya tidak error lagi dan menampilkan data statistik.

### 6. Clean Up
Hapus file deployment untuk keamanan:
- `cpanel-data-statistik-deploy.php`

## 📊 DATA YANG AKAN DIBUAT

Script akan membuat **28 records** dalam 6 kategori:

### 👨‍🎓 Pendidikan (6 records)
- Tidak Tamat SD: 45 orang
- Tamat SD/Sederajat: 128 orang  
- Tamat SMP/Sederajat: 97 orang
- Tamat SMA/Sederajat: 156 orang
- Diploma/Sarjana S1: 73 orang
- Pascasarjana S2/S3: 12 orang

### 👷‍♂️ Pekerjaan (7 records)  
- Petani/Pekebun: 187 orang
- Buruh Tani/Harian: 94 orang
- Pedagang/Wiraswasta: 52 orang
- PNS/ASN: 28 orang
- Karyawan Swasta: 65 orang
- Pensiunan: 19 orang
- Belum/Tidak Bekerja: 67 orang

### 👶 Kelompok Usia (4 records)
- Balita (0-5 Tahun): 78 orang
- Anak-Remaja (6-17 Tahun): 142 orang
- Dewasa (18-59 Tahun): 287 orang
- Lansia (60+ Tahun): 56 orang

### 🕌 Agama (5 records)
- Islam: 524 orang
- Kristen Protestan: 28 orang
- Katolik: 15 orang
- Hindu: 3 orang
- Buddha: 1 orang

### 💑 Status Perkawinan (4 records)
- Belum Kawin: 189 orang
- Kawin: 312 orang
- Cerai Hidup: 23 orang
- Cerai Mati (Duda/Janda): 47 orang

### 👫 Jenis Kelamin (2 records)
- Laki-laki: 289 orang
- Perempuan: 282 orang

**Total Populasi: 571 jiwa**

## 🔧 TROUBLESHOOTING

### Error: Access denied for user
```bash
# Solusi:
1. Cek password database di cPanel
2. Pastikan user 'mekh7277_desa' ada dan aktif
3. Reset password database jika perlu
```

### Error: Database connection failed
```bash
# Solusi:
1. Pastikan database 'mekh7277_desa' ada
2. Cek MySQL service status di cPanel
3. Hubungi support hosting jika perlu
```

### Halaman masih error setelah deployment
```bash
# Solusi:
1. Clear cache Laravel (jika bisa akses terminal):
   php artisan cache:clear
   php artisan config:clear
   
2. Atau restart PHP-FPM di cPanel
3. Cek error logs di cPanel untuk detail error
```

### Script timeout/tidak selesai
```bash
# Solusi:
1. Akses melalui SSH jika tersedia:
   php cpanel-data-statistik-deploy.php
   
2. Atau insert data manual via phpMyAdmin
3. Hubungi support hosting untuk increase timeout limit
```

## 📞 SUPPORT

Jika masih ada masalah:
1. Screenshot error yang muncul
2. Cek cPanel Error Logs
3. Pastikan semua file sudah terupload dan konfigurasi benar
4. Test koneksi database via phpMyAdmin dulu

## ✅ HASIL YANG DIHARAPKAN

Setelah deployment berhasil:
- ✅ Halaman Data Statistik bisa dibuka tanpa error
- ✅ Menampilkan grafik/chart dengan data statistik
- ✅ Dashboard admin menampilkan statistik lengkap
- ✅ Data bisa di-manage (tambah/edit/hapus) melalui admin

---
**Script deployment:** `cpanel-data-statistik-deploy.php`  
**Target database:** `mekh7277_desa.data`  
**Environment:** cPanel Production  
**Tanggal:** {{ date('Y-m-d') }}
