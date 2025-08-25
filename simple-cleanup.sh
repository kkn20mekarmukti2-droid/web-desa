#!/bin/bash
# =======================================================
# CPANEL SIMPLE USER CLEANUP - FIXED VERSION
# Khusus untuk menghapus duplikat admin dengan aman
# =======================================================

clear
echo "🧹 WEB DESA - QUICK USER CLEANUP (FIXED)"
echo "========================================"
echo ""

cd /home/mekh7277/web-desa

echo "👥 CURRENT USERS:"
echo "=================="
php artisan tinker --execute="
\$users = App\Models\User::orderBy('id')->get();
echo 'Total: ' . \$users->count() . ' users' . PHP_EOL;
echo str_repeat('-', 50) . PHP_EOL;
foreach(\$users as \$user) {
    \$articles = App\Models\artikelModel::where('created_by', \$user->id)->count();
    echo 'ID: ' . \$user->id . ' | ' . \$user->name . ' | ' . \$user->email . ' | Articles: ' . \$articles . PHP_EOL;
}
echo str_repeat('-', 50) . PHP_EOL;
"

echo ""
echo "🎯 QUICK ACTIONS:"
echo "================="
echo "1. Delete Rasyid duplicates (keep first one)"
echo "2. Create ONE admin@webdesa.com (delete all others)"
echo "3. Just show users"
echo "4. Exit"
echo ""

read -p "Choose (1-4): " choice

case $choice in
    1)
        echo ""
        echo "🗑️  DELETING RASYID DUPLICATES..."
        echo "================================"
        
        php artisan tinker --execute="
        \$rasyids = App\Models\User::where('name', 'like', '%Rasyid%')->orderBy('id')->get();
        echo 'Found ' . \$rasyids->count() . ' Rasyid accounts' . PHP_EOL;
        
        if(\$rasyids->count() > 1) {
            \$keep = \$rasyids->first();
            echo 'KEEPING: ID ' . \$keep->id . ' - ' . \$keep->email . PHP_EOL;
            
            foreach(\$rasyids->slice(1) as \$delete) {
                echo 'DELETING: ID ' . \$delete->id . ' - ' . \$delete->email;
                
                // Migrate articles if any
                \$articles1 = App\Models\artikelModel::where('created_by', \$delete->id)->count();
                \$articles2 = App\Models\artikelModel::where('updated_by', \$delete->id)->count();
                
                if(\$articles1 > 0) {
                    App\Models\artikelModel::where('created_by', \$delete->id)->update(['created_by' => \$keep->id]);
                    echo ' - Migrated ' . \$articles1 . ' created articles';
                }
                
                if(\$articles2 > 0) {
                    App\Models\artikelModel::where('updated_by', \$delete->id)->update(['updated_by' => \$keep->id]);
                    echo ' - Migrated ' . \$articles2 . ' updated articles';
                }
                
                \$delete->delete();
                echo ' - DELETED!' . PHP_EOL;
            }
        } else {
            echo 'No duplicates found.' . PHP_EOL;
        }
        "
        ;;
        
    2)
        echo ""
        echo "🎯 CREATING SINGLE ADMIN ACCOUNT..."
        echo "=================================="
        echo "⚠️  This will DELETE ALL current users and create admin@webdesa.com"
        echo ""
        read -p "Continue? (y/N): " confirm
        
        if [[ $confirm =~ ^[Yy]$ ]]; then
            php artisan tinker --execute="
            // Create admin
            \$admin = App\Models\User::firstOrCreate(
                ['email' => 'admin@webdesa.com'],
                [
                    'name' => 'Admin Desa Mekarmukti',
                    'password' => Hash::make('admin123'),
                    'email_verified_at' => now()
                ]
            );
            echo '✅ Admin created: ' . \$admin->email . ' (ID: ' . \$admin->id . ')' . PHP_EOL;
            
            // Migrate articles
            \$migrated1 = App\Models\artikelModel::where('created_by', '!=', \$admin->id)->update(['created_by' => \$admin->id]);
            \$migrated2 = App\Models\artikelModel::where('updated_by', '!=', \$admin->id)->update(['updated_by' => \$admin->id]);
            echo '✅ Migrated articles: ' . (\$migrated1 + \$migrated2) . PHP_EOL;
            
            // Delete others
            \$others = App\Models\User::where('id', '!=', \$admin->id)->get();
            foreach(\$others as \$user) {
                echo '🗑️  Deleting: ' . \$user->email . PHP_EOL;
                \$user->delete();
            }
            
            echo PHP_EOL . '🎉 SUCCESS! Login: admin@webdesa.com / admin123' . PHP_EOL;
            "
        else
            echo "Cancelled."
        fi
        ;;
        
    3)
        echo ""
        echo "📋 USER LIST:"
        echo "============="
        php artisan tinker --execute="
        \$users = App\Models\User::all();
        foreach(\$users as \$user) {
            \$articles = App\Models\artikelModel::where('created_by', \$user->id)->count();
            echo \$user->id . '. ' . \$user->name . ' (' . \$user->email . ') - ' . \$articles . ' articles' . PHP_EOL;
        }
        "
        ;;
        
    4)
        echo "👋 Bye!"
        exit 0
        ;;
        
    *)
        echo "❌ Invalid choice"
        exit 1
        ;;
esac

echo ""
echo "📊 FINAL COUNT:"
echo "==============="
php artisan tinker --execute="
\$total = App\Models\User::count();
\$articles = App\Models\artikelModel::count();
echo 'Users: ' . \$total . PHP_EOL;
echo 'Articles: ' . \$articles . PHP_EOL;
"

echo ""
echo "✅ Cleanup completed!"
echo "🔐 All passwords: admin123"
