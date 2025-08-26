#!/bin/bash
# 🚀 QUICK DEPLOYMENT SCRIPT FOR CPANEL
# Jalankan script ini di cPanel untuk deployment cepat

echo "=== WEB DESA DEPLOYMENT STARTED ==="

# 1. Pull latest changes
echo "📥 Pulling latest changes..."
git pull origin main

# 2. Clear all caches  
echo "🧹 Clearing caches..."
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
php artisan optimize:clear

# 3. Update articles database
echo "📝 Updating articles..."
php cpanel-update-articles.php

# 4. Set permissions
echo "🔒 Setting permissions..."
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/

# 5. Verify deployment
echo "✅ Verifying deployment..."
php -r "
echo '=== ARTICLE VERIFICATION ===' . PHP_EOL;
\$pdo = new PDO('sqlite:database/database.sqlite');
\$stmt = \$pdo->query('SELECT judul, sampul FROM artikel ORDER BY created_at DESC LIMIT 3');
while (\$row = \$stmt->fetch(PDO::FETCH_ASSOC)) {
    echo '✓ ' . \$row['judul'] . ' | Image: ' . \$row['sampul'] . PHP_EOL;
}
"

echo ""
echo "🎉 DEPLOYMENT COMPLETED!"
echo "📱 Check your website now:"
echo "   - Homepage articles should be updated"
echo "   - Mobile navigation should work"
echo "   - Images should display properly"
echo ""
echo "If issues persist, run: php cpanel-update-articles.php"
