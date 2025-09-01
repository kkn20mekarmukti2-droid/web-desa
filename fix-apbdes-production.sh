#!/bin/bash

# 🚀 APBDes Production Quick Fix Script
# Untuk memperbaiki masalah transparansi anggaran tidak muncul di production

echo "🔧 ========================================"
echo "   APBDes Production Quick Fix"
echo "======================================== 🔧"
echo ""

# Colors for output
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

echo -e "${BLUE}🔍 Diagnosing APBDes transparency issue...${NC}"
echo ""

# Step 1: Clear all caches
echo -e "${BLUE}🧹 Clearing all caches...${NC}"
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
echo -e "${GREEN}✅ Caches cleared${NC}"
echo ""

# Step 2: Check and create storage link
echo -e "${BLUE}🔗 Checking storage link...${NC}"
if [ -L "public/storage" ] || [ -d "public/storage" ]; then
    echo -e "${GREEN}✅ Storage link exists${NC}"
else
    echo -e "${YELLOW}⚠️ Creating storage link...${NC}"
    php artisan storage:link
    echo -e "${GREEN}✅ Storage link created${NC}"
fi
echo ""

# Step 3: Check APBDes directory
echo -e "${BLUE}📁 Checking APBDes storage directory...${NC}"
if [ ! -d "storage/app/public/apbdes" ]; then
    echo -e "${YELLOW}⚠️ Creating APBDes directory...${NC}"
    mkdir -p storage/app/public/apbdes
    chmod 755 storage/app/public/apbdes
    echo -e "${GREEN}✅ APBDes directory created${NC}"
else
    echo -e "${GREEN}✅ APBDes directory exists${NC}"
fi
echo ""

# Step 4: Set proper permissions
echo -e "${BLUE}🔐 Setting storage permissions...${NC}"
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
if [ -d "public/storage" ]; then
    chmod -R 755 public/storage/
fi
echo -e "${GREEN}✅ Permissions updated${NC}"
echo ""

# Step 5: Database quick check
echo -e "${BLUE}🗄️ Checking database...${NC}"
if php artisan tinker --execute="echo 'Total APBDes: ' . App\Models\Apbdes::count(); echo '\nActive APBDes: ' . App\Models\Apbdes::where('is_active', true)->count();" 2>/dev/null; then
    echo -e "${GREEN}✅ Database accessible${NC}"
else
    echo -e "${YELLOW}⚠️ Database check failed - may need manual check${NC}"
fi
echo ""

# Step 6: Test route registration
echo -e "${BLUE}🛣️ Checking routes...${NC}"
if php artisan route:list --name=transparansi > /dev/null 2>&1; then
    echo -e "${GREEN}✅ Transparansi route registered${NC}"
else
    echo -e "${RED}❌ Transparansi route not found${NC}"
fi
echo ""

# Step 7: Optimize for production
echo -e "${BLUE}⚡ Optimizing for production...${NC}"
php artisan config:cache
php artisan route:cache
php artisan view:cache
echo -e "${GREEN}✅ Production optimization complete${NC}"
echo ""

echo -e "${BLUE}🎯 ========================================${NC}"
echo -e "${BLUE}          QUICK FIX COMPLETED${NC}"
echo -e "${BLUE}========================================${NC}"
echo ""

echo -e "${GREEN}✅ COMPLETED ACTIONS:${NC}"
echo "   🧹 Cleared all caches"
echo "   🔗 Verified/created storage link"
echo "   📁 Ensured APBDes directory exists"
echo "   🔐 Set proper file permissions"
echo "   🗄️ Tested database connection"
echo "   🛣️ Verified route registration"
echo "   ⚡ Applied production optimizations"
echo ""

echo -e "${YELLOW}🧪 TESTING STEPS:${NC}"
echo "1. 🌐 Test public page: /transparansi-anggaran"
echo "2. 🔑 Login to admin: /admin/login"
echo "3. 📊 Check APBDes admin: /admin/apbdes"
echo "4. ➕ Add test APBDes if no data exists"
echo "5. ✅ Ensure records are set to 'Active'"
echo ""

echo -e "${BLUE}🔍 IF STILL NOT WORKING:${NC}"
echo "📋 Run debug script: php debug-apbdes-production.php"
echo "🌐 Check browser: Hard refresh (Ctrl+F5)"
echo "📱 Test in incognito/private mode"
echo "📞 Check server error logs"
echo ""

echo -e "${GREEN}🎉 APBDes transparency should now be working!${NC}"
echo ""
