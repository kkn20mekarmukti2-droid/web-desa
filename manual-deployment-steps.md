# =====================================================
# MANUAL DEPLOYMENT STEPS UNTUK CPANEL EXISTING
# Jalankan satu per satu di cPanel Terminal/SSH
# =====================================================

# 1. BACKUP EXISTING PROJECT (PENTING!)
cd /home/mekh7277/
cp -r web-desa web-desa-backup-$(date +%Y%m%d-%H%M%S)
echo "✅ Backup created"

# 2. MASUK KE DIREKTORI PROJECT
cd /home/mekh7277/web-desa

# 3. CHECK GIT STATUS
ls -la
# Jika tidak ada .git folder, initialize:
# git init
# git remote add origin https://github.com/kkn20mekarmukti2-droid/web-desa.git

# 4. BACKUP LOCAL CHANGES (jika ada)
# Backup files yang mungkin berbeda:
cp .env .env.local-backup
cp -r public/img public/img-backup
cp -r storage/app storage/app-backup

# 5. FETCH & PULL FROM GITHUB
git fetch origin
git status
# Jika ada local changes yang conflict:
# git stash
git pull origin main

# 6. HANDLE CONFLICTS (jika ada)
# Jika ada merge conflicts:
# git status
# Edit files yang conflict
# git add .
# git commit -m "Resolve merge conflicts"

# 7. RESTORE IMPORTANT LOCAL FILES
# Copy back important local files:
cp .env.local-backup .env
cp -r public/img-backup/* public/img/
# (Sesuaikan dengan files yang perlu dipertahankan)

# 8. UPDATE DEPENDENCIES
composer install --optimize-autoloader --no-dev

# 9. CLEAR CACHES
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# 10. REBUILD CACHES
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 11. CHECK DATABASE MIGRATIONS
php artisan migrate:status
# Jika ada migration baru:
# php artisan migrate

# 12. FIX PERMISSIONS
chmod -R 755 storage
chmod -R 755 bootstrap/cache

# 13. TEST WEBSITE
# Buka website di browser dan test semua fitur

echo "🎉 Deployment selesai!"
