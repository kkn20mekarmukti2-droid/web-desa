#!/bin/bash

echo "🚨 EMERGENCY DEPLOYMENT - GIT PULL FATAL ERROR"
echo "==============================================="

# Backup current files first
echo "📋 Step 1: Backup current files"
echo "cp resources/views/layout/app.blade.php resources/views/layout/app.blade.php.backup"
echo ""

# Method 1: Force Git Reset
echo "🔄 Method 1: Force Git Reset"
echo "git fetch origin"
echo "git reset --hard origin/main"
echo "git clean -fd"
echo ""

# Method 2: Manual file replacement (if git fails completely)
echo "📁 Method 2: Manual File Upload via cPanel File Manager"
echo "1. Login to cPanel File Manager"
echo "2. Navigate to /home/mekh7277/web-desa/resources/views/layout/"
echo "3. Upload new app.blade.php file"
echo "4. Replace existing file"
echo ""

# Method 3: Direct file overwrite via SSH
echo "💾 Method 3: Direct file overwrite (if you have SSH access)"
echo "Use scp or rsync to upload file directly:"
echo "scp app.blade.php mekh7277@desa-mekarmukti.com:/home/mekh7277/web-desa/resources/views/layout/"
echo ""

# Clear caches after any method
echo "🧹 Final Step: Clear All Caches"
echo "php artisan cache:clear"
echo "php artisan config:clear"
echo "php artisan view:clear"
echo "php artisan route:clear"
echo ""

echo "✅ VERIFICATION COMMANDS:"
echo "grep -n 'mobileMenuPanel' resources/views/layout/app.blade.php"
echo "grep -n 'openMobileMenu' resources/views/layout/app.blade.php"
echo ""

echo "🌐 TEST URL: https://desa-mekarmukti.com"
echo "📱 Mobile test: Browser dev tools, width ≤ 991px"
