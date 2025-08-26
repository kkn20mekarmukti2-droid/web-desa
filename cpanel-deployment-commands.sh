#!/bin/bash

# =================================================================
# MOBILE SLIDE-IN DRAWER NAVIGATION - CPANEL DEPLOYMENT COMMANDS
# =================================================================

echo "🚀 DEPLOYING MOBILE NAVIGATION TO CPANEL..."
echo "=============================================="

# 1. SSH ke cPanel server
echo "📡 Step 1: SSH to cPanel"
echo "Command: ssh mekh7277@desa-mekarmukti.com"
echo ""

# 2. Navigate to project directory
echo "📁 Step 2: Navigate to project directory"
echo "cd /home/mekh7277/web-desa"
echo ""

# 3. Check current git status
echo "🔍 Step 3: Check git status"
echo "git status"
echo "git log --oneline -n 3"
echo ""

# 4. Pull latest changes
echo "📥 Step 4: Pull latest changes from GitHub"
echo "git pull origin main"
echo ""

# 5. Clear all Laravel caches
echo "🧹 Step 5: Clear Laravel caches"
echo "php artisan cache:clear"
echo "php artisan config:clear"
echo "php artisan view:clear"
echo "php artisan route:clear"
echo ""

# 6. Verify mobile navigation exists
echo "✅ Step 6: Verify mobile navigation implementation"
echo "grep -n 'mobileMenuPanel' resources/views/layout/app.blade.php"
echo "grep -n 'openMobileMenu' resources/views/layout/app.blade.php"
echo ""

# 7. Test endpoints
echo "🌐 Step 7: Test website"
echo "URL: https://desa-mekarmukti.com"
echo "📱 Test Mobile: Use browser dev tools, set width ≤ 991px"
echo ""

echo "🎯 EXPECTED BEHAVIOR:"
echo "- Hamburger icon (☰) visible on mobile"
echo "- Click hamburger → panel slides from right"
echo "- Panel width: 70% screen (max 320px)"
echo "- Dark background: #111827"
echo "- Orange accents: #F59E0B"
echo "- Click X or overlay → panel closes"
echo ""

echo "🔧 IF DEPLOYMENT FAILS:"
echo "git fetch origin"
echo "git reset --hard origin/main"
echo "php artisan cache:clear"
echo ""

echo "📞 CONTACT: KKN Team if issues persist"
