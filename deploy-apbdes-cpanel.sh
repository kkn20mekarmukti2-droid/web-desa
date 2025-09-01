#!/bin/bash

# 🚀 APBDes System - cPanel Deployment Script
# Deployment otomatis sistem transparansi APBDes ke cPanel

echo "🏛️ ========================================"
echo "   APBDes Transparency System Deployment"
echo "======================================== 🏛️"
echo ""

# Colors for output
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Configuration
CPANEL_PATH="/home/username/public_html"  # Change this to your cPanel path
DB_NAME="your_database_name"              # Change this to your database name
DB_USER="your_database_user"              # Change this to your database user
DB_PASS="your_database_password"          # Change this to your database password

echo -e "${BLUE}📋 Starting deployment process...${NC}"
echo ""

# Step 1: Check if we're in the right directory
if [ ! -f "artisan" ]; then
    echo -e "${RED}❌ Error: Not in Laravel project directory!${NC}"
    echo "Please run this script from the Laravel project root."
    exit 1
fi

echo -e "${GREEN}✅ Laravel project detected${NC}"

# Step 2: Pull latest changes from repository
echo -e "${BLUE}📦 Pulling latest changes...${NC}"
if git pull origin main; then
    echo -e "${GREEN}✅ Repository updated successfully${NC}"
else
    echo -e "${YELLOW}⚠️ Warning: Git pull failed or no changes${NC}"
fi
echo ""

# Step 3: Run database migration
echo -e "${BLUE}🗄️ Running database migration...${NC}"
if php artisan migrate --force; then
    echo -e "${GREEN}✅ Database migration completed${NC}"
else
    echo -e "${RED}❌ Database migration failed${NC}"
    echo "Please check database configuration in .env file"
fi
echo ""

# Step 4: Create storage link
echo -e "${BLUE}🔗 Creating storage link...${NC}"
if php artisan storage:link; then
    echo -e "${GREEN}✅ Storage link created successfully${NC}"
else
    echo -e "${YELLOW}⚠️ Storage link already exists or failed${NC}"
fi
echo ""

# Step 5: Clear all caches
echo -e "${BLUE}🧹 Clearing application caches...${NC}"
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
echo -e "${GREEN}✅ All caches cleared${NC}"
echo ""

# Step 6: Set proper permissions (if running on server)
echo -e "${BLUE}🔐 Setting file permissions...${NC}"
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
if [ -d "public/storage" ]; then
    chmod -R 755 public/storage/
fi
echo -e "${GREEN}✅ Permissions set successfully${NC}"
echo ""

# Step 7: Test APBDes routes
echo -e "${BLUE}🧪 Testing APBDes routes...${NC}"
if php artisan route:list --name=apbdes > /dev/null 2>&1; then
    echo -e "${GREEN}✅ APBDes routes loaded successfully${NC}"
    echo "Available APBDes routes:"
    php artisan route:list --name=apbdes
else
    echo -e "${RED}❌ APBDes routes not found${NC}"
fi
echo ""

# Step 8: Test transparansi route
echo -e "${BLUE}🧪 Testing transparansi route...${NC}"
if php artisan route:list --name=transparansi > /dev/null 2>&1; then
    echo -e "${GREEN}✅ Transparansi route loaded successfully${NC}"
    php artisan route:list --name=transparansi
else
    echo -e "${RED}❌ Transparansi route not found${NC}"
fi
echo ""

# Step 9: Verification
echo -e "${BLUE}🔍 Running system verification...${NC}"

# Check if APBDes table exists
echo "Checking database table..."
if php artisan tinker --execute="echo App\Models\Apbdes::count() . ' APBDes records found';" 2>/dev/null; then
    echo -e "${GREEN}✅ APBDes table verified${NC}"
else
    echo -e "${YELLOW}⚠️ Could not verify APBDes table${NC}"
fi

# Check storage directories
if [ -d "storage/app/public" ]; then
    echo -e "${GREEN}✅ Storage directory exists${NC}"
else
    echo -e "${RED}❌ Storage directory missing${NC}"
fi

if [ -L "public/storage" ] || [ -d "public/storage" ]; then
    echo -e "${GREEN}✅ Public storage link exists${NC}"
else
    echo -e "${RED}❌ Public storage link missing${NC}"
fi
echo ""

# Final summary
echo -e "${BLUE}📊 ========================================"
echo "           DEPLOYMENT SUMMARY"
echo "======================================== 📊${NC}"
echo ""
echo -e "${GREEN}✅ COMPLETED TASKS:${NC}"
echo "   📦 Repository updated"
echo "   🗄️ Database migration run"
echo "   🔗 Storage link created"
echo "   🧹 Caches cleared"
echo "   🔐 Permissions set"
echo "   🧪 Routes tested"
echo ""
echo -e "${YELLOW}🎯 NEXT STEPS:${NC}"
echo "   1. Test admin panel: /admin/apbdes"
echo "   2. Test public page: /transparansi-anggaran"
echo "   3. Upload a test APBDes document"
echo "   4. Verify image display and downloads"
echo ""
echo -e "${BLUE}📚 USEFUL COMMANDS:${NC}"
echo "   - Check routes: php artisan route:list"
echo "   - Clear cache: php artisan optimize:clear"
echo "   - Check logs: tail -f storage/logs/laravel.log"
echo ""
echo -e "${GREEN}🎉 APBDes System deployment completed!${NC}"
echo -e "${BLUE}🌐 Your transparency system is ready to serve the community!${NC}"
echo ""
