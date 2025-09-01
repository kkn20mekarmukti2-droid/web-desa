# 🚀 APBDes Quick Deploy Commands for cPanel

## 🔥 SUPER QUICK DEPLOYMENT (1 MENIT)

### **Method 1: Git Pull (jika akses terminal)**
```bash
cd public_html
git pull origin main
php artisan migrate --force
php artisan storage:link
php artisan optimize:clear
chmod -R 755 storage/ bootstrap/cache/
```

### **Method 2: Manual Upload (File Manager)**
**Upload files ini via cPanel File Manager:**
```
✅ WAJIB UPLOAD:
├── app/Http/Controllers/ApbdesController.php          [NEW]
├── app/Models/Apbdes.php                             [NEW]  
├── database/migrations/2025_09_01_000000_create_apbdes_table.php [NEW]
├── resources/views/transparansi-anggaran.blade.php   [NEW]
├── resources/views/admin/apbdes/                     [NEW FOLDER]
│   ├── index.blade.php
│   ├── create.blade.php
│   └── edit.blade.php
├── resources/views/layout/app.blade.php              [UPDATED]
├── resources/views/layout/admin-modern.blade.php     [UPDATED]  
└── routes/web.php                                    [UPDATED]
```

---

## ⚡ SPEED RUN CHECKLIST

### **✅ Step 1: Database (30 detik)**
**phpMyAdmin → SQL → Paste & Run:**
```sql
CREATE TABLE `apbdes` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `image_path` varchar(500) NOT NULL,
  `description` text DEFAULT NULL,
  `tahun` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

### **✅ Step 2: Storage (15 detik)**
**File Manager → Create Folders:**
```
public/storage/            (if not exist)
storage/app/public/apbdes/ (create this)
```

### **✅ Step 3: Permissions (15 detik)**
**Right-click → Change Permissions → 755:**
- `storage/`
- `storage/app/`  
- `storage/app/public/`
- `public/storage/`

---

## 🧪 INSTANT TESTING

### **Test 1: Frontend (5 detik)**
```
https://yourdomain.com/transparansi-anggaran
Expected: Halaman transparansi load (meski kosong)
```

### **Test 2: Admin (10 detik)**  
```
https://yourdomain.com/admin/apbdes
Expected: Admin interface APBDes load
```

### **Test 3: Upload (30 detik)**
```
Login admin → APBDes → Tambah APBDes → Upload test image
Expected: Image upload & display success
```

---

## 🔧 ONE-LINER COMMANDS

### **Clear All Caches:**
```bash
php artisan config:clear && php artisan route:clear && php artisan view:clear && php artisan cache:clear
```

### **Reset Permissions:**
```bash  
chmod -R 755 storage/ && chmod -R 755 bootstrap/cache/ && chmod -R 755 public/storage/
```

### **Test Routes:**
```bash
php artisan route:list --name=apbdes && php artisan route:list --name=transparansi
```

### **Database Quick Test:**
```bash
php artisan tinker --execute="echo 'APBDes Model: ' . (class_exists('App\Models\Apbdes') ? 'OK' : 'ERROR');"
```

---

## 🚨 EMERGENCY FIXES

### **Route Not Found:**
```bash
php artisan route:clear
php artisan config:clear  
# OR manual: delete bootstrap/cache/routes*.php
```

### **Image Upload Error:**
```bash
chmod 777 storage/app/public/
chmod 777 public/storage/
# Check: ls -la public/ | grep storage
```

### **Database Connection:**
```bash  
# Check .env file:
DB_CONNECTION=mysql
DB_HOST=localhost
DB_DATABASE=your_db_name
DB_USERNAME=your_db_user  
DB_PASSWORD=your_db_pass
```

### **Storage Link Missing:**
```bash
# Via terminal:
php artisan storage:link

# OR manual symbolic link:
# Target: ../storage/app/public
# Link name: storage (in public folder)
```

---

## 📱 MOBILE TEST COMMANDS

```bash
# Test responsive navigation:
curl -A "Mobile" https://yourdomain.com/transparansi-anggaran

# Check mobile menu rendering:
curl https://yourdomain.com/ | grep "transparansi-anggaran"
```

---

## 🎯 SUCCESS INDICATORS

### **✅ ALL GREEN MEANS SUCCESS:**
- ✅ `https://domain.com/transparansi-anggaran` → loads
- ✅ `https://domain.com/admin/apbdes` → admin interface  
- ✅ Navigation menu shows "Transparansi Anggaran"
- ✅ Admin sidebar shows "APBDes"
- ✅ Image upload works
- ✅ Public page displays uploaded images
- ✅ Mobile responsive works

---

## ⏱️ TOTAL TIME ESTIMATE

| Method | Time Needed |
|--------|-------------|
| **Git Pull** | 2-3 minutes |
| **Manual Upload** | 5-8 minutes |  
| **Database Setup** | 1 minute |
| **Testing** | 2 minutes |
| **🎯 TOTAL** | **10-15 minutes max** |

---

## 🎉 POST-DEPLOYMENT CELEBRATION

```bash
echo "🏛️ APBDes Transparency System DEPLOYED!"
echo "🎯 Village budget transparency is now LIVE!"
echo "👥 Community can now access financial information!"
echo "🚀 Admin can manage APBDes documents easily!"
echo ""
echo "📊 System Stats:"
php artisan tinker --execute="
echo '📄 APBDes Records: ' . App\Models\Apbdes::count();
echo '✅ Active Documents: ' . App\Models\Apbdes::where('is_active', true)->count();
echo '📅 Latest Year: ' . (App\Models\Apbdes::max('tahun') ?? 'None');
"
```

**🎊 SELAMAT! APBDes System siap melayani transparansi anggaran desa! 🎊**
