#!/bin/bash

echo "=========================================="
echo "DEPLOY STATISTIK SYSTEM TO CPANEL"
echo "=========================================="

# Set variables
CPANEL_PATH="/home/mekh7277/public_html"
LOCAL_PATH="/c/xampp/htdocs/web-desa"

echo "🚀 Starting deployment process..."

# 1. Upload migration file
echo "📁 Uploading migration file..."
scp database/migrations/2025_08_28_112020_create_statistik_table.php mekh7277@mekarmukti.id:$CPANEL_PATH/database/migrations/

# 2. Upload model
echo "📁 Uploading StatistikModel..."
scp app/Models/StatistikModel.php mekh7277@mekarmukti.id:$CPANEL_PATH/app/Models/

# 3. Upload controller
echo "📁 Uploading StatistikController..."
scp app/Http/Controllers/StatistikController.php mekh7277@mekarmukti.id:$CPANEL_PATH/app/Http/Controllers/

# 4. Upload admin views
echo "📁 Uploading admin statistik views..."
scp -r resources/views/admin/statistik/ mekh7277@mekarmukti.id:$CPANEL_PATH/resources/views/admin/

# 5. Upload updated routes
echo "📁 Uploading updated routes..."
scp routes/web.php mekh7277@mekarmukti.id:$CPANEL_PATH/routes/

# 6. Upload updated dataController
echo "📁 Uploading updated dataController..."
scp app/Http/Controllers/dataController.php mekh7277@mekarmukti.id:$CPANEL_PATH/app/Http/Controllers/

# 7. Upload updated admin layout (with menu)
echo "📁 Uploading updated admin layout..."
scp resources/views/layout/admin.blade.php mekh7277@mekarmukti.id:$CPANEL_PATH/resources/views/layout/

# 8. Upload seeder
echo "📁 Uploading seeder..."
scp database/seeders/StatistikSeeder.php mekh7277@mekarmukti.id:$CPANEL_PATH/database/seeders/

echo "✅ File upload completed!"
echo ""
echo "🔧 MANUAL STEPS REQUIRED ON CPANEL:"
echo "1. SSH to your cPanel server"
echo "2. cd $CPANEL_PATH"
echo "3. php artisan migrate"
echo "4. php artisan db:seed --class=StatistikSeeder"
echo "5. php artisan route:clear"
echo "6. php artisan config:clear"
echo "7. php artisan cache:clear"
echo ""
echo "🌐 Then test: https://mekarmukti.id/admin/statistik"
echo "=========================================="
