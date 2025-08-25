#!/bin/bash

echo "🚀 Starting Laravel Deployment to cPanel..."

# Step 1: Navigate to repository directory
cd /path/to/your/laravel/app

# Step 2: Pull latest changes from GitHub
echo "📥 Pulling latest changes from GitHub..."
git pull origin main

# Step 3: Install/Update Composer dependencies (production optimized)
echo "📦 Installing Composer dependencies..."
composer install --optimize-autoloader --no-dev

# Step 4: Copy environment file for production
echo "⚙️ Setting up production environment..."
cp .env.production .env

# Step 5: Generate application key if needed
php artisan key:generate --force

# Step 6: Run database migrations
echo "🗄️ Running database migrations..."
php artisan migrate --force

# Step 7: Cache configuration for better performance
echo "⚡ Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Step 8: Create storage link
echo "🔗 Creating storage link..."
php artisan storage:link

# Step 9: Set proper permissions
echo "🔐 Setting file permissions..."
chmod -R 755 storage
chmod -R 755 bootstrap/cache

# Step 10: Copy public files to public_html
echo "📁 Copying public files..."
# This step depends on your cPanel structure
# Usually: cp -r public/* /home/username/public_html/

echo "✅ Deployment completed successfully!"
echo "🌐 Your website should now be live!"

# Optional: Clear old caches
php artisan cache:clear
php artisan config:clear

echo "🧹 Caches cleared!"
echo "🎉 Deployment finished!"
