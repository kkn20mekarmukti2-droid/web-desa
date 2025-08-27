#!/bin/bash
# 🚀 COMPLETE CPANEL DEPLOYMENT SCRIPT
# Jalankan script ini di cPanel Terminal untuk deployment lengkap

echo "🚀 === WEB DESA MEKARMUKTI - COMPLETE DEPLOYMENT ==="
echo "📅 Date: $(date)"
echo ""

# 1. Pull latest changes
echo "📥 STEP 1: Pulling latest changes from repository..."
git fetch --all
git status
git pull origin main

if [ $? -eq 0 ]; then
    echo "✅ Git pull successful!"
else
    echo "❌ Git pull failed! Check your connection and try again."
    exit 1
fi

# 2. Clear all caches  
echo ""
echo "🧹 STEP 2: Clearing all Laravel caches..."
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
php artisan optimize:clear

echo "✅ All caches cleared!"

# 3. Fix user roles and database structure
echo ""
echo "👥 STEP 3: Fixing user roles and database structure..."
php fix_user_roles.php

# 4. Clean up users to only Admin (ID:4) and Writer (ID:5)
echo ""
echo "🧹 STEP 4: Cleaning up users (Admin ID:4, Writer ID:5)..."
php user-cleanup.php

# 5. Update articles with correct titles and images
echo ""
echo "📝 STEP 5: Updating articles with correct titles..."
php cpanel-update-articles.php

# 6. Set proper permissions
echo ""
echo "🔒 STEP 6: Setting proper file permissions..."
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
chmod -R 644 database/database.sqlite

echo "✅ Permissions set!"

# 7. Verify deployment
echo ""
echo "🔍 STEP 7: Verifying deployment..."

# Check users
echo "👥 Users verification:"
php check_database.php | grep "👤"

# Check articles
echo ""
echo "📰 Articles verification:"
php -r "
\$pdo = new PDO('sqlite:database/database.sqlite');
\$stmt = \$pdo->query('SELECT judul, sampul FROM artikel ORDER BY created_at DESC LIMIT 3');
echo 'Top 3 Articles:' . PHP_EOL;
while (\$row = \$stmt->fetch(PDO::FETCH_ASSOC)) {
    \$imageExists = file_exists('public/img/' . \$row['sampul']) ? '✅' : '❌';
    echo \$imageExists . ' ' . \$row['judul'] . ' (Image: ' . \$row['sampul'] . ')' . PHP_EOL;
}
"

# Final cache clear
echo ""
echo "🧹 STEP 8: Final cache clear..."
php artisan cache:clear
php artisan view:clear

echo ""
echo "🎉 === DEPLOYMENT COMPLETED SUCCESSFULLY! ==="
echo ""
echo "🔐 LOGIN CREDENTIALS:"
echo "Admin: admin@webdesa.com / admin123 (ID: 4)"
echo "Writer: writer@webdesa.com / writer123 (ID: 5)"
echo ""
echo "✅ WHAT'S NEW:"
echo "- Premium UI/UX with mobile slide navigation"
echo "- Smart image fallback system" 
echo "- Correct article titles with matching images"
echo "- Clean user system (only 2 users)"
echo "- Role-based access control"
echo ""
echo "🌐 Test your website now:"
echo "- Homepage should show 3 correct articles"
echo "- Mobile navigation should slide in from right"
echo "- Images should display properly (or show nice placeholders)"
echo "- Admin login should work with full access"
echo "- Writer login should work with limited access"
echo ""
echo "📋 If you see any issues, check the troubleshooting guide in:"
echo "- CPANEL_DEPLOYMENT_GUIDE.md"
echo "- USER_MANAGEMENT_DOCS.md"
echo ""
