#!/bin/bash
# =====================================================
# SCRIPT DEPLOYMENT KE CPANEL EXISTING PROJECT
# Path: /home/mekh7277/web-desa
# =====================================================

echo "🚀 Starting deployment to existing cPanel project..."

# Step 1: Navigate to existing cPanel directory
cd /home/mekh7277/web-desa

# Step 2: Backup current state (safety first!)
echo "💾 Creating backup of current state..."
cp -r /home/mekh7277/web-desa /home/mekh7277/web-desa-backup-$(date +%Y%m%d-%H%M%S)

# Step 3: Check if git repository exists
if [ ! -d ".git" ]; then
    echo "📁 Initializing git repository..."
    git init
    git remote add origin https://github.com/kkn20mekarmukti2-droid/web-desa.git
fi

# Step 4: Stash any local changes (if any)
echo "📦 Stashing local changes..."
git stash push -m "Local changes before deployment $(date)"

# Step 5: Pull latest changes from GitHub
echo "📥 Pulling latest changes from GitHub..."
git fetch origin
git pull origin main

# Step 6: Handle merge conflicts (if any)
if [ $? -ne 0 ]; then
    echo "⚠️  Merge conflicts detected. Manual intervention required."
    echo "Run: git status"
    echo "Resolve conflicts, then: git add . && git commit"
    exit 1
fi

# Step 7: Update dependencies
echo "📦 Updating Composer dependencies..."
composer install --optimize-autoloader --no-dev

# Step 8: Update .env if needed (preserve existing)
if [ -f ".env.production" ]; then
    echo "⚙️  Backing up current .env..."
    cp .env .env.backup
    echo "💡 New .env.production available. Please review and update .env manually."
fi

# Step 9: Clear and rebuild caches
echo "🧹 Clearing application caches..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

echo "⚡ Rebuilding optimized caches..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Step 10: Run migrations (safely)
echo "🗄️  Checking for database migrations..."
php artisan migrate --dry-run
echo "💡 Run 'php artisan migrate' manually if new migrations are safe to apply."

# Step 11: Set proper permissions
echo "🔐 Setting proper file permissions..."
chmod -R 755 storage
chmod -R 755 bootstrap/cache
chmod 644 .env

# Step 12: Update storage link if needed
echo "🔗 Updating storage link..."
php artisan storage:link

echo "✅ Deployment completed successfully!"
echo "🌐 Your website at /home/mekh7277/web-desa has been updated!"
echo ""
echo "📋 Next steps:"
echo "1. Check your website functionality"
echo "2. Review .env.production if you need to update environment settings"
echo "3. Run 'php artisan migrate' if there are new database changes"
echo ""
echo "💾 Backup location: /home/mekh7277/web-desa-backup-$(date +%Y%m%d-%H%M%S)"
