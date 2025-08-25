#!/bin/bash
# =====================================================
# MAIN DEPLOYMENT SCRIPT UNTUK CPANEL
# Deploy dari GitHub ke /home/mekh7277/web-desa
# =====================================================

set -e  # Exit on any error

echo "🚀 Starting cPanel Deployment..."
echo "=================================="

# Step 1: Pre-deployment backup
echo "💾 Step 1: Creating backup..."
BACKUP_DIR="/home/mekh7277/web-desa-backup-$(date +%Y%m%d-%H%M%S)"
cp -r /home/mekh7277/web-desa "$BACKUP_DIR"
echo "✅ Backup created: $BACKUP_DIR"

# Step 2: Navigate to project directory
echo ""
echo "📁 Step 2: Navigate to project directory..."
cd /home/mekh7277/web-desa
echo "✅ Current directory: $(pwd)"

# Step 3: Stash local changes (if any)
echo ""
echo "📦 Step 3: Stashing local changes..."
git add .
git stash push -m "Local changes before deployment $(date)"
echo "✅ Local changes stashed"

# Step 4: Fetch latest changes
echo ""
echo "📥 Step 4: Fetching from GitHub..."
git fetch origin main
echo "✅ Fetch completed"

# Step 5: Show what will be updated
echo ""
echo "📋 Step 5: Changes to be pulled:"
git log --oneline HEAD..origin/main

# Step 6: Pull changes
echo ""
echo "⬇️  Step 6: Pulling changes from GitHub..."
git pull origin main
echo "✅ Pull completed"

# Step 7: Check if composer.json changed
if git diff HEAD~1 HEAD --name-only | grep -q "composer.json"; then
    echo ""
    echo "📦 Step 7a: Composer dependencies updated, installing..."
    composer install --optimize-autoloader --no-dev
    echo "✅ Composer install completed"
else
    echo ""
    echo "⏭️  Step 7a: No composer changes, skipping..."
fi

# Step 8: Check if package.json changed  
if git diff HEAD~1 HEAD --name-only | grep -q "package.json"; then
    echo ""
    echo "🏗️  Step 7b: NPM dependencies updated..."
    echo "💡 Note: Run 'npm install && npm run build' manually if needed"
else
    echo ""
    echo "⏭️  Step 7b: No NPM changes, skipping..."
fi

# Step 9: Clear all caches
echo ""
echo "🧹 Step 8: Clearing application caches..."
php artisan config:clear
php artisan cache:clear  
php artisan view:clear
php artisan route:clear
echo "✅ Caches cleared"

# Step 10: Rebuild optimized caches
echo ""
echo "⚡ Step 9: Rebuilding optimized caches..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
echo "✅ Optimized caches built"

# Step 11: Database migrations (check only)
echo ""
echo "🗄️  Step 10: Checking database migrations..."
if php artisan migrate:status | grep -q "Pending"; then
    echo "⚠️  New migrations found!"
    echo "💡 Run manually: php artisan migrate"
else
    echo "✅ Database up to date"
fi

# Step 12: Set proper permissions
echo ""
echo "🔐 Step 11: Setting file permissions..."
chmod -R 755 storage
chmod -R 755 bootstrap/cache  
chmod 644 .env
echo "✅ Permissions set"

# Step 13: Update storage link
echo ""
echo "🔗 Step 12: Updating storage link..."
php artisan storage:link
echo "✅ Storage link updated"

# Step 14: Test admin credentials
echo ""
echo "👤 Step 13: Testing admin access..."
ADMIN_EMAIL=$(php artisan tinker --execute="echo App\Models\User::find(1)->email;")
echo "✅ Admin email: $ADMIN_EMAIL"
echo "💡 Use password: admin123 (or reset with: php artisan admin:reset-password)"

# Step 15: Final verification
echo ""
echo "🧪 Step 14: Final verification..."
php artisan --version
echo "✅ Laravel application working"

echo ""
echo "🎉 DEPLOYMENT COMPLETED SUCCESSFULLY!"
echo "====================================="
echo "📍 Project location: /home/mekh7277/web-desa"
echo "💾 Backup location: $BACKUP_DIR"
echo "🌐 Website should be live now!"
echo ""
echo "🔧 Post-deployment tasks:"
echo "  1. Test website functionality"
echo "  2. Test admin login: admin@webdesa.com / admin123"
echo "  3. Run migrations if needed: php artisan migrate"
echo "  4. Build assets if needed: npm run build"
echo ""
echo "🚨 If anything goes wrong:"
echo "  - Restore backup: cp -r $BACKUP_DIR/* /home/mekh7277/web-desa/"
echo "  - Check logs: tail -f /home/mekh7277/logs/error_log"
