#!/bin/bash

# 🚀 Quick Deploy Script - Statistik Admin System to cPanel
# Created: August 28, 2025

echo "=================================="
echo "🚀 DEPLOYING STATISTIK ADMIN SYSTEM"
echo "=================================="

# Color codes for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Function to print colored output
print_status() {
    echo -e "${GREEN}✅ $1${NC}"
}

print_warning() {
    echo -e "${YELLOW}⚠️  $1${NC}"
}

print_error() {
    echo -e "${RED}❌ $1${NC}"
}

print_info() {
    echo -e "${BLUE}ℹ️  $1${NC}"
}

# Step 1: Backup existing files
print_info "Step 1: Creating backup..."
backup_dir="public_html_backup_$(date +%Y%m%d_%H%M%S)"
if [ -d "public_html" ]; then
    cp -r public_html $backup_dir
    print_status "Backup created: $backup_dir"
else
    print_warning "No public_html directory found, skipping backup"
fi

# Step 2: Pull latest code
print_info "Step 2: Pulling latest code from repository..."
if git pull origin main; then
    print_status "Code updated successfully"
else
    print_error "Failed to pull code"
    exit 1
fi

# Step 3: Install/Update Composer dependencies
print_info "Step 3: Installing Composer dependencies..."
if command -v composer &> /dev/null; then
    composer install --optimize-autoloader --no-dev --no-interaction
    composer dump-autoload --optimize
    print_status "Composer dependencies installed"
else
    print_warning "Composer not found, skipping dependency installation"
fi

# Step 4: Laravel optimization and cache clearing
print_info "Step 4: Optimizing Laravel application..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
print_status "Laravel cache cleared"

# Step 5: Database migration and seeding
print_info "Step 5: Setting up database..."
if php artisan migrate --force; then
    print_status "Database migrated successfully"
    
    # Seed statistik data
    if php artisan db:seed --class=StatistikSeeder --force; then
        print_status "Sample data seeded successfully"
    else
        print_warning "Failed to seed data (might already exist)"
    fi
else
    print_error "Database migration failed"
fi

# Step 6: Set proper permissions
print_info "Step 6: Setting file permissions..."
if [ -d "storage" ]; then
    chmod -R 755 storage
    find storage -type f -exec chmod 644 {} \;
    print_status "Storage permissions set"
fi

if [ -d "bootstrap/cache" ]; then
    chmod -R 755 bootstrap/cache
    find bootstrap/cache -type f -exec chmod 644 {} \;
    print_status "Bootstrap cache permissions set"
fi

# Step 7: Production optimization
print_info "Step 7: Production optimization..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
print_status "Production caches generated"

# Step 8: Verify deployment
print_info "Step 8: Verifying deployment..."

# Check if key files exist
key_files=(
    "app/Models/StatistikModel.php"
    "app/Http/Controllers/StatistikController.php"
    "resources/views/admin/statistik/index.blade.php"
    "resources/views/data-statistik-baru.blade.php"
)

all_files_exist=true
for file in "${key_files[@]}"; do
    if [ -f "$file" ]; then
        print_status "✓ $file"
    else
        print_error "✗ $file (MISSING)"
        all_files_exist=false
    fi
done

# Check routes
print_info "Checking routes..."
if php artisan route:list | grep -q "statistik"; then
    print_status "Statistik routes registered"
else
    print_warning "Statistik routes might not be registered"
fi

echo ""
echo "=================================="
if $all_files_exist; then
    print_status "🎉 DEPLOYMENT SUCCESSFUL!"
else
    print_error "⚠️  DEPLOYMENT COMPLETED WITH WARNINGS"
fi
echo "=================================="

echo ""
print_info "� POST-DEPLOYMENT CHECKLIST:"
echo "   1. Update .env file with correct database credentials"
echo "   2. Test admin interface: yourdomain.com/admin/statistik"
echo "   3. Test public dashboard: yourdomain.com/data/statistik"
echo "   4. Verify all 3 charts are loading"
echo "   5. Check RT/RW/KK cards are displaying data"

echo ""
print_info "🔗 IMPORTANT URLS:"
echo "   📊 Admin Panel: /admin/statistik"
echo "   📈 Public Dashboard: /data/statistik"

echo ""
print_info "🐛 TROUBLESHOOTING:"
echo "   - Check error logs in cPanel if issues occur"
echo "   - Run 'php artisan tinker' to test database connection"
echo "   - Verify JavaScript console for chart loading issues"

echo ""
print_status "Deployment script completed! 🚀"
