# 🚀 Panduan Deployment APBDes System ke cPanel

## 📋 Prerequisites
- **cPanel hosting** dengan akses File Manager
- **MySQL database** yang sudah terkonfigurasi
- **PHP 8.1+** enabled di hosting
- **Composer** access (via terminal atau local)

---

## 🔥 LANGKAH DEPLOYMENT CEPAT

### **Step 1: Update Files di cPanel**

#### **A. Via File Manager cPanel:**
1. Login ke **cPanel** → **File Manager**
2. Navigate ke folder **public_html** (atau domain folder)
3. Upload/Replace files yang baru:

```bash
# Files yang perlu diupload/update:
- app/Http/Controllers/ApbdesController.php          [NEW]
- app/Models/Apbdes.php                             [NEW]
- database/migrations/2025_09_01_000000_create_apbdes_table.php  [NEW]
- resources/views/transparansi-anggaran.blade.php   [NEW]
- resources/views/admin/apbdes/                     [NEW FOLDER]
- resources/views/layout/app.blade.php              [UPDATED]
- resources/views/layout/admin-modern.blade.php     [UPDATED]
- routes/web.php                                    [UPDATED]
```

#### **B. Via Git (jika tersedia):**
```bash
cd public_html
git pull origin main
```

---

### **Step 2: Database Migration**

#### **A. Via Terminal cPanel (jika tersedia):**
```bash
cd public_html
php artisan migrate
```

#### **B. Via phpMyAdmin (manual):**
1. Login ke **cPanel** → **phpMyAdmin**
2. Pilih database website
3. Jalankan SQL berikut:

```sql
CREATE TABLE `apbdes` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_path` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tahun` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

### **Step 3: Storage Setup**

#### **A. Via Terminal (jika tersedia):**
```bash
cd public_html
php artisan storage:link
```

#### **B. Manual Setup:**
1. Buat folder: **public/storage** (jika belum ada)
2. Via File Manager cPanel → **public** folder
3. Create **Symbolic Link** atau copy struktur:
   - Dari: `storage/app/public/`  
   - Ke: `public/storage/`

---

### **Step 4: File Permissions**

Set permissions yang benar:
```bash
# Via cPanel File Manager, klik kanan → Change Permissions:
storage/                    -> 755
storage/app/                -> 755  
storage/app/public/         -> 755
storage/framework/          -> 755
storage/logs/               -> 755
bootstrap/cache/            -> 755
public/storage/             -> 755
```

---

## ✅ **VERIFICATION CHECKLIST**

### **🔍 Test Frontend:**
- [ ] Buka: `https://yourdomain.com/transparansi-anggaran`
- [ ] Check: Halaman transparansi load tanpa error
- [ ] Test: Navigation menu "Informasi Desa" → "Transparansi Anggaran"

### **🔍 Test Admin:**
- [ ] Login: `https://yourdomain.com/admin/login`
- [ ] Check: Menu "APBDes" muncul di sidebar
- [ ] Test: `https://yourdomain.com/admin/apbdes`
- [ ] Test: Create new APBDes document
- [ ] Test: Image upload functionality

---

## 🚨 **TROUBLESHOOTING**

### **Problem: 404 Route not found**
```bash
# Solution 1: Clear cache
php artisan route:clear
php artisan config:clear
php artisan cache:clear

# Solution 2: Check .htaccess
# Pastikan .htaccess ada di public folder
```

### **Problem: Storage link error**
```bash
# Solution: Manual link
# Di File Manager, buat symbolic link:
# Target: ../storage/app/public
# Link name: storage (dalam folder public)
```

### **Problem: Image upload failed**
```bash
# Check folder permissions:
storage/app/public/         -> 755 atau 777
public/storage/             -> 755 atau 777

# Check PHP settings:
upload_max_filesize = 10M
post_max_size = 10M
```

### **Problem: Database connection error**
```bash
# Check .env file:
DB_CONNECTION=mysql
DB_HOST=localhost  # atau IP hosting
DB_PORT=3306
DB_DATABASE=your_db_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_pass
```

---

## 📱 **QUICK TEST SCRIPT**

Buat file `test-apbdes.php` di root untuk quick test:
```php
<?php
// Test database connection & table
try {
    $pdo = new PDO("mysql:host=localhost;dbname=your_db", "username", "password");
    $stmt = $pdo->query("SELECT COUNT(*) FROM apbdes");
    echo "✅ Database connection: OK\n";
    echo "✅ APBDes table: EXISTS\n";
    echo "📊 Records: " . $stmt->fetchColumn() . "\n";
} catch(PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

// Test storage directory
if (is_dir('storage/app/public')) {
    echo "✅ Storage directory: EXISTS\n";
} else {
    echo "❌ Storage directory: NOT FOUND\n";
}

// Test public storage link
if (is_link('public/storage') || is_dir('public/storage')) {
    echo "✅ Public storage link: OK\n";
} else {
    echo "❌ Public storage link: NOT FOUND\n";
}
?>
```

---

## 🎯 **POST-DEPLOYMENT CHECKLIST**

1. **✅ Test upload APBDes** via admin panel
2. **✅ Verify image display** di halaman public
3. **✅ Test responsive design** pada mobile
4. **✅ Check all navigation links** working
5. **✅ Test modal zoom functionality**
6. **✅ Verify download buttons** working
7. **✅ Test toggle active/inactive** status
8. **✅ Check admin statistics** displaying correctly

---

## 📞 **SUPPORT COMMANDS**

Jika ada akses terminal cPanel:
```bash
# Check Laravel version
php artisan --version

# List all routes
php artisan route:list

# Check APBDes routes specifically
php artisan route:list --name=apbdes

# Clear all caches
php artisan optimize:clear

# Re-run migration (if needed)
php artisan migrate:fresh

# Check storage link
ls -la public/ | grep storage
```

---

## 🎉 **DEPLOYMENT BERHASIL!**

Setelah semua langkah selesai, sistem APBDes sudah bisa digunakan:

**👨‍💼 Admin dapat:**
- Upload gambar APBDes via `/admin/apbdes`
- Kelola dokumen transparansi anggaran
- Toggle status publikasi
- Edit/hapus dokumen existing

**👥 Masyarakat dapat:**
- Akses transparansi anggaran via menu "Informasi Desa"
- Lihat gambar APBDes yang dipublish
- Download dokumen anggaran
- View dengan responsive design

**🔧 Developer dapat:**
- Monitor melalui admin dashboard
- Kelola permissions dan settings
- Backup dan maintain system

---

**🚀 Happy Deployment!** Sistem APBDes transparansi anggaran siap melayani masyarakat desa! 🎯✨
