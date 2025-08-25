#!/bin/bash
# =====================================================
# PRE-DEPLOYMENT CHECKLIST UNTUK CPANEL
# Jalankan ini SEBELUM pull dari GitHub
# =====================================================

echo "🔍 PRE-DEPLOYMENT CHECKLIST"
echo "============================="

# 1. Check current location
echo "📍 Current directory:"
pwd

# 2. Check if we're in the right directory
if [[ $(pwd) != *"web-desa"* ]]; then
    echo "❌ NOT in web-desa directory!"
    echo "💡 Run: cd /home/mekh7277/web-desa"
    exit 1
fi

# 3. Check git status
echo ""
echo "📊 Git Status:"
git status

# 4. Show current branch
echo ""
echo "🌿 Current Branch:"
git branch -v

# 5. Check remote origin
echo ""
echo "🔗 Remote Origin:"
git remote -v

# 6. Show last 3 commits
echo ""
echo "📝 Last 3 Commits:"
git log --oneline -3

# 7. Check important files exist
echo ""
echo "📁 Important Files Check:"
if [ -f ".env" ]; then
    echo "✅ .env exists"
else
    echo "❌ .env missing!"
fi

if [ -f "composer.json" ]; then
    echo "✅ composer.json exists"
else
    echo "❌ composer.json missing!"
fi

if [ -d "vendor" ]; then
    echo "✅ vendor directory exists"
else
    echo "❌ vendor directory missing!"
fi

# 8. Check database connection
echo ""
echo "🗄️  Database Connection Test:"
php artisan tinker --execute="echo 'DB Connection: ' . (DB::connection()->getPdo() ? 'OK' : 'FAILED');"

# 9. Check current admin user
echo ""
echo "👤 Current Admin User:"
php artisan tinker --execute="echo 'Admin: ' . App\Models\User::find(1)->email . ' (ID: 1)';"

echo ""
echo "✅ Pre-deployment check completed!"
echo "🚀 Ready to proceed with pull deployment"
