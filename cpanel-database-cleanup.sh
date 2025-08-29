#!/bin/bash

echo "🚀 CPANEL DATABASE CLEANUP DEPLOYMENT"
echo "===================================="

# Configuration
TIMESTAMP=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="database/backups"

echo "📅 Deployment started at: $(date)"
echo ""

# Step 1: Create backup directory if it doesn't exist
echo "📁 Preparing backup directory..."
mkdir -p $BACKUP_DIR

# Step 2: Backup current database (if possible)
echo "💾 Creating database backup..."
if command -v mysqldump &> /dev/null; then
    # Get database credentials from .env
    DB_DATABASE=$(grep DB_DATABASE .env | cut -d '=' -f2)
    DB_USERNAME=$(grep DB_USERNAME .env | cut -d '=' -f2)
    DB_PASSWORD=$(grep DB_PASSWORD .env | cut -d '=' -f2)
    
    if [ ! -z "$DB_DATABASE" ]; then
        mysqldump -u "$DB_USERNAME" -p"$DB_PASSWORD" "$DB_DATABASE" > "$BACKUP_DIR/statistik_backup_$TIMESTAMP.sql"
        echo "✅ Database backup created: $BACKUP_DIR/statistik_backup_$TIMESTAMP.sql"
    else
        echo "⚠️  Could not create MySQL backup - continuing with deployment"
    fi
else
    echo "⚠️  mysqldump not available - skipping backup"
fi

# Step 3: Check current database state
echo ""
echo "📊 Checking current database state..."
php check_statistik_data.php

# Step 4: Run database cleanup
echo ""
echo "🗑️ Running database cleanup..."
php clear_legacy_data.php

if [ $? -eq 0 ]; then
    echo "✅ Database cleanup completed successfully"
else
    echo "❌ Database cleanup failed - check errors above"
    exit 1
fi

# Step 5: Verify cleanup results
echo ""
echo "🔍 Verifying cleanup results..."
php check_statistik_data.php

# Step 6: Clear Laravel caches
echo ""
echo "🧹 Clearing application caches..."

# Clear various Laravel caches
php artisan cache:clear 2>/dev/null && echo "✅ Cache cleared" || echo "⚠️  Cache clear failed"
php artisan config:clear 2>/dev/null && echo "✅ Config cache cleared" || echo "⚠️  Config clear failed"  
php artisan view:clear 2>/dev/null && echo "✅ View cache cleared" || echo "⚠️  View clear failed"
php artisan route:clear 2>/dev/null && echo "✅ Route cache cleared" || echo "⚠️  Route clear failed"

# Step 7: Test database connection
echo ""
echo "🔌 Testing database connection..."
php -r "
require_once 'vendor/autoload.php';
\$app = require_once 'bootstrap/app.php';
\$kernel = \$app->make(Illuminate\Contracts\Console\Kernel::class);
\$kernel->bootstrap();
try {
    \$count = Illuminate\Support\Facades\DB::table('statistik')->count();
    echo '✅ Database connection OK - ' . \$count . ' records in statistik table\n';
} catch (Exception \$e) {
    echo '❌ Database connection failed: ' . \$e->getMessage() . '\n';
    exit(1);
}
"

# Step 8: Final verification
echo ""
echo "🎯 Final verification..."

# Check if we have the expected 4 records
RECORD_COUNT=$(php -r "
require_once 'vendor/autoload.php';
\$app = require_once 'bootstrap/app.php';
\$kernel = \$app->make(Illuminate\Contracts\Console\Kernel::class);
\$kernel->bootstrap();
echo Illuminate\Support\Facades\DB::table('statistik')->count();
")

if [ "$RECORD_COUNT" = "4" ]; then
    echo "✅ Expected 4 records found in statistik table"
else
    echo "⚠️  Expected 4 records, but found $RECORD_COUNT"
fi

# Check RT/RW uniqueness
RT_COUNT=$(php -r "
require_once 'vendor/autoload.php';
\$app = require_once 'bootstrap/app.php';
\$kernel = \$app->make(Illuminate\Contracts\Console\Kernel::class);
\$kernel->bootstrap();
echo Illuminate\Support\Facades\DB::table('statistik')->where('kategori', 'rt_rw')->where('label', 'Total RT')->count();
")

RW_COUNT=$(php -r "
require_once 'vendor/autoload.php';
\$app = require_once 'bootstrap/app.php';
\$kernel = \$app->make(Illuminate\Contracts\Console\Kernel::class);
\$kernel->bootstrap();
echo Illuminate\Support\Facades\DB::table('statistik')->where('kategori', 'rt_rw')->where('label', 'Total RW')->count();
")

if [ "$RT_COUNT" = "1" ] && [ "$RW_COUNT" = "1" ]; then
    echo "✅ RT/RW data is unique (no duplicates)"
else
    echo "❌ RT/RW data has duplicates - RT:$RT_COUNT, RW:$RW_COUNT"
fi

# Step 9: Deployment summary
echo ""
echo "📋 DEPLOYMENT SUMMARY"
echo "===================="
echo "🕐 Started: $(date)"
echo "📊 Final record count: $RECORD_COUNT"
echo "🏠 RT entries: $RT_COUNT (should be 1)"
echo "🏘️ RW entries: $RW_COUNT (should be 1)"

if [ "$RECORD_COUNT" = "4" ] && [ "$RT_COUNT" = "1" ] && [ "$RW_COUNT" = "1" ]; then
    echo ""
    echo "🎉 DEPLOYMENT SUCCESSFUL!"
    echo "💡 You can now check your admin dashboard:"
    echo "   📱 RT/RW data should display as counts (12 RT, 4 RW)"
    echo "   👨‍👩‍👧‍👦 KK data should show family counts (850 + 235)"
    echo "   📊 Charts should work properly"
    echo ""
    echo "🌐 Next steps:"
    echo "   1. Visit your admin dashboard: /admin/data-statistik"
    echo "   2. Verify all data displays correctly"
    echo "   3. Test CRUD operations"
else
    echo ""
    echo "⚠️  DEPLOYMENT NEEDS VERIFICATION"
    echo "   Please check the issues mentioned above"
    echo "   You may need to run the cleanup script again"
fi

echo ""
echo "📞 For support, check the logs above and run:"
echo "   php check_statistik_data.php"
echo ""
echo "✅ Deployment script completed at: $(date)"
