# CPANEL PRODUCTION DATABASE USER CLEANUP GUIDE

## MASALAH
Database di cPanel masih memiliki 7 user lama, sedangkan database lokal SQLite sudah dibersihkan menjadi 2 user saja.

## SOLUSI
Script khusus untuk membersihkan database produksi di cPanel dan memastikan hanya 2 user yang tersisa.

## FILES YANG DIBUAT
1. `cpanel-user-cleanup-production.php` - Script utama untuk cleanup
2. `cpanel-verify-users.php` - Script verifikasi hasil
3. `deploy-cpanel-user-cleanup.sh` - Panduan deployment

## LANGKAH-LANGKAH DEPLOYMENT

### Metode 1: Via cPanel File Manager (Recommended)

1. **Login ke cPanel**
   - Masuk ke akun cPanel hosting Anda
   - Buka File Manager

2. **Upload Script**
   - Navigate ke folder `public_html` (atau folder domain Anda)
   - Upload file `cpanel-user-cleanup-production.php`
   - Upload file `cpanel-verify-users.php`

3. **Jalankan Script**
   - Buka Terminal di cPanel (jika tersedia)
   - Atau gunakan Browser untuk akses script
   - Jalankan: `php cpanel-user-cleanup-production.php`

### Metode 2: Via SSH (Jika tersedia)

```bash
# Login via SSH
ssh your_username@your_domain.com

# Navigate ke directory website
cd public_html

# Upload file (gunakan scp atau wget)
# Contoh jika file sudah di server:
chmod +x cpanel-user-cleanup-production.php

# Jalankan script
php cpanel-user-cleanup-production.php
```

### Metode 3: Via Browser (Direct Access)

1. Upload script ke folder public
2. Akses via browser: `https://yourdomain.com/cpanel-user-cleanup-production.php`
3. Script akan berjalan dan menampilkan output

## HASIL YANG DIHARAPKAN

Setelah menjalankan script, database produksi akan memiliki:

**SEBELUM:** 7 users (data lama)
```
- User 1
- User 2 
- User 3
- User 4
- User 5
- ASFHA NUGRAHA ARIFIN
- Mohammad Nabil Abyyu
```

**SESUDAH:** 2 users saja
```
- ID: 1 | ASFHA NUGRAHA ARIFIN | admin@webdesa.com | Admin
- ID: 2 | Mohammad Nabil Abyyu | writer@webdesa.com | Writer
```

## VERIFIKASI HASIL

### 1. Jalankan Script Verifikasi
```bash
php cpanel-verify-users.php
```

### 2. Check via phpMyAdmin
1. Login ke cPanel phpMyAdmin
2. Pilih database website Anda
3. Browse tabel `users`
4. Pastikan hanya ada 2 record

### 3. Test Login Website
- **Admin:** admin@webdesa.com / admin123
- **Writer:** writer@webdesa.com / writer123

## TROUBLESHOOTING

### Error: Database Connection Failed
- Pastikan file `.env` di server memiliki konfigurasi database yang benar
- Check apakah `DB_CONNECTION=mysql` di production

### Error: Permission Denied
- Pastikan file script memiliki permission yang tepat: `chmod 755`

### Error: Class Not Found
- Pastikan semua dependency Laravel terinstall: `composer install --no-dev`

### Database Masih Memiliki User Lama
- Jalankan ulang script cleanup
- Check apakah script berjalan tanpa error
- Verifikasi koneksi database mengarah ke production DB

## KEAMANAN

⚠️ **PENTING:**
- Script ini akan MENGHAPUS PERMANEN user yang tidak diinginkan
- Pastikan backup database sebelum menjalankan
- Hanya jalankan sekali untuk menghindari duplikasi
- Hapus file script setelah selesai untuk keamanan

## CLEANUP SETELAH SELESAI

Setelah berhasil, hapus file temporary:
```bash
rm cpanel-user-cleanup-production.php
rm cpanel-verify-users.php
```

## KREDENSIAL LOGIN FINAL

Setelah cleanup berhasil:

**Administrator:**
- Email: admin@webdesa.com
- Password: admin123
- Role: Admin (dapat mengelola semua konten)

**Writer:**  
- Email: writer@webdesa.com
- Password: writer123
- Role: Writer (dapat membuat/edit artikel)

---

*Script dibuat pada: 27 Agustus 2025*
*Target: Cleanup database produksi cPanel dari 7 user menjadi 2 user*
