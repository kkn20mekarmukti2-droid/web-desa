# 🧹 PANDUAN USER CLEANUP DI CPANEL

## ⚠️ PENTING - BACKUP DULU!
Sebelum cleanup, backup database production:
```bash
# Di cPanel File Manager atau Terminal
cd /home/mekh7277
mysqldump -u mekh7277_desa -p mekh7277_desa > backup_before_cleanup_$(date +%Y%m%d).sql
```

## 🚀 LANGKAH-LANGKAH CLEANUP

### STEP 1: Update Code di Production
```bash
# Masuk ke direktori web-desa di cPanel Terminal
cd /home/mekh7277/web-desa

# Pull update terbaru
git pull origin main

# Install/update dependencies jika perlu
composer install --no-dev --optimize-autoloader
```

### STEP 2: Cek Status Users Saat Ini
```bash
# Lihat semua users yang ada
php artisan tinker --execute="
\$users = App\Models\User::orderBy('id')->get();
echo 'Total users: ' . \$users->count() . PHP_EOL . PHP_EOL;
foreach(\$users as \$user) {
    \$articles = App\Models\artikelModel::where('user_id', \$user->id)->count();
    echo 'ID: ' . \$user->id . ' | ' . \$user->name . ' | ' . \$user->email . ' | Articles: ' . \$articles . PHP_EOL;
}
"
```

### STEP 3: Dry Run Analysis (RECOMMENDED FIRST!)
```bash
# Test dulu - tidak akan menghapus apapun
php artisan admin:cleanup-users --dry-run
```

## 🎯 PILIHAN CLEANUP METHODS

### Option A: Interactive Cleanup (Recommended)
```bash
php artisan admin:cleanup-users
```
- Pilih opsi sesuai kebutuhan
- Ada konfirmasi untuk setiap langkah
- Aman dengan validasi

### Option B: Shell Script (Simple)
```bash
bash user-cleanup.sh
```
- Menu interactive yang mudah
- Otomatis backup recommendations

### Option C: Quick Standard Admin
```bash
# Buat admin@webdesa.com dan migrasi semua artikel ke sana
php artisan tinker --execute="
\$admin = App\Models\User::firstOrCreate(
    ['email' => 'admin@webdesa.com'],
    [
        'name' => 'Admin Desa Mekarmukti',
        'password' => Hash::make('admin123'),
        'email_verified_at' => now()
    ]
);
echo 'Admin created: ' . \$admin->email . PHP_EOL;

\$migrated = App\Models\artikelModel::where('user_id', '!=', \$admin->id)->update(['user_id' => \$admin->id]);
echo 'Articles migrated: ' . \$migrated . PHP_EOL;

\$deleted = App\Models\User::where('id', '!=', \$admin->id)->delete();
echo 'Users deleted: ' . \$deleted . PHP_EOL;

echo 'LOGIN: admin@webdesa.com / admin123' . PHP_EOL;
"
```

## 🔍 VERIFIKASI SETELAH CLEANUP

```bash
# Cek hasil cleanup
php artisan tinker --execute="
echo 'Final user count: ' . App\Models\User::count() . PHP_EOL;
echo 'Total articles: ' . App\Models\artikelModel::count() . PHP_EOL;
\$users = App\Models\User::with('artikel')->get();
foreach(\$users as \$user) {
    echo \$user->email . ' - Articles: ' . \$user->artikel->count() . PHP_EOL;
}
"
```

## 🎯 REKOMENDASI STRATEGY

**Untuk Skenario Anda (6 users dengan duplikat):**
1. Gunakan **Option A (Interactive)** - paling aman
2. Pilih "Merge duplicates by name" untuk Rasyid Shiddiq
3. Atau pilih "Create standard admin" untuk standarisasi

**Hasil yang Diharapkan:**
- 1-2 admin users saja
- Semua artikel tetap aman
- Login credentials jelas dan terorganisir

## 🚨 EMERGENCY RESTORE
Jika ada masalah:
```bash
# Restore dari backup
mysql -u mekh7277_desa -p mekh7277_desa < backup_before_cleanup_YYYYMMDD.sql
```

## ✅ POST-CLEANUP CHECKLIST
- [ ] Login test dengan credentials baru
- [ ] Cek artikel masih tampil
- [ ] Test create/edit artikel
- [ ] Verifikasi admin panel berfungsi
- [ ] Update dokumentasi login credentials

---
**File ini:** `USER_CLEANUP_GUIDE.md`
**Created:** $(date)
**Repository:** kkn20mekarmukti2-droid/web-desa
