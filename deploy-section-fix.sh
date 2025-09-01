#!/bin/bash

echo "=== APBDes Section Fix Deployment ==="
echo "This script will deploy the fixed transparansi-anggaran.blade.php to production"
echo ""

# Configuration
CPANEL_PATH="/home/username/public_html"
BACKUP_DIR="backup_$(date +%Y%m%d_%H%M%S)"

echo "📦 Creating backup..."
# Create backup directory
mkdir -p $BACKUP_DIR

# Backup current production file
cp "$CPANEL_PATH/resources/views/transparansi-anggaran.blade.php" "$BACKUP_DIR/" 2>/dev/null || echo "⚠️  Original file not found (may not exist yet)"

echo "✅ Backup created in: $BACKUP_DIR"

echo ""
echo "🚀 Deploying fixed view file..."

# Deploy the corrected view file
cp "resources/views/transparansi-anggaran.blade.php" "$CPANEL_PATH/resources/views/"

echo "✅ Fixed view file deployed"

echo ""
echo "🔧 Setting proper permissions..."
chmod 644 "$CPANEL_PATH/resources/views/transparansi-anggaran.blade.php"

echo ""
echo "📋 Deployment Summary:"
echo "- ✅ Fixed section name: @section('konten') → @section('content')"
echo "- ✅ View file uploaded to production"
echo "- ✅ Backup created: $BACKUP_DIR"
echo ""
echo "🔍 Next steps:"
echo "1. Test the transparency page: http://yourdomain.com/transparansi-anggaran"
echo "2. Verify APBDes data now displays correctly"
echo "3. Check that images and formatting appear properly"
echo ""
echo "If issues persist, check the debug script with:"
echo "php debug-section-fix.php"
