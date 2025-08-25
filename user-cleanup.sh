#!/bin/bash
# =====================================================
# USER CLEANUP SCRIPT
# Remove duplicate admin accounts safely
# =====================================================

echo "🧹 User Cleanup Script"
echo "====================="

cd /home/mekh7277/web-desa

echo "📋 Current Users:"
php artisan tinker --execute="
\$users = App\Models\User::orderBy('id')->get();
echo 'Total users: ' . \$users->count() . PHP_EOL . PHP_EOL;
foreach(\$users as \$user) {
    \$articles = App\Models\artikelModel::where('user_id', \$user->id)->count();
    echo 'ID: ' . \$user->id . ' | ' . \$user->name . ' | ' . \$user->email . ' | Articles: ' . \$articles . PHP_EOL;
}
"

echo ""
echo "🎯 CLEANUP OPTIONS:"
echo "1. Dry run - Show recommendations only"
echo "2. Remove safe duplicates (no articles)"
echo "3. Create admin@webdesa.com and migrate all"
echo "4. Advanced cleanup (interactive)"
echo "5. Cancel"

read -p "Choose option (1-5): " choice

case $choice in
    1)
        echo "🔍 Running dry-run analysis..."
        php artisan admin:cleanup-users --dry-run
        ;;
    2)
        echo "🧹 Removing safe duplicates..."
        echo "⚠️  This will delete users with NO articles and duplicate names"
        read -p "Continue? (y/N): " confirm
        if [[ $confirm =~ ^[Yy]$ ]]; then
            php artisan admin:cleanup-users
            # Auto-select option 2 in interactive mode
        else
            echo "Cancelled."
        fi
        ;;
    3)
        echo "🎯 Creating standard admin@webdesa.com..."
        echo "This will:"
        echo "  - Create admin@webdesa.com if not exists"
        echo "  - Migrate all articles to this account"
        echo "  - Delete other admin accounts"
        echo ""
        read -p "This is a major change. Continue? (y/N): " confirm
        if [[ $confirm =~ ^[Yy]$ ]]; then
            php artisan tinker --execute="
            // Create standard admin
            \$admin = App\Models\User::firstOrCreate(
                ['email' => 'admin@webdesa.com'],
                [
                    'name' => 'Admin Desa Mekarmukti',
                    'password' => Hash::make('admin123'),
                    'email_verified_at' => now()
                ]
            );
            echo 'Admin account: ' . \$admin->email . PHP_EOL;
            
            // Migrate articles
            \$migrated = App\Models\artikelModel::where('user_id', '!=', \$admin->id)->update(['user_id' => \$admin->id]);
            echo 'Articles migrated: ' . \$migrated . PHP_EOL;
            
            // Delete other users
            \$deleted = App\Models\User::where('id', '!=', \$admin->id)->delete();
            echo 'Users deleted: ' . \$deleted . PHP_EOL;
            
            echo 'COMPLETED! Use admin@webdesa.com / admin123' . PHP_EOL;
            "
        else
            echo "Cancelled."
        fi
        ;;
    4)
        echo "🛠️  Running advanced cleanup..."
        php artisan admin:cleanup-users
        ;;
    5)
        echo "Cancelled."
        exit 0
        ;;
    *)
        echo "❌ Invalid option"
        exit 1
        ;;
esac

echo ""
echo "✅ Cleanup process finished!"
echo ""
echo "📊 Final user count:"
php artisan tinker --execute="echo 'Total users: ' . App\Models\User::count();"
