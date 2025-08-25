#!/bin/bash
# =====================================================
# SAFE DEPLOYMENT USING GIT WORKTREE
# Untuk deployment yang lebih aman tanpa risiko conflict
# =====================================================

echo "🛡️  Safe deployment using Git worktree method..."

# Step 1: Create temporary deployment directory
cd /home/mekh7277/
mkdir -p temp-deployment
cd temp-deployment

# Step 2: Clone fresh copy from GitHub
echo "📥 Cloning fresh copy from GitHub..."
git clone https://github.com/kkn20mekarmukti2-droid/web-desa.git web-desa-new

# Step 3: Copy important existing files
echo "📋 Copying important existing files..."
cd web-desa-new

# Copy production .env
cp /home/mekh7277/web-desa/.env .env

# Copy uploaded images (if any new ones)
if [ -d "/home/mekh7277/web-desa/public/img" ]; then
    cp -r /home/mekh7277/web-desa/public/img/* public/img/
fi

# Copy any custom uploads
if [ -d "/home/mekh7277/web-desa/storage/app/public" ]; then
    cp -r /home/mekh7277/web-desa/storage/app/public/* storage/app/public/
fi

# Step 4: Install dependencies
echo "📦 Installing dependencies..."
composer install --optimize-autoloader --no-dev

# Step 5: Set up application
echo "⚙️  Setting up application..."
php artisan key:generate
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Step 6: Set permissions
chmod -R 755 storage
chmod -R 755 bootstrap/cache

# Step 7: Atomic swap (backup old, move new)
echo "🔄 Performing atomic swap..."
cd /home/mekh7277/

# Backup current
mv web-desa web-desa-old-$(date +%Y%m%d-%H%M%S)

# Move new version
mv temp-deployment/web-desa-new web-desa

# Step 8: Create storage link
cd web-desa
php artisan storage:link

# Step 9: Test
echo "🧪 Testing new deployment..."
php artisan --version

echo "✅ Safe deployment completed!"
echo "📁 Old version backed up to: web-desa-old-$(date +%Y%m%d-%H%M%S)"
echo "🌐 New version active at: /home/mekh7277/web-desa"

# Cleanup
rm -rf /home/mekh7277/temp-deployment
