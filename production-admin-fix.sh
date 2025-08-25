#!/bin/bash
# =====================================================
# PRODUCTION ADMIN FIX
# Untuk handle multiple admin users di production
# =====================================================

echo "🔐 Production Multi-Admin Fix"
echo "============================="

cd /home/mekh7277/web-desa

echo "📋 Current Users in Database:"
php artisan tinker --execute="
\$users = App\Models\User::orderBy('id')->get();
foreach(\$users as \$user) {
    echo 'ID: ' . \$user->id . ' | ' . \$user->name . ' | ' . \$user->email . PHP_EOL;
}
"

echo ""
echo "🎯 QUICK FIX OPTIONS:"
echo "1. Reset primary admin (rasidokai@gmail.com)"
echo "2. Create admin@webdesa.com account"  
echo "3. Reset all users to same password"
echo "4. Interactive multi-admin tool"

read -p "Choose option (1-4): " choice

case $choice in
    1)
        echo "🔄 Resetting primary admin (rasidokai@gmail.com)..."
        php artisan tinker --execute="
        \$user = App\Models\User::find(1);
        \$user->password = Hash::make('admin123');
        \$user->save();
        echo 'SUCCESS! Login with:' . PHP_EOL;
        echo 'Email: ' . \$user->email . PHP_EOL;
        echo 'Password: admin123' . PHP_EOL;
        "
        ;;
    2)
        echo "➕ Creating admin@webdesa.com account..."
        php artisan tinker --execute="
        if (App\Models\User::where('email', 'admin@webdesa.com')->exists()) {
            echo 'User already exists! Resetting password...' . PHP_EOL;
            \$user = App\Models\User::where('email', 'admin@webdesa.com')->first();
            \$user->password = Hash::make('admin123');
            \$user->save();
        } else {
            \$user = App\Models\User::create([
                'name' => 'Admin Desa',
                'email' => 'admin@webdesa.com', 
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
            ]);
            echo 'New admin created!' . PHP_EOL;
        }
        echo 'SUCCESS! Login with:' . PHP_EOL;
        echo 'Email: admin@webdesa.com' . PHP_EOL;
        echo 'Password: admin123' . PHP_EOL;
        "
        ;;
    3)
        echo "🔄 Resetting ALL users to same password..."
        php artisan tinker --execute="
        \$users = App\Models\User::all();
        foreach(\$users as \$user) {
            \$user->password = Hash::make('admin123');
            \$user->save();
            echo 'Reset: ' . \$user->email . PHP_EOL;
        }
        echo 'All users password = admin123' . PHP_EOL;
        "
        ;;
    4)
        echo "🛠️  Using interactive multi-admin tool..."
        php artisan admin:multi-reset
        ;;
    *)
        echo "❌ Invalid option"
        exit 1
        ;;
esac

echo ""
echo "✅ Admin fix completed!"
echo ""
echo "🔑 LOGIN CREDENTIALS:"
echo "URL: https://mekarmukti.id/admin"
echo "Password: admin123"
echo ""
echo "📧 Available emails to try:"
php artisan tinker --execute="
App\Models\User::orderBy('id')->get()->each(function(\$user) {
    echo '  - ' . \$user->email . PHP_EOL;
});
"

echo ""
echo "💡 Recommendation: Use rasidokai@gmail.com (primary admin)"
