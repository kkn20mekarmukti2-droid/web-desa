# 📚 DOKUMENTASI LENGKAP WEBSITE DESA

## 🌟 Overview
Website desa modern dengan fitur lengkap untuk transparansi dan pelayanan publik yang dibangun menggunakan Laravel 11 dan SQLite database.

---

## 🚀 Fitur Utama

### 1. **Homepage Dinamis**
- Hero carousel dengan gambar desa
- Statistik real-time penduduk  
- Berita terbaru
- UMKM showcase
- Galeri foto kegiatan

### 2. **Transparansi Pemerintahan**
- **APBDes**: Anggaran pendapatan dan belanja desa
- **Struktur Pemerintahan**: Profil perangkat desa
- **Data Statistik**: Demografi dan data kependudukan
- **Berita**: Informasi kegiatan dan kebijakan

### 3. **Layanan Publik**
- **Pengaduan Masyarakat**: Form pengaduan online
- **Produk UMKM**: Showcase produk lokal
- **Galeri**: Dokumentasi kegiatan desa
- **Profil Desa**: Sejarah, visi misi, potensi

### 4. **Panel Admin Modern**
- Dashboard analytics dengan charts
- Management konten (artikel, galeri, UMKM)
- User management dengan role-based access
- Data management (statistik, RT/RW, APBDes)
- Notification system

---

## 🛠️ Teknologi

| Komponen | Teknologi | Versi |
|----------|-----------|-------|
| Backend | Laravel | 11.16.0 |
| Database | SQLite | 3.x |
| Frontend | Bootstrap | 5.3 |
| JavaScript | jQuery + Charts.js | 3.6 |
| Icons | Bootstrap Icons + Font Awesome | Latest |
| PHP | PHP | 8.3+ |

---

## 📁 Struktur Direktori

```
web-desa/
├── app/
│   ├── Http/Controllers/     # Controllers
│   │   ├── adminController.php
│   │   ├── homeController.php
│   │   ├── dataController.php
│   │   ├── galleryController.php
│   │   ├── authController.php
│   │   ├── ApbdesController.php
│   │   ├── ProdukUmkmController.php
│   │   └── StrukturPemerintahanController.php
│   └── Models/              # Eloquent Models
│       ├── artikelModel.php
│       ├── galleryModel.php
│       ├── User.php
│       ├── Apbdes.php
│       ├── ProdukUmkm.php
│       └── StrukturPemerintahan.php
├── database/
│   └── database.sqlite      # Database SQLite
├── public/
│   ├── img/                 # Gambar uploaded
│   │   ├── galeri/
│   │   ├── umkm/
│   │   ├── perangkat/
│   │   └── hero/
│   ├── css/                 # Stylesheets
│   └── js/                  # JavaScript files
├── resources/views/
│   ├── layout/
│   │   ├── app.blade.php    # Layout utama
│   │   └── admin-modern.blade.php
│   ├── admin/               # Views admin
│   └── public views/        # Views publik
└── routes/
    └── web.php              # Route definitions
```

---

## 🗄️ Database Schema

### Tabel Utama

**users**
- id, name, email, password, role, avatar, is_active

**artikel** 
- id, judul, konten, gambar, kategori_id, tanggal, status

**galeri**
- id, judul, url, deskripsi, created_at

**apbdes**
- id, nama_program, kategori, anggaran, realisasi, tahun

**produk_umkm**
- id, nama_produk, deskripsi, harga, gambar, kontak

**struktur_pemerintahan**
- id, nama, jabatan, foto, periode_mulai, periode_selesai

**data_statistik**
- id, kategori, label, value, tahun

---

## 🔐 User Roles & Permissions

### 1. **Super Admin**
- Full access ke semua fitur
- User management 
- System settings

### 2. **Admin**
- Content management (artikel, galeri)
- Data management (APBDes, UMKM)
- Dashboard analytics

### 3. **Editor**
- Create/edit artikel
- Upload galeri
- Basic dashboard access

### 4. **Viewer** 
- Read-only access
- Dashboard viewing

---

## 🌐 Routes Utama

