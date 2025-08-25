#!/bin/bash
# =======================================================
# CPANEL FILE CLEANUP - Remove old unnecessary scripts
# Run this ONCE after git pull to clean old files
# =======================================================

clear
echo "🧹 CPANEL FILE CLEANUP - Web Desa"
echo "================================="
echo "This will remove old .sh files that are no longer needed"
echo ""

cd /home/mekh7277/web-desa

echo "📋 Current .sh files in directory:"
echo "=================================="
ls -la *.sh 2>/dev/null || echo "No .sh files found"

echo ""
echo "🗑️  Files to be REMOVED (if they exist):"
echo "========================================"
FILES_TO_REMOVE=(
    "user-cleanup.sh"
    "cpanel-user-cleanup.sh" 
    "production-admin-fix.sh"
    "deploy.sh"
    "deploy-to-cpanel.sh"
    "safe-deployment.sh"
    "cpanel-debug.sh"
    "cpanel-pre-check.sh"
)

for file in "${FILES_TO_REMOVE[@]}"; do
    if [ -f "$file" ]; then
        echo "   ❌ $file (EXISTS - will be deleted)"
    else
        echo "   ✅ $file (already removed)"
    fi
done

echo ""
echo "✅ Files to KEEP:"
echo "================"
KEEP_FILES=(
    "cpanel-deploy.sh"
    "simple-cleanup.sh"
    "fix-storage-link.sh"
)

for file in "${KEEP_FILES[@]}"; do
    if [ -f "$file" ]; then
        echo "   ✅ $file (KEEP - essential)"
    else
        echo "   ⚠️  $file (MISSING - should exist)"
    fi
done

echo ""
echo "⚠️  WARNING: This will permanently delete the old script files!"
echo ""
read -p "Continue with cleanup? (y/N): " confirm

if [[ $confirm =~ ^[Yy]$ ]]; then
    echo ""
    echo "🗑️  Removing old files..."
    echo "======================="
    
    DELETED_COUNT=0
    for file in "${FILES_TO_REMOVE[@]}"; do
        if [ -f "$file" ]; then
            echo "   Deleting: $file"
            rm -f "$file"
            DELETED_COUNT=$((DELETED_COUNT + 1))
        fi
    done
    
    echo ""
    echo "✅ CLEANUP COMPLETED!"
    echo "===================="
    echo "Files deleted: $DELETED_COUNT"
    
    echo ""
    echo "📁 Remaining .sh files:"
    echo "======================"
    ls -la *.sh 2>/dev/null || echo "No .sh files found"
    
else
    echo "❌ Cleanup cancelled."
fi

echo ""
echo "💡 TIP: After cleanup, you should have only 3 .sh files:"
echo "   - cpanel-deploy.sh (main deployment)"  
echo "   - simple-cleanup.sh (user cleanup)"
echo "   - fix-storage-link.sh (storage fixes)"
