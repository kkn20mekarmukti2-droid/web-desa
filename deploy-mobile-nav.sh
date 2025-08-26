#!/bin/bash

echo "🚀 Deploying Mobile Slide-in Drawer Navigation to cPanel..."
echo "============================================================"

# Change to project directory
cd /home/mekh7277/web-desa

# Show current status
echo "📋 Current Git Status:"
git status

# Pull latest changes from main branch
echo "📥 Pulling latest changes..."
git pull origin main

# Clear all Laravel caches
echo "🧹 Clearing Laravel caches..."
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear

# Optimize for production
echo "⚡ Optimizing for production..."
php artisan config:cache
php artisan route:cache

# Check if mobile navigation file exists
echo "📱 Checking mobile navigation implementation..."
if grep -q "mobileMenuPanel" resources/views/layout/app.blade.php; then
    echo "✅ Mobile slide-in drawer found in layout file"
else
    echo "❌ Mobile slide-in drawer NOT found - deployment may have failed"
fi

# Show final status
echo "📊 Final Status:"
git log --oneline -n 3

echo "🎉 Deployment Complete!"
echo "🔗 Test at: https://desa-mekarmukti.com"
echo "📱 Test mobile navigation with browser dev tools (≤991px width)"
