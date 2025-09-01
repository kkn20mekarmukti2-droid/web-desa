#!/bin/bash

echo "=== APBDes Manual Image Copy Fix ==="
echo "This will copy images from storage/app/public to public/storage"
echo ""

# Check if source directory exists
SOURCE_DIR="storage/app/public/apbdes"
TARGET_DIR="public/storage/apbdes"
ALT_TARGET_DIR="public/images/apbdes"

if [ ! -d "$SOURCE_DIR" ]; then
    echo "❌ Source directory not found: $SOURCE_DIR"
    exit 1
fi

echo "✅ Source directory found: $SOURCE_DIR"

# Create target directories
mkdir -p "$TARGET_DIR"
mkdir -p "$ALT_TARGET_DIR"
echo "✅ Target directories created"

# Copy files
echo ""
echo "📁 Copying files..."
cp -r "$SOURCE_DIR"/* "$TARGET_DIR"/ 2>/dev/null
cp -r "$SOURCE_DIR"/* "$ALT_TARGET_DIR"/ 2>/dev/null

# Set permissions
chmod 755 "$TARGET_DIR"
chmod 755 "$ALT_TARGET_DIR"
find "$TARGET_DIR" -type f -exec chmod 644 {} \;
find "$ALT_TARGET_DIR" -type f -exec chmod 644 {} \;

echo "✅ Files copied and permissions set"

# List copied files
echo ""
echo "📋 Files in target directory:"
ls -la "$TARGET_DIR"

echo ""
echo "🔍 Testing file accessibility..."
for file in "$TARGET_DIR"/*; do
    if [ -f "$file" ]; then
        filename=$(basename "$file")
        echo "• $filename: ✅ Accessible via /storage/apbdes/$filename"
    fi
done

echo ""
echo "🎯 Next steps:"
echo "1. Visit your transparency page: /transparansi-anggaran"
echo "2. Images should now display properly"
echo "3. If still not working, run: php manual-copy-images.php"
echo ""
echo "✅ Manual copy completed!"
