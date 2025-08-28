# PowerShell Script untuk Deploy Statistik ke cPanel
Write-Host "==========================================" -ForegroundColor Green
Write-Host "DEPLOY STATISTIK SYSTEM TO CPANEL" -ForegroundColor Green  
Write-Host "==========================================" -ForegroundColor Green

# Manual deployment checklist
Write-Host "`n🔧 MANUAL DEPLOYMENT STEPS:" -ForegroundColor Yellow
Write-Host "1. Upload files via cPanel File Manager atau FTP:" -ForegroundColor White

$filesToUpload = @(
    "database/migrations/2025_08_28_112020_create_statistik_table.php",
    "app/Models/StatistikModel.php", 
    "app/Http/Controllers/StatistikController.php",
    "resources/views/admin/statistik/ (folder lengkap)",
    "routes/web.php",
    "app/Http/Controllers/dataController.php",
    "resources/views/layout/admin.blade.php",
    "database/seeders/StatistikSeeder.php"
)

foreach ($file in $filesToUpload) {
    Write-Host "   - $file" -ForegroundColor Cyan
}

Write-Host "`n2. SSH ke cPanel dan jalankan perintah:" -ForegroundColor White
$commands = @(
    "cd /home/mekh7277/public_html",
    "php artisan migrate",
    "php artisan db:seed --class=StatistikSeeder", 
    "php artisan route:clear",
    "php artisan config:clear",
    "php artisan cache:clear"
)

foreach ($cmd in $commands) {
    Write-Host "   $cmd" -ForegroundColor Cyan
}

Write-Host "`n3. Test akses:" -ForegroundColor White
Write-Host "   https://mekarmukti.id/admin/statistik" -ForegroundColor Cyan

Write-Host "`n🚀 SHORTCUT - Commit & Push dulu:" -ForegroundColor Yellow
Write-Host "git add -A && git commit -m 'Cleanup legacy data & prepare production deploy' && git push" -ForegroundColor Cyan

Write-Host "`nKemudian di cPanel bisa git pull untuk update otomatis!" -ForegroundColor Green
Write-Host "==========================================" -ForegroundColor Green
