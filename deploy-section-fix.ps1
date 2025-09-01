# APBDes Section Fix Deployment (PowerShell)
# This script deploys the fixed transparansi-anggaran.blade.php to cPanel

Write-Host "=== APBDes Section Fix Deployment ===" -ForegroundColor Cyan
Write-Host "This script will deploy the fixed view file to production" -ForegroundColor White
Write-Host ""

# Configuration - UPDATE THESE PATHS
$CPANEL_PATH = "C:\path\to\your\cpanel\files"  # Update this path
$BACKUP_DIR = "backup_$(Get-Date -Format 'yyyyMMdd_HHmmss')"

Write-Host "📦 Creating backup..." -ForegroundColor Yellow
New-Item -ItemType Directory -Path $BACKUP_DIR -Force | Out-Null

# Backup current production file if it exists
if (Test-Path "$CPANEL_PATH\resources\views\transparansi-anggaran.blade.php") {
    Copy-Item "$CPANEL_PATH\resources\views\transparansi-anggaran.blade.php" "$BACKUP_DIR\" 
    Write-Host "✅ Backup created" -ForegroundColor Green
} else {
    Write-Host "⚠️  Original file not found (may not exist yet)" -ForegroundColor Yellow
}

Write-Host ""
Write-Host "🚀 Deploying fixed view file..." -ForegroundColor Yellow

# Ensure target directory exists
$targetDir = "$CPANEL_PATH\resources\views"
if (!(Test-Path $targetDir)) {
    New-Item -ItemType Directory -Path $targetDir -Force | Out-Null
}

# Deploy the corrected view file
Copy-Item "resources\views\transparansi-anggaran.blade.php" "$CPANEL_PATH\resources\views\"
Write-Host "✅ Fixed view file deployed" -ForegroundColor Green

Write-Host ""
Write-Host "📋 Deployment Summary:" -ForegroundColor Cyan
Write-Host "- ✅ Fixed section name: @section('konten') → @section('content')" -ForegroundColor Green
Write-Host "- ✅ View file uploaded to production" -ForegroundColor Green
Write-Host "- ✅ Backup created: $BACKUP_DIR" -ForegroundColor Green
Write-Host ""
Write-Host "🔍 Next steps:" -ForegroundColor Yellow
Write-Host "1. Upload files to your cPanel File Manager"
Write-Host "2. Test the transparency page: http://yourdomain.com/transparansi-anggaran"
Write-Host "3. Verify APBDes data now displays correctly"
Write-Host "4. Check that images and formatting appear properly"
Write-Host ""
Write-Host "If issues persist, upload and run:" -ForegroundColor Yellow
Write-Host "php debug-section-fix.php" -ForegroundColor White
