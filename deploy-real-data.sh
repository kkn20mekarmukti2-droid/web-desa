#!/bin/bash

# =====================================================
# DEPLOY REAL DATA TO PRODUCTION SCRIPT
# =====================================================

echo "🚀 Starting Production Data Deployment..."
echo "======================================"

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Step 1: Git push latest changes
echo -e "${BLUE}📤 Pushing latest changes to repository...${NC}"
git add -A
git commit -m "🎯 Production data deployment: Real village statistics ready"
git push origin main

if [ $? -eq 0 ]; then
    echo -e "${GREEN}✅ Git push successful${NC}"
else
    echo -e "${RED}❌ Git push failed${NC}"
    exit 1
fi

# Step 2: Deploy to cPanel (if cpanel-deploy.sh exists)
if [ -f "cpanel-deploy.sh" ]; then
    echo -e "${BLUE}🔄 Running cPanel deployment...${NC}"
    chmod +x cpanel-deploy.sh
    ./cpanel-deploy.sh
    
    if [ $? -eq 0 ]; then
        echo -e "${GREEN}✅ cPanel deployment successful${NC}"
    else
        echo -e "${YELLOW}⚠️  cPanel deployment had issues, continuing...${NC}"
    fi
fi

# Step 3: Instructions for manual SQL import
echo -e "${YELLOW}📋 MANUAL STEPS REQUIRED:${NC}"
echo "======================================"
echo "1. Login to cPanel → phpMyAdmin"
echo "2. Select database: mekh7277_desa"
echo "3. Go to SQL tab"
echo "4. Copy and paste the content from: populate_production_data.sql"
echo "5. Execute the SQL script"
echo ""
echo -e "${GREEN}📄 SQL File Location: $(pwd)/populate_production_data.sql${NC}"
echo ""

# Step 4: Show SQL preview
echo -e "${BLUE}📊 SQL Script Preview (first 10 lines):${NC}"
echo "======================================"
head -10 populate_production_data.sql
echo "... (and more)"
echo ""

# Step 5: Verification steps
echo -e "${YELLOW}✅ VERIFICATION STEPS:${NC}"
echo "======================================"
echo "After running SQL script, verify by:"
echo "1. Visit: https://mekarmukti.id/datapenduduk"
echo "2. Check if charts show real data (not sample data)"
echo "3. Verify numbers match expected village statistics"
echo "4. Test other statistical pages"
echo ""

# Step 6: Admin panel access
echo -e "${BLUE}🔧 ADMIN PANEL ACCESS:${NC}"
echo "======================================"
echo "After deployment, admin can manage data at:"
echo "→ https://mekarmukti.id/admin/data-management"
echo "→ Login with admin credentials"
echo "→ Edit/export village statistics"
echo ""

echo -e "${GREEN}🎉 DEPLOYMENT PREPARATION COMPLETE!${NC}"
echo "======================================"
echo "Next steps:"
echo "1. Execute the SQL script in phpMyAdmin"
echo "2. Clear any cache if needed"
echo "3. Test the statistical charts"
echo "4. Enjoy real village data visualization! 📈"
