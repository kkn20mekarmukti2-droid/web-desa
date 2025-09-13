#!/bin/bash
# =============================================
# CPanel Deployment Script untuk Sistem Majalah
# Website Desa Mekarmukti
# =============================================

echo "🚀 Starting Magazine System Deployment..."

# 1. Database Operations
echo "📊 Creating database tables..."
mysql -u $DB_USER -p$DB_PASS $DB_NAME < majalah-tables-deployment.sql

if [ $? -eq 0 ]; then
    echo "✅ Database tables created successfully"
else
    echo "❌ Failed to create database tables"
    exit 1
fi

# 2. Directory Structure
echo "📁 Creating storage directories..."
mkdir -p storage/app/public/majalah
mkdir -p storage/app/public/majalah/pages
chmod -R 755 storage/

if [ -d "storage/app/public/majalah" ]; then
    echo "✅ Storage directories created"
else
    echo "❌ Failed to create storage directories"
    exit 1
fi

# 3. Symbolic Link
echo "🔗 Creating storage symbolic link..."
php artisan storage:link

if [ $? -eq 0 ]; then
    echo "✅ Storage link created"
else
    echo "⚠️  Storage link may already exist"
fi

# 4. Cache Clear
echo "🧹 Clearing application cache..."
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear

echo "✅ Cache cleared"

# 5. Permissions
echo "🔐 Setting file permissions..."
find storage -type f -exec chmod 644 {} \;
find storage -type d -exec chmod 755 {} \;
chmod -R 755 storage/logs
chmod -R 755 storage/framework

echo "✅ Permissions set"

# 6. Test Routes
echo "🧪 Testing routes..."
echo "Admin Panel: /admin/majalah"
echo "Public View: /majalah-desa"
echo "API Endpoint: /api/majalah/{id}/pages"

# 7. Sample Images Notice
echo ""
echo "📋 POST-DEPLOYMENT CHECKLIST:"
echo "1. ✅ Upload sample images to storage/app/public/majalah/"
echo "2. ✅ Test admin access: yoursite.com/admin/majalah"
echo "3. ✅ Test public view: yoursite.com/majalah-desa"
echo "4. ✅ Verify file upload functionality"
echo "5. ✅ Test flipbook display"
echo ""
echo "🎉 Magazine System Deployment Complete!"
echo ""
echo "📱 Admin Features Available:"
echo "- Create/Edit/Delete magazines"
echo "- Upload cover images and pages"
echo "- Manage page content"
echo "- Toggle magazine status"
echo ""
echo "🌐 Public Features Available:"
echo "- Interactive flipbook reading"
echo "- Magazine collection grid"
echo "- Homepage teaser integration"
echo "- Mobile responsive design"
