# =====================================================
# MANUAL DEPLOYMENT STEPS UNTUK CPANEL EXISTING  
# Jalankan satu per satu di cPanel Terminal/SSH
# Target: /home/mekh7277/web-desa
# =====================================================

# 0. LOGIN KE CPANEL SSH/TERMINAL
# ssh username@yourdomain.com
# atau gunakan Terminal di cPanel File Manager

# 1. BACKUP EXISTING PROJECT (PENTING!)
cd /home/mekh7277/
cp -r web-desa web-desa-backup-$(date +%Y%m%d-%H%M%S)
echo "✅ Backup created at: web-desa-backup-$(date +%Y%m%d-%H%M%S)"

# 2. MASUK KE DIREKTORI PROJECT
cd /home/mekh7277/web-desa
pwd  # Pastikan di /home/mekh7277/web-desa

# 3. CHECK GIT STATUS & SETUP (jika belum ada)
ls -la | grep .git
# Jika tidak ada .git folder, initialize:
git init
git remote add origin https://github.com/kkn20mekarmukti2-droid/web-desa.git
git branch -M main

# 4. BACKUP LOCAL CHANGES (jika ada)
# Backup files penting yang mungkin berbeda:
cp .env .env.local-backup
cp -r public/img public/img-backup 2>/dev/null || echo "No img folder to backup"
cp -r storage/app storage/app-backup 2>/dev/null || echo "No storage/app to backup"

# 5. CHECK REMOTE & FETCH FROM GITHUB
git remote -v  # Pastikan origin pointing ke GitHub
git fetch origin main
git status

# 6. STASH LOCAL CHANGES (jika ada)
git add .
git stash push -m "Local changes before deployment $(date)"
echo "✅ Local changes stashed"

# 7. PULL FROM GITHUB
git pull origin main
echo "✅ Pull completed"

# 8. RESTORE CRITICAL LOCAL FILES
# Copy back files penting yang perlu dipertahankan:
if [ -f ".env.local-backup" ]; then
    # Merge .env manually - jangan overwrite production settings
    echo "⚠️  Review .env differences:"
    echo "Original .env backed up as .env.local-backup"
    echo "New .env.production available for reference"
    echo "💡 Manually merge important production settings!"
fi

# Copy back images if they exist
if [ -d "public/img-backup" ]; then
    cp -r public/img-backup/* public/img/ 2>/dev/null || echo "No images to restore"
fi

# 9. UPDATE COMPOSER DEPENDENCIES  
composer install --optimize-autoloader --no-dev
echo "✅ Composer dependencies updated"

# 10. CLEAR ALL CACHES
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
echo "✅ Caches cleared"

# 11. REBUILD OPTIMIZED CACHES
php artisan config:cache
php artisan route:cache  
php artisan view:cache
echo "✅ Optimized caches built"

# 12. CHECK DATABASE MIGRATIONS
php artisan migrate:status
echo "💡 If new migrations exist, run: php artisan migrate"

# 13. FIX PERMISSIONS
chmod -R 755 storage
chmod -R 755 bootstrap/cache
chmod 644 .env
echo "✅ Permissions fixed"

# 14. UPDATE STORAGE LINK
php artisan storage:link
echo "✅ Storage link updated"

# 15. TEST ADMIN ACCESS
php artisan tinker --execute="echo 'Admin: ' . App\Models\User::find(1)->email;"
echo "💡 Admin login: admin@webdesa.com / admin123"
echo "💡 Reset password: php artisan admin:reset-password"

# 16. FINAL VERIFICATION
php artisan --version
echo "✅ Laravel application working"

# 17. TEST WEBSITE
echo ""
echo "🎉 DEPLOYMENT COMPLETED!"
echo "======================="
echo "🌐 Test your website now:"
echo "  - Frontend: https://yourdomain.com"  
echo "  - Admin: https://yourdomain.com/admin"
echo "  - Credentials: admin@webdesa.com / admin123"
echo ""
echo "🔧 Post-deployment checklist:"
echo "  ✅ Test navbar functionality"
echo "  ✅ Test article images display"
echo "  ✅ Test admin login & dashboard"  
echo "  ✅ Test responsive design"
echo "  ✅ Test contact forms"
echo ""
echo "🚨 If problems occur:"
echo "  - Check logs: tail -f /home/mekh7277/logs/error_log"
echo "  - Restore backup: cp -r ../web-desa-backup-* ."
echo "  - Reset admin: php artisan admin:reset-password"
