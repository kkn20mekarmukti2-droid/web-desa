#!/bin/bash
# =======================================================
# CPANEL USER CLEANUP - WEB DESA MEKARMUKTI
# Script khusus untuk cleanup duplikat admin di cPanel
# =======================================================

clear
echo "🏛️  WEB DESA MEKARMUKTI - USER CLEANUP"
echo "======================================"
echo "📅 $(date)"
echo ""

# Set working directory
cd /home/mekh7277/web-desa

# Check if Laravel app exists
if [ ! -f "artisan" ]; then
    echo "❌ Laravel app not found in current directory"
    echo "Current path: $(pwd)"
    exit 1
fi

echo "✅ Laravel app detected"
echo ""

# Show current users
echo "👥 CURRENT ADMIN USERS:"
echo "----------------------"
php artisan tinker --execute="
\$users = App\Models\User::orderBy('id')->get();
echo 'Total users: ' . \$users->count() . PHP_EOL;
echo str_repeat('-', 60) . PHP_EOL;
foreach(\$users as \$user) {
    \$articles = App\Models\artikelModel::where('created_by', \$user->id)->count();
    echo sprintf('ID: %-2s | %-25s | %-30s | Articles: %s', 
        \$user->id, 
        substr(\$user->name, 0, 25), 
        substr(\$user->email, 0, 30), 
        \$articles
    ) . PHP_EOL;
}
echo str_repeat('-', 60) . PHP_EOL;
"

echo ""
echo "🎯 CLEANUP OPTIONS:"
echo "=================="
echo "1. 🔍 DRY RUN - Lihat analisis saja (AMAN)"
echo "2. 🧹 QUICK CLEANUP - Hapus duplikat Rasyid Shiddiq"
echo "3. 🎯 STANDARD ADMIN - Buat admin@webdesa.com sebagai satu-satunya admin"
echo "4. 🛠️  ADVANCED - Interactive cleanup dengan pilihan lengkap"
echo "5. ❌ CANCEL - Keluar tanpa mengubah apapun"
echo ""

read -p "Pilih opsi (1-5): " choice

