#!/bin/bash

# APBDes Image Fix - Simple cPanel Deployment Script
# This script helps deploy the fix for APBDes image display issues

echo "========================================="
echo "APBDes Image Display Fix - cPanel Deploy"
echo "========================================="
echo

# Check if we're in the right directory
if [ ! -f "fix-laravel-env.php" ]; then
    echo "❌ Error: fix-laravel-env.php not found"
    echo "Please run this script from the web-desa directory"
    exit 1
fi

echo "✅ Found debugging tools in current directory"
echo

# Display files to be deployed
echo "Files ready for deployment:"
echo "- fix-laravel-env.php (Laravel environment fix)"
echo "- debug-web-access.php (comprehensive web access testing)"
echo "- serve-image.php (PHP image serving bypass)"
echo "- copy-apbdes-to-images.php (image migration tool)"
echo

# Instructions for cPanel deployment
echo "========================================="
echo "DEPLOYMENT INSTRUCTIONS"
echo "========================================="
echo

echo "1. Upload files to cPanel:"
echo "   - Go to cPanel → File Manager"
echo "   - Navigate to public_html (or your main directory)"
echo "   - Upload these files:"
echo "     * fix-laravel-env.php"
echo "     * debug-web-access.php" 
echo "     * serve-image.php"
echo "     * copy-apbdes-to-images.php"
echo

echo "2. Set file permissions to 644"
echo

echo "3. Run the Laravel environment fix:"
echo "   Open: https://your-domain.com/fix-laravel-env.php"
echo

echo "4. Check the output and update your .env file:"
echo "   Set: APP_URL=https://your-actual-domain.com"
echo

echo "5. Clear Laravel cache (if possible via terminal or create script):"
echo "   php artisan config:cache"
echo "   php artisan route:cache"
echo "   php artisan view:cache"
echo

echo "6. Test the APBDes transparency page:"
echo "   https://your-domain.com/transparansi-anggaran"
echo

echo "========================================="
echo "TROUBLESHOOTING"
echo "========================================="
echo

echo "If images still don't display:"
echo

echo "A. Test web server access:"
echo "   https://your-domain.com/debug-web-access.php"
echo

echo "B. Use PHP image serving:"
echo "   https://your-domain.com/serve-image.php?img=filename.jpg"
echo

echo "C. Run image migration again:"
echo "   https://your-domain.com/copy-apbdes-to-images.php"
echo

echo "========================================="
echo "EXPECTED RESULTS"
echo "========================================="
echo

echo "Before fix:"
echo "❌ Image URLs: https://:/images/apbdes/filename.jpg"
echo "❌ Browser console errors"
echo "❌ Broken image icons"
echo

echo "After fix:"
echo "✅ Image URLs: https://your-domain.com/images/apbdes/filename.jpg"
echo "✅ Images display properly"
echo "✅ APBDes transparency page fully functional"
echo

echo "========================================="
echo "DEPLOYMENT READY"
echo "========================================="
echo

echo "All files are prepared and ready for cPanel deployment."
echo "Follow the instructions above to complete the fix."
echo

# Show current git status
echo "Git status:"
git status --porcelain

echo
echo "To commit and push changes:"
echo "git add CPANEL_APBDES_IMAGE_FIX_DEPLOYMENT.md deploy-apbdes-image-fix.sh"
echo "git commit -m \"Add cPanel APBDes image fix deployment guide and script\""
echo "git push origin main"
echo
