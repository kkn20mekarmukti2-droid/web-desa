# 🔧 APBDes Production Troubleshooting - Quick Commands for cPanel

## 🚨 PROBLEM: APBDes tidak muncul di halaman transparansi

### 📋 **QUICK DIAGNOSIS (jalankan di cPanel terminal atau via SSH):**

```bash
# 1. Clear semua cache
php artisan config:clear && php artisan route:clear && php artisan view:clear && php artisan cache:clear

# 2. Check database data
php artisan tinker --execute="echo 'Total: ' . App\Models\Apbdes::count() . '\nActive: ' . App\Models\Apbdes::where('is_active', true)->count();"

# 3. Create storage link (jika belum ada)
php artisan storage:link

# 4. Set permissions
chmod -R 755 storage/ && chmod -R 755 public/storage/
```

---

## 🔍 **COMMON ISSUES & SOLUTIONS:**

### **Issue 1: No Data in Database**
```sql
-- Check via phpMyAdmin:
SELECT COUNT(*) as total FROM apbdes;
SELECT COUNT(*) as active FROM apbdes WHERE is_active = 1;

-- If empty: Add data via admin panel /admin/apbdes
```

### **Issue 2: Data Exists but is_active = 0**
```sql
-- Via phpMyAdmin, activate records:
UPDATE apbdes SET is_active = 1 WHERE id IN (1,2,3);
-- (Replace 1,2,3 with actual record IDs)
```

### **Issue 3: Storage Link Missing**
```bash
# Via terminal:
php artisan storage:link

# OR create manual symbolic link:
# Target: ../storage/app/public  
# Link name: storage (dalam folder public)
```

### **Issue 4: Images Not Showing**
```bash
# Check if images exist:
ls -la storage/app/public/apbdes/

# Check if public link works:
ls -la public/storage/

# Fix permissions:
chmod -R 755 storage/app/public/
chmod -R 755 public/storage/
```

---

## ⚡ **SUPER QUICK FIX (1 command):**

```bash
# Run this single command to fix most issues:
php artisan config:clear && php artisan route:clear && php artisan view:clear && php artisan storage:link && chmod -R 755 storage/ && php artisan config:cache
```

---

## 🧪 **TESTING CHECKLIST:**

### **1. Database Test:**
- [ ] Login phpMyAdmin
- [ ] Check `apbdes` table has data  
- [ ] Verify `is_active = 1` for records
- [ ] Check `image_path` field not empty

### **2. File System Test:**
- [ ] `storage/app/public/apbdes/` folder exists
- [ ] Image files exist in APBDes folder
- [ ] `public/storage/` link exists
- [ ] Permissions 755 on storage folders

### **3. Application Test:**
- [ ] `/admin/apbdes` → Admin panel loads
- [ ] Data visible in admin interface
- [ ] Records marked as "Aktif" (green toggle)
- [ ] `/transparansi-anggaran` → Public page loads
- [ ] Images display correctly

---

## 🔧 **MANUAL DEBUG (via browser):**

### **Upload debug script ke public folder:**
```php
<?php
// Put this in: public/debug-quick.php
try {
    require_once '../bootstrap/app.php';
    $app = require_once '../bootstrap/app.php';
    $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
    
    echo "<h2>APBDes Quick Debug</h2>";
    
    // Check data
    $total = DB::table('apbdes')->count();
    $active = DB::table('apbdes')->where('is_active', 1)->count();
    
    echo "Total Records: $total<br>";
    echo "Active Records: $active<br>";
    
    if ($active > 0) {
        echo "<h3>Active Records:</h3>";
        $records = DB::table('apbdes')->where('is_active', 1)->get();
        foreach ($records as $r) {
            $img = file_exists("storage/{$r->image_path}") ? "✅" : "❌";
            echo "- {$r->title} ({$r->tahun}) Image: $img<br>";
        }
    }
    
    // Test model
    echo "<h3>Model Test:</h3>";
    $modelTest = App\Models\Apbdes::getActive();
    echo "getActive() returns: " . count($modelTest) . " records<br>";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
```
**Then access:** `https://mekarmukti.id/debug-quick.php`

---

## 📱 **MOBILE TESTING:**

```bash
# Test responsiveness:
curl -A "Mobile" https://mekarmukti.id/transparansi-anggaran
curl https://mekarmukti.id/transparansi-anggaran | grep -i "apbdes\|transparansi"
```

---

## 🚨 **EMERGENCY SOLUTIONS:**

### **If Nothing Works - Force Reset:**
```bash
# CAUTION: This will reset APBDes data!
php artisan migrate:fresh --path=database/migrations/2025_09_01_000000_create_apbdes_table.php
```

### **If Route Still Not Working:**
```bash
# Check .htaccess in public folder
cat public/.htaccess | grep "RewriteEngine"

# Regenerate key (if needed)
php artisan key:generate
```

---

## 🎯 **MOST LIKELY FIXES:**

| Issue | Probability | Quick Fix |
|-------|-------------|-----------|
| **Cache Problem** | 70% | `php artisan optimize:clear` |
| **No Active Data** | 60% | Set `is_active=1` in database |
| **Storage Link** | 40% | `php artisan storage:link` |
| **Permissions** | 30% | `chmod -R 755 storage/` |
| **Route Cache** | 20% | `php artisan route:clear` |

---

## 📞 **SUPPORT COMMANDS:**

```bash
# Get system info:
php artisan --version && php --version

# Check Laravel environment:
php artisan env

# List all routes:
php artisan route:list | grep transparansi

# Check logs:
tail -50 storage/logs/laravel.log
```

---

**🎉 After running fixes, test: `https://mekarmukti.id/transparansi-anggaran`**

**Most common issue: Data exists in admin but `is_active=0`. Solution: Toggle to "Aktif" in admin panel!**