case $choice in
    1)
        echo ""
        echo "🔍 RUNNING DRY RUN ANALYSIS..."
        echo "==============================="
        php artisan admin:cleanup-users --dry-run
        echo ""
        echo "✅ Analysis completed. No changes made."
        ;;
        
    2)
        echo ""
        echo "🧹 QUICK CLEANUP - DUPLIKAT RASYID SHIDDIQ"
        echo "=========================================="
        echo "⚠️  This will:"
        echo "   - Keep the first Rasyid Shiddiq account"
        echo "   - Delete the duplicate Rasyid Shiddiq account"
        echo "   - Migrate articles if needed"
        echo ""
        read -p "Continue with quick cleanup? (y/N): " confirm
        if [[ $confirm =~ ^[Yy]$ ]]; then
            echo "Processing..."
            php artisan tinker --execute="
            \$rasyids = App\Models\User::where('name', 'like', '%Rasyid%')->orderBy('id')->get();
            if(\$rasyids->count() >= 2) {
                \$keepUser = \$rasyids->first();
                \$deleteUsers = \$rasyids->slice(1);
                
                foreach(\$deleteUsers as \$delUser) {
                    // Migrate articles
                    \$migrated = App\Models\artikelModel::where('created_by', \$delUser->id)
                        ->update(['created_by' => \$keepUser->id]);
                    echo 'Migrated ' . \$migrated . ' articles (created_by) from ' . \$delUser->email . ' to ' . \$keepUser->email . PHP_EOL;
                    
                    \$updated = App\Models\artikelModel::where('updated_by', \$delUser->id)
                        ->update(['updated_by' => \$keepUser->id]);
                    echo 'Migrated ' . \$updated . ' articles (updated_by) from ' . \$delUser->email . ' to ' . \$keepUser->email . PHP_EOL;
                    
                    // Delete user
                    \$delUser->delete();
                    echo 'Deleted user: ' . \$delUser->email . PHP_EOL;
                }
                echo 'Quick cleanup completed!' . PHP_EOL;
            } else {
                echo 'No Rasyid duplicates found.' . PHP_EOL;
            }
            "
        else
            echo "Cancelled."
        fi
        ;;
        
    3)
        echo ""
        echo "🎯 CREATING STANDARD ADMIN ACCOUNT"
        echo "=================================="
        echo "⚠️  This will:"
        echo "   - Create admin@webdesa.com (password: admin123)"
        echo "   - Migrate ALL articles to this account"
        echo "   - Delete ALL other admin accounts"
        echo "   - Result: Only 1 admin account"
        echo ""
        read -p "This is a major change. Continue? (y/N): " confirm
        if [[ $confirm =~ ^[Yy]$ ]]; then
            echo "Creating standard admin..."
            php artisan tinker --execute="
            // Create or find admin
            \$admin = App\Models\User::firstOrCreate(
                ['email' => 'admin@webdesa.com'],
                [
                    'name' => 'Admin Desa Mekarmukti',
                    'password' => Hash::make('admin123'),
                    'email_verified_at' => now()
                ]
            );
            echo 'Standard admin: ' . \$admin->email . ' (ID: ' . \$admin->id . ')' . PHP_EOL;
            
            // Migrate all articles (created_by)
            \$migrated1 = App\Models\artikelModel::where('created_by', '!=', \$admin->id)
                ->update(['created_by' => \$admin->id]);
            echo 'Articles migrated (created_by): ' . \$migrated1 . PHP_EOL;
            
            // Migrate all articles (updated_by)  
            \$migrated2 = App\Models\artikelModel::where('updated_by', '!=', \$admin->id)
                ->update(['updated_by' => \$admin->id]);
            echo 'Articles migrated (updated_by): ' . \$migrated2 . PHP_EOL;
            
            // Delete other users
            \$otherUsers = App\Models\User::where('id', '!=', \$admin->id)->get();
            foreach(\$otherUsers as \$user) {
                echo 'Deleting: ' . \$user->email . PHP_EOL;
            }
            \$deleted = App\Models\User::where('id', '!=', \$admin->id)->delete();
            echo 'Users deleted: ' . \$deleted . PHP_EOL . PHP_EOL;
            
            echo '🎉 SETUP COMPLETED!' . PHP_EOL;
            echo '==================' . PHP_EOL;
            echo 'LOGIN CREDENTIALS:' . PHP_EOL;
            echo 'Email: admin@webdesa.com' . PHP_EOL;
            echo 'Password: admin123' . PHP_EOL;
            "
        else
            echo "Cancelled."
        fi
        ;;
        
    4)
        echo ""
        echo "🛠️  ADVANCED INTERACTIVE CLEANUP"
        echo "==============================="
        php artisan admin:cleanup-users
        ;;
        
    5)
        echo ""
        echo "❌ Operation cancelled."
        exit 0
        ;;
        
    *)
        echo "❌ Invalid option selected."
        exit 1
        ;;
esac

echo ""
echo "📊 FINAL STATUS:"
echo "==============="
php artisan tinker --execute="
echo 'Total users now: ' . App\Models\User::count() . PHP_EOL;
echo 'Total articles: ' . App\Models\artikelModel::count() . PHP_EOL . PHP_EOL;

\$users = App\Models\User::orderBy('id')->get();
echo 'REMAINING USERS:' . PHP_EOL;
foreach(\$users as \$user) {
    \$articles = App\Models\artikelModel::where('created_by', \$user->id)->count();
    echo '✅ ' . \$user->email . ' (' . \$user->name . ') - ' . \$articles . ' articles' . PHP_EOL;
}
"

echo ""
echo "🎉 User cleanup process completed!"
echo "=================================="
echo "📝 Remember to test login with the remaining account(s)"
echo "🔐 All passwords are set to: admin123"
echo ""
