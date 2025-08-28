# 📊 DEPLOYMENT GUIDE - Sistem Statistik Admin ke cPanel

## 🎯 **Overview**
Panduan lengkap untuk deploy sistem admin CRUD statistik dengan 3 chart interaktif dan cards RT/RW/KK ke cPanel hosting.

---

## 📦 **Fitur yang akan di-Deploy**

### ✅ **Sistem Admin CRUD Statistik**
- **Admin Interface**: `/admin/statistik`
- **Create, Read, Update, Delete** untuk semua kategori data
- **11 Kategori**: jenis_kelamin, agama, pekerjaan, pendidikan, kesehatan, siswa, klub, kesenian, sumberair, kk, rt_rw

### ✅ **Halaman Data Statistik Modern** 
- **URL**: `/data/statistik`
- **3 Chart Interaktif**: Jenis Kelamin, Agama, Pekerjaan
- **RT/RW/KK Cards**: Visual cards dengan gradient yang menarik
- **Auto-refresh**: Setiap 5 menit
- **Responsive Design**: Bootstrap 5 + Chart.js 4.4.0

---

## 🚀 **LANGKAH DEPLOYMENT**

### **STEP 1: Backup Current Site**
```bash
# Di cPanel File Manager, buat backup folder
cp -r public_html public_html_backup_$(date +%Y%m%d)
```

### **STEP 2: Upload Files via Git**
```bash
# Di terminal cPanel atau SSH
cd public_html
git clone https://github.com/kkn20mekarmukti2-droid/web-desa.git temp_deploy
cp -r temp_deploy/* .
rm -rf temp_deploy
```

### **STEP 3: Setup Composer**
```bash
# Install/Update Composer dependencies
composer install --optimize-autoloader --no-dev
composer dump-autoload
```

### **STEP 4: Database Setup**
```bash
# Run migration untuk tabel statistik
php artisan migrate

# Seeding data sample
php artisan db:seed --class=StatistikSeeder
```

### **STEP 5: Laravel Configuration**
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Setup cache dan config
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### **STEP 6: File Permissions**
```bash
# Set proper permissions
chmod -R 755 storage
chmod -R 755 bootstrap/cache
find storage -type f -exec chmod 644 {} \;
find bootstrap/cache -type f -exec chmod 644 {} \;
```

### **STEP 7: Database Configuration**
Edit `.env` file:
```env
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_db_username
DB_PASSWORD=your_db_password
```

---

## 🗂️ **Files yang Penting untuk Di-Deploy**

### **📁 Database & Models**
- `database/migrations/2025_08_28_112020_create_statistik_table.php`
- `app/Models/StatistikModel.php`
- `database/seeders/StatistikSeeder.php`

### **📁 Controllers**
- `app/Http/Controllers/StatistikController.php`
- `app/Http/Controllers/dataController.php`

### **📁 Views**
- `resources/views/admin/statistik/` (folder lengkap)
- `resources/views/data-statistik-baru.blade.php`

### **📁 Routes**
- `routes/web.php` (route admin/statistik dan data/statistik)

---

## 🔧 **TROUBLESHOOTING**

### **❌ Problem: Charts Tidak Muncul**
```bash
# Solution:
php artisan route:clear
php artisan config:clear
# Cek di browser developer tools untuk error JavaScript
```

### **❌ Problem: Database Error**
```bash
# Solution:
php artisan migrate:status
php artisan migrate
php artisan db:seed --class=StatistikSeeder
```

### **❌ Problem: 500 Internal Server Error**
```bash
# Solution:
chmod -R 755 storage
php artisan storage:link
php artisan config:clear
# Cek error logs di cPanel
```

### **❌ Problem: Admin Interface Tidak Bisa Diakses**
```bash
# Solution:
# Cek route admin ada di web.php
php artisan route:list | grep statistik
```

---

## 🎨 **Features Overview Setelah Deploy**

### **📊 Admin Panel (`/admin/statistik`)**
- ✅ Table listing semua data statistik
- ✅ Form create data baru dengan dropdown kategori
- ✅ Edit inline dengan modal
- ✅ Delete confirmation
- ✅ Search dan pagination
- ✅ Responsive admin interface

### **📈 Public Dashboard (`/data/statistik`)**
- ✅ Hero section dengan total penduduk
- ✅ Statistics cards (Laki-laki, Perempuan, Total Pekerja)
- ✅ **RT/RW/KK Cards Section** dengan gradient design
- ✅ 3 Interactive charts (Chart.js doughnut)
- ✅ Detail RT dan RW breakdown cards
- ✅ Auto-refresh every 5 minutes

---

## ⚡ **Quick Deploy Script**

Buat file `quick-deploy-statistik.sh`:
```bash
#!/bin/bash
echo "🚀 Deploying Statistik Admin System..."

# Backup
cp -r public_html public_html_backup_$(date +%Y%m%d)

# Deploy files
git pull origin main
composer install --optimize-autoloader --no-dev

# Database
php artisan migrate
php artisan db:seed --class=StatistikSeeder

# Laravel optimization
php artisan config:clear
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Permissions
chmod -R 755 storage bootstrap/cache

echo "✅ Deployment Complete!"
echo "🌐 Admin: yourdomain.com/admin/statistik"
echo "📊 Public: yourdomain.com/data/statistik"
```

---

## 🔐 **Security Notes**
- ✅ Admin routes protected dengan middleware
- ✅ CSRF protection aktif
- ✅ Input validation pada semua forms
- ✅ File permissions set dengan benar
- ✅ Environment variables untuk sensitive data

---

## 📞 **Support**
Jika ada masalah deployment:
1. Cek error logs di cPanel
2. Verify database connection
3. Test dengan `php artisan tinker`
4. Cek JavaScript console untuk chart errors

**Happy Deploying! 🎉**
