#!/bin/bash
# =======================================================
# FORCE CLEANUP & UPDATE - Resolve git conflicts
# This will force remove old files and update to latest
# =======================================================

clear
echo "🔧 FORCE CLEANUP & UPDATE - Web Desa"
echo "===================================="
echo "Resolving git conflicts and updating to latest version"
echo ""

cd /home/mekh7277/web-desa

echo "📋 Current situation:"
echo "===================="
git status --short

echo ""
echo "🗑️  STEP 1: Remove conflicting files"
echo "=================================="
CONFLICT_FILES=(
    "cpanel-debug.sh"
    "production-admin-fix.sh" 
    "user-cleanup.sh"
    "cpanel-user-cleanup.sh"
    "deploy.sh"
    "deploy-to-cpanel.sh"
    "safe-deployment.sh"
    "cpanel-pre-check.sh"
)

echo "Removing conflicting/old files..."
for file in "${CONFLICT_FILES[@]}"; do
    if [ -f "$file" ]; then
        echo "   Removing: $file"
        rm -f "$file"
    fi
done

echo ""
echo "🔄 STEP 2: Reset git state"
echo "=========================="
git reset --hard HEAD
git clean -fd

echo ""
echo "⬇️  STEP 3: Pull latest changes"  
echo "=============================="
git pull origin main

echo ""
echo "📁 STEP 4: Verify final files"
echo "============================="
echo "Remaining .sh files:"
ls -la *.sh 2>/dev/null || echo "No .sh files found"

echo ""
echo "✅ CLEANUP COMPLETED!"
echo "===================="
echo "You should now have only these essential scripts:"
echo "   - cpanel-deploy.sh (main deployment)"
echo "   - simple-cleanup.sh (user cleanup)"  
echo "   - fix-storage-link.sh (storage fixes)"
echo "   - cpanel-file-cleanup.sh (this cleanup script)"

echo ""
echo "🎯 Next steps:"
echo "============="  
echo "1. Test user cleanup: bash simple-cleanup.sh"
echo "2. For future deployments: bash cpanel-deploy.sh"
