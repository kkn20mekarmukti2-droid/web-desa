#!/bin/bash
# =====================================================
# CPANEL DEBUG & FIX SCRIPT
# Diagnose dan fix masalah login admin di cPanel
# =====================================================

echo "🔍 cPanel Debug & Fix Script"
echo "============================"

# Navigate to project
cd /home/mekh7277/web-desa

echo "📍 Current directory: $(pwd)"
echo ""

# 1. Check database connection
echo "🗄️  Testing database connection..."
php artisan tinker --execute="
try {
    \$pdo = DB::connection()->getPdo();
    echo 'Database: Connected ✅' . PHP_EOL;
    echo 'Driver: ' . DB::connection()->getDriverName() . PHP_EOL;
    echo 'Database: ' . DB::connection()->getDatabaseName() . PHP_EOL;
} catch (Exception \$e) {
    echo 'Database: FAILED ❌' . PHP_EOL;
    echo 'Error: ' . \$e->getMessage() . PHP_EOL;
}
"

echo ""

# 2. Check users table
echo "👥 Checking users in database..."
php artisan tinker --execute="
try {
    \$users = App\Models\User::all();
    echo 'Total users: ' . \$users->count() . PHP_EOL;
    foreach(\$users as \$user) {
        echo 'ID: ' . \$user->id . ', Name: ' . \$user->name . ', Email: ' . \$user->email . ', Created: ' . \$user->created_at . PHP_EOL;
    }
} catch (Exception \$e) {
    echo 'Users check FAILED: ' . \$e->getMessage() . PHP_EOL;
}
"

echo ""

# 3. Test password hash
echo "🔐 Testing password verification..."
php artisan tinker --execute="
try {
    \$user = App\Models\User::find(1);
    if (\$user) {
        echo 'User found: ' . \$user->email . PHP_EOL;
        \$testPassword = 'admin123';
        \$isValid = Hash::check(\$testPassword, \$user->password);
        echo 'Password \\\"' . \$testPassword . '\\\" valid: ' . (\$isValid ? 'YES ✅' : 'NO ❌') . PHP_EOL;
    } else {
        echo 'No user found with ID 1 ❌' . PHP_EOL;
    }
} catch (Exception \$e) {
    echo 'Password check FAILED: ' . \$e->getMessage() . PHP_EOL;
}
"

echo ""

# 4. Reset admin password
echo "🔄 Resetting admin password..."
php artisan tinker --execute="
try {
    \$user = App\Models\User::find(1);
    if (\$user) {
        \$user->password = Hash::make('admin123');
        \$user->save();
        echo 'Password reset SUCCESS ✅' . PHP_EOL;
        echo 'Email: ' . \$user->email . PHP_EOL;
        echo 'Password: admin123' . PHP_EOL;
    } else {
        echo 'No user found to reset ❌' . PHP_EOL;
    }
} catch (Exception \$e) {
    echo 'Password reset FAILED: ' . \$e->getMessage() . PHP_EOL;
}
"

echo ""

# 5. Check auth configuration
echo "⚙️  Checking auth configuration..."
php artisan tinker --execute="
echo 'Auth guard: ' . config('auth.defaults.guard') . PHP_EOL;
echo 'Auth provider: ' . config('auth.defaults.provider') . PHP_EOL;
echo 'User model: ' . config('auth.providers.users.model') . PHP_EOL;
"

echo ""

# 6. Check routes
echo "🛣️  Checking auth routes..."
php artisan route:list --name=login --name=admin

echo ""

# 7. Check .env critical settings
echo "📝 Checking .env settings..."
if [ -f ".env" ]; then
    echo "APP_KEY: $(grep APP_KEY .env | head -1)"
    echo "APP_ENV: $(grep APP_ENV .env | head -1)"
    echo "APP_DEBUG: $(grep APP_DEBUG .env | head -1)"
    echo "DB_CONNECTION: $(grep DB_CONNECTION .env | head -1)"
else
    echo "❌ .env file not found!"
fi

echo ""

# 8. Fix storage link
echo "🔗 Fixing storage link..."
php artisan storage:link-fix --force

echo ""

# 9. Clear all caches
echo "🧹 Clearing caches..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

echo ""
echo "🎉 Debug & Fix completed!"
echo ""
echo "🔑 Try login with:"
echo "  URL: https://yourdomain.com/admin"
echo "  Email: admin@webdesa.com"
echo "  Password: admin123"
echo ""
echo "🚨 If still not working:"
echo "  1. Check browser console for JavaScript errors"
echo "  2. Check network tab for failed requests"
echo "  3. Try different browser or incognito mode"
echo "  4. Check server error logs"
