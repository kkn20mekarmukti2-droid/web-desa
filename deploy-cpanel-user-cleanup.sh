#!/bin/bash

echo "=== CPANEL PRODUCTION USER CLEANUP DEPLOYMENT ==="
echo "This script will deploy and run user cleanup on cPanel production server"
echo ""

# Set production environment variables
export DB_CONNECTION=mysql
export APP_ENV=production

echo "Step 1: Uploading cleanup script to cPanel..."
echo "Please upload 'cpanel-user-cleanup-production.php' to your cPanel public_html directory"
echo ""

echo "Step 2: SSH to your cPanel server and run these commands:"
echo ""
echo "# Navigate to your domain directory"
echo "cd public_html"
echo ""
echo "# Make sure the script has proper permissions"
echo "chmod +x cpanel-user-cleanup-production.php"
echo ""
echo "# Run the production user cleanup"
echo "php cpanel-user-cleanup-production.php"
echo ""
echo "Alternative: If you have terminal access through cPanel File Manager:"
echo "1. Go to cPanel File Manager"
echo "2. Navigate to public_html directory"
echo "3. Upload cpanel-user-cleanup-production.php"
echo "4. Right-click the file and select 'Execute' or use Terminal"
echo "5. Run: php cpanel-user-cleanup-production.php"
echo ""
echo "=== EXPECTED RESULTS ==="
echo "- Production database will show only 2 users"
echo "- ASFHA NUGRAHA ARIFIN (admin@webdesa.com) with Admin role"
echo "- Mohammad Nabil Abyyu (writer@webdesa.com) with Writer role"
echo "- All other 5 users will be removed from production database"
echo ""
echo "=== VERIFICATION ==="
echo "After running the script, check your phpMyAdmin to verify:"
echo "1. Log into cPanel phpMyAdmin"
echo "2. Select your database"
echo "3. Browse the 'users' table"
echo "4. Confirm only 2 users remain"
echo ""

# Create a simple verification script for cPanel
cat > cpanel-verify-users.php << 'EOF'
<?php
// Simple verification script for cPanel
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
putenv('DB_CONNECTION=mysql');
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;

echo "=== PRODUCTION DATABASE USER VERIFICATION ===" . PHP_EOL;
$users = User::all();
echo "Total users: " . $users->count() . PHP_EOL;
foreach ($users as $user) {
    $role = $user->role == 0 ? 'Admin' : 'Writer';
    echo "- {$user->name} ({$user->email}) - {$role}" . PHP_EOL;
}
?>
EOF

echo "Created verification script: cpanel-verify-users.php"
echo "You can also upload and run this to check the results"
echo ""
echo "=== CLEANUP SCRIPT READY ==="
echo "Files created:"
echo "1. cpanel-user-cleanup-production.php (main cleanup script)"
echo "2. cpanel-verify-users.php (verification script)"
echo ""
echo "Next steps:"
echo "1. Upload both files to your cPanel"
echo "2. Run the cleanup script via SSH or cPanel terminal"
echo "3. Run the verification script to confirm results"
echo "4. Check phpMyAdmin to visually verify the cleanup"