### Public Routes
```php
/ → Homepage
/about → Profil desa
/berita → Daftar berita
/galeri-desa → Galeri foto
/produk-umkm → Showcase UMKM
/transparansi-anggaran → APBDes public
/pengaduan → Form pengaduan
/data/penduduk → Data demografi
```

### Admin Routes (Protected)
```php
/admin/dashboard → Admin dashboard
/admin/content/manage → Kelola artikel
/admin/gallery → Kelola galeri
/admin/users → User management
/admin/apbdes → Kelola APBDes
/admin/produk-umkm → Kelola UMKM
/admin/statistik → Kelola data statistik
```

---

## 🚀 Deployment Guide

### 1. **Persiapan Server**
```bash
# Requirements
PHP 8.3+
SQLite extension
mod_rewrite enabled
```

### 2. **Upload Files**
- Upload semua files ke direktori public_html
- Set permission 755 untuk direktori
- Set permission 644 untuk files

### 3. **Configuration**
```bash
# Copy environment file
cp .env.example .env

# Set database path di .env
DB_CONNECTION=sqlite
DB_DATABASE=/path/to/database.sqlite

# Generate app key
php artisan key:generate
```

### 4. **Database Setup**
```bash
# Database sudah tersedia di database/database.sqlite
# Atau restore dari backup:
# sqlite3 database.sqlite < backup.sql
```

### 5. **Permissions**
```bash
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
chmod -R 755 public/img/
```

---

## 🔧 Maintenance

### Cache Management
```bash
# Clear all cache
php artisan optimize:clear

# Individual cache clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
```

### Database Maintenance
```bash
# Backup database
cp database/database.sqlite backup/database_$(date +%Y%m%d).sqlite

# Check database integrity
sqlite3 database.sqlite "PRAGMA integrity_check;"
```

### Log Monitoring
```bash
# Check Laravel logs
tail -f storage/logs/laravel.log

# Check web server logs
tail -f /var/log/apache2/error.log
```

---

## 🎨 Customization

### 1. **Branding**
- Logo: `public/img/logo.png`
- Colors: `public/css/custom.css`
- Favicon: `public/favicon.ico`

### 2. **Content**
- Hero images: `public/img/hero/`
- Default content: Database seeder
- Layout: `resources/views/layout/app.blade.php`

### 3. **Features**
- Add new modules: Create Controller + Model + Views
- Modify existing: Edit respective files
- Database changes: Laravel migrations

---

## 🛡️ Security

### 1. **Authentication**
- Laravel Sanctum for API
- Session-based for web
- CSRF protection enabled

### 2. **File Upload**
- Size limits enforced
- File type validation
- Secure file storage

### 3. **Database**
- SQLite file permissions
- No direct SQL exposure
- Eloquent ORM protection

---

## 📞 Support & Contact

### Development Info
- **Framework**: Laravel 11.16.0
- **Database**: SQLite
- **License**: MIT

### Maintenance
- **Regular Backups**: Database + uploaded files
- **Updates**: Monitor Laravel security updates
- **Monitoring**: Check logs regularly

---

## 🚨 Troubleshooting

### Common Issues

**1. Blank Page**
```bash
# Check logs
tail storage/logs/laravel.log

# Clear cache
php artisan optimize:clear
```

**2. Database Errors**
```bash
# Check SQLite file
ls -la database/database.sqlite

# Verify permissions
chmod 664 database/database.sqlite
```

**3. Image Upload Issues**
```bash
# Check directory permissions
chmod -R 755 public/img/

# Verify storage link
php artisan storage:link
```

**4. 500 Server Error**
```bash
# Enable debug mode temporarily
APP_DEBUG=true in .env

# Check server error logs
tail /var/log/apache2/error.log
```

---

## 📈 Performance Optimization

### 1. **Caching**
```bash
# Enable config cache
php artisan config:cache

# Enable route cache  
php artisan route:cache

# Enable view cache
php artisan view:cache
```

### 2. **Database**
- Regular VACUUM for SQLite
- Index optimization
- Query optimization

### 3. **Assets**
- Image compression
- CSS/JS minification
- CDN for static assets

---

*Dokumentasi ini mencakup semua aspek website desa. Untuk pertanyaan teknis atau bantuan deployment, silakan konsultasi dengan tim pengembang.*
