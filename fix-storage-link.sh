#!/bin/bash
# =====================================================
# CPANEL SYMLINK FIX - Manual Storage Link Creation
# Untuk hosting yang disable symlink() function
# =====================================================

echo "🔗 Manual Storage Link Fix for cPanel"
echo "====================================="

# Navigate to project root
cd /home/mekh7277/web-desa

# Check if public/storage already exists
if [ -L "public/storage" ]; then
    echo "⚠️  Removing existing storage symlink..."
    rm public/storage
elif [ -d "public/storage" ]; then
    echo "⚠️  Removing existing storage directory..."
    rm -rf public/storage
fi

# Create the manual link by copying
echo "📁 Creating manual storage link..."

# Method 1: Try creating symbolic link manually
echo "🔄 Trying manual symlink creation..."
if ln -sf ../storage/app/public public/storage 2>/dev/null; then
    echo "✅ Symbolic link created successfully!"
else
    echo "❌ Symlink failed, using copy method..."
    
    # Method 2: Copy method as fallback
    echo "📋 Creating storage directory and copying files..."
    mkdir -p public/storage
    
    # Copy existing files from storage/app/public to public/storage
    if [ -d "storage/app/public" ]; then
        cp -r storage/app/public/* public/storage/ 2>/dev/null || echo "No files to copy yet"
        echo "✅ Files copied to public/storage"
    else
        echo "📁 Creating storage/app/public directory"
        mkdir -p storage/app/public
    fi
    
    # Create a script for future file syncing
    cat > sync-storage.sh << 'EOF'
#!/bin/bash
# Sync files from storage/app/public to public/storage
echo "🔄 Syncing storage files..."
rsync -av --delete storage/app/public/ public/storage/
echo "✅ Storage sync completed"
EOF
    chmod +x sync-storage.sh
    echo "📝 Created sync-storage.sh for future file syncing"
fi

# Test the storage link
echo ""
echo "🧪 Testing storage access..."
if [ -d "public/storage" ]; then
    echo "✅ public/storage directory accessible"
    
    # Create a test file
    echo "test" > storage/app/public/test.txt
    if [ -f "public/storage/test.txt" ]; then
        echo "✅ Storage link working correctly"
        rm storage/app/public/test.txt public/storage/test.txt 2>/dev/null
    else
        echo "⚠️  Storage link not working, using copy method"
        # Copy the test file manually
        cp storage/app/public/test.txt public/storage/test.txt 2>/dev/null
        if [ -f "public/storage/test.txt" ]; then
            echo "✅ Manual copy method working"
            rm storage/app/public/test.txt public/storage/test.txt 2>/dev/null
        fi
    fi
else
    echo "❌ Storage directory creation failed"
    exit 1
fi

echo ""
echo "🎉 Storage link setup completed!"
echo ""
echo "💡 Important notes for cPanel hosting:"
echo "  - Symlink function is disabled on your hosting"
echo "  - Using manual copy method instead"
echo "  - Run ./sync-storage.sh after uploading new files to storage"
echo "  - Or manually copy files from storage/app/public to public/storage"
