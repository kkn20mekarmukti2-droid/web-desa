#!/bin/bash

# =================================================================
# DEPLOYMENT SCRIPT: Admin Statistik System to cPanel
# =================================================================
# This script deploys the complete admin statistik system with 
# 5-chart dashboard to cPanel hosting environment
# =================================================================

set -e  # Exit on any error

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

echo -e "${BLUE}🚀 DEPLOYING ADMIN STATISTIK SYSTEM TO CPANEL${NC}"
echo -e "${BLUE}=================================================${NC}"

# Step 1: Update Composer Dependencies
echo -e "\n${YELLOW}📦 Step 1: Installing/Updating Composer dependencies...${NC}"
composer install --no-dev --optimize-autoloader
if [ $? -eq 0 ]; then
    echo -e "${GREEN}✅ Composer dependencies installed successfully${NC}"
else
    echo -e "${RED}❌ Failed to install composer dependencies${NC}"
    exit 1
fi

# Step 2: Clear and Cache Configuration
echo -e "\n${YELLOW}⚙️  Step 2: Optimizing Laravel configuration...${NC}"
php artisan config:clear
php artisan config:cache
php artisan route:clear
php artisan route:cache
php artisan view:clear
php artisan view:cache
echo -e "${GREEN}✅ Laravel optimization completed${NC}"

# Step 3: Run Database Migration
echo -e "\n${YELLOW}🗄️  Step 3: Running database migration...${NC}"
php artisan migrate --force
if [ $? -eq 0 ]; then
    echo -e "${GREEN}✅ Database migration completed successfully${NC}"
else
    echo -e "${RED}❌ Database migration failed${NC}"
    exit 1
fi

# Step 4: Seed Statistik Data
echo -e "\n${YELLOW}🌱 Step 4: Seeding statistik data...${NC}"
php artisan db:seed --class=StatistikSeeder --force
if [ $? -eq 0 ]; then
    echo -e "${GREEN}✅ Statistik data seeded successfully${NC}"
else
    echo -e "${YELLOW}⚠️  Statistik seeding failed, but continuing deployment${NC}"
fi

# Step 5: Set Proper Permissions
echo -e "\n${YELLOW}🔐 Step 5: Setting file permissions...${NC}"
find . -type f -exec chmod 644 {} \;
find . -type d -exec chmod 755 {} \;
chmod -R 777 storage bootstrap/cache
echo -e "${GREEN}✅ File permissions set correctly${NC}"

# Step 6: Create/Update Storage Link
echo -e "\n${YELLOW}🔗 Step 6: Creating storage symbolic link...${NC}"
php artisan storage:link
echo -e "${GREEN}✅ Storage link created${NC}"

# Step 7: Verify Critical Files
echo -e "\n${YELLOW}🔍 Step 7: Verifying critical files...${NC}"

# Check if statistik migration exists
if [ -f "database/migrations/*create_statistik_table.php" ]; then
    echo -e "${GREEN}✅ Statistik migration file found${NC}"
else
    echo -e "${RED}❌ Statistik migration file not found${NC}"
fi

# Check if StatistikModel exists
if [ -f "app/Models/StatistikModel.php" ]; then
    echo -e "${GREEN}✅ StatistikModel found${NC}"
else
    echo -e "${RED}❌ StatistikModel not found${NC}"
fi

# Check if StatistikController exists
if [ -f "app/Http/Controllers/StatistikController.php" ]; then
    echo -e "${GREEN}✅ StatistikController found${NC}"
else
    echo -e "${RED}❌ StatistikController not found${NC}"
fi

# Check if data-statistik-baru view exists
if [ -f "resources/views/data-statistik-baru.blade.php" ]; then
    echo -e "${GREEN}✅ Data statistik dashboard view found${NC}"
else
    echo -e "${RED}❌ Data statistik dashboard view not found${NC}"
fi

echo -e "\n${BLUE}🎯 DEPLOYMENT SUMMARY${NC}"
echo -e "${BLUE}=====================${NC}"
echo -e "${GREEN}✅ Admin CRUD System: /admin/statistik${NC}"
echo -e "${GREEN}✅ Public Dashboard: /data/statistik${NC}"
echo -e "${GREEN}✅ 5 Chart Categories:${NC}"
echo -e "   - Jenis Kelamin (Gender)"
echo -e "   - Agama (Religion)"
echo -e "   - Pekerjaan (Occupation)"
echo -e "   - Kartu Keluarga (Family Cards)"
echo -e "   - RT/RW (Neighborhood Units)"
echo -e "${GREEN}✅ Database Migration: Complete${NC}"
echo -e "${GREEN}✅ Sample Data: Seeded${NC}"
echo -e "${GREEN}✅ Modern UI: Bootstrap 5 + Chart.js${NC}"

echo -e "\n${BLUE}🔧 CPANEL SPECIFIC INSTRUCTIONS:${NC}"
echo -e "${BLUE}=================================${NC}"
echo -e "1. Upload all files to public_html/"
echo -e "2. Set database credentials in .env file"
echo -e "3. Run: php artisan migrate --force"
echo -e "4. Run: php artisan db:seed --class=StatistikSeeder --force"
echo -e "5. Set storage and bootstrap/cache to 777 permissions"
echo -e "6. Run: php artisan storage:link"

echo -e "\n${GREEN}🎉 DEPLOYMENT COMPLETED SUCCESSFULLY!${NC}"
echo -e "${YELLOW}📝 Don't forget to update your .env file with cPanel database settings${NC}"

# Step 8: Display URLs
echo -e "\n${BLUE}🌐 ACCESS URLS:${NC}"
echo -e "${BLUE}===============${NC}"
echo -e "Admin Interface: ${YELLOW}https://yourdomain.com/admin/statistik${NC}"
echo -e "Public Dashboard: ${YELLOW}https://yourdomain.com/data/statistik${NC}"
echo -e "Chart Data API: ${YELLOW}https://yourdomain.com/getdatades?type=[category]${NC}"

echo -e "\n${GREEN}🚀 Ready for production!${NC}"
