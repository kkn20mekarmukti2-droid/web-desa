#!/bin/bash

# =====================================================
# ARTIKEL UPDATE DEPLOYMENT SCRIPT
# =====================================================

echo "🚀 Starting Article Update Deployment..."
echo "======================================"

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Step 1: Clear all caches locally
echo -e "${BLUE}🧹 Clearing local caches...${NC}"
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear

# Step 2: Update articles locally for verification
echo -e "${BLUE}📰 Updating articles locally...${NC}"
php fix_homepage_articles.php

# Step 3: Push to repository
echo -e "${BLUE}� Pushing changes to repository...${NC}"
git add -A
git commit -m "📰 Article update: Applied correct titles and images"
git push origin main

if [ $? -eq 0 ]; then
    echo -e "${GREEN}✅ Git push successful${NC}"
else
    echo -e "${RED}❌ Git push failed${NC}"
    exit 1
fi

# Step 4: Instructions for cPanel
echo -e "${YELLOW}📋 CPANEL DEPLOYMENT STEPS:${NC}"
echo "======================================"
echo "1. Login to your cPanel File Manager"
echo "2. Navigate to public_html directory"
echo "3. Pull latest changes from Git or upload files"
echo "4. Run these commands in Terminal:"
echo "   → cd public_html"
echo "   → php artisan cache:clear"
echo "   → php artisan view:clear"
echo "   → php fix_homepage_articles.php"
echo ""

# Step 5: Database update commands for cPanel
echo -e "${BLUE}�️  CPANEL DATABASE UPDATE:${NC}"
echo "======================================"
echo "Run this PHP script in cPanel terminal:"
echo ""
echo "php -r \""
echo "require_once 'vendor/autoload.php';"
echo "\\\$app = require_once 'bootstrap/app.php';"
echo "\\\$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();"
echo "use App\Models\artikelModel;"
echo "\\\$articles = artikelModel::orderBy('created_at', 'desc')->take(3)->get();"
echo "\\\$articles[0]->update(['judul' => 'Penyaluran BLT DD Tahun Anggaran 2024', 'sampul' => 'Penyaluran BLT DD.jpg']);"
echo "\\\$articles[1]->update(['judul' => 'Musyawarah Desa Mekarmukti Bahas Penetapan RKPDes TA 2025', 'sampul' => 'Penetapan RKPDes.jpg']);"
echo "\\\$articles[2]->update(['judul' => 'Penyuluhan IVA & TES Pelayanan KB PKK DESA MEKARMUKTI', 'sampul' => 'PENYULUHAN IVA TES.jpg']);"
echo "echo 'Articles updated successfully!';\"" 
echo ""

# Step 6: Verification
echo -e "${GREEN}✅ VERIFICATION:${NC}"
echo "======================================"
echo "After running commands, check:"
echo "1. Visit homepage → Should show 3 updated articles"
echo "2. Images should match article content"
echo "3. Titles should be exactly:"
echo "   - Penyaluran BLT DD Tahun Anggaran 2024"
echo "   - Musyawarah Desa Mekarmukti Bahas Penetapan RKPDes TA 2025"  
echo "   - Penyuluhan IVA & TES Pelayanan KB PKK DESA MEKARMUKTI"
echo ""

echo -e "${GREEN}🎉 DEPLOYMENT READY!${NC}"
echo "Execute the commands above in cPanel to apply changes."
