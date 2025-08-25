# 🚀 Panduan Deployment ke cPanel

## 📝 Ringkasan Perubahan yang Sudah Dilakukan

### ✅ Perubahan Konfigurasi Laravel
1. **AppServiceProvider.php** - Disabled HTTPS forcing untuk development
2. **ViewServiceProvider.php** - Added safety checks untuk RW table
3. **.env** - Konfigurasi untuk SQLite dan HTTP localhost

### ✅ Perubahan Dependencies
1. **package.json** - Added Bootstrap 5, jQuery, Popper.js
2. **composer.json** - No changes (existing dependencies)

### ✅ Perubahan UI/Frontend  
1. **app.css** - Simplified navbar CSS, removed complex overrides
2. **app.blade.php** - Changed from Bootstrap navbar to template native navbar
3. **Image paths fixed** - Changed from `img\/` to `img/` in blade templates

### ✅ Data Migration
1. **Database** - Copied SQLite database with 6 articles
2. **Images** - Copied article images to `public/img/`

## 🏗️ Konfigurasi Khusus untuk cPanel

### 1. Environment Configuration
```bash
# File .env di cPanel harus menggunakan:
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

# Database (ubah ke MySQL di cPanel)
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_cpanel_db_name
DB_USERNAME=your_cpanel_db_user
DB_PASSWORD=your_cpanel_db_password
```

### 2. AppServiceProvider untuk Production
```php
// app/Providers/AppServiceProvider.php
public function boot(): void
{
    if (config('app.env') === 'production') {
        URL::forceScheme('https');
    }
    // URL::forceScheme('https'); // Disabled for local development
}
```

### 3. File Structure di cPanel
```
public_html/
├── index.php (dari Laravel public/)
├── .htaccess (dari Laravel public/)  
├── assets/ (copy template assets)
├── img/ (copy article images)
├── build/ (hasil npm run build)
└── storage/ (link ke ../storage/app/public)

Laravel App (di luar public_html):
├── app/
├── bootstrap/
├── config/
├── database/
├── resources/
├── routes/
├── storage/
└── vendor/
```

## 🔧 Langkah-Langkah Deployment

### Phase 1: Persiapan Files
1. **Build Production Assets**
   ```bash
   npm run build
   ```

2. **Optimize Laravel**
   ```bash
   php artisan config:cache
   php artisan route:cache  
   php artisan view:cache
   ```

### Phase 2: Upload ke cPanel
1. Upload seluruh folder Laravel KECUALI `public/` ke direktori di luar `public_html`
2. Copy isi folder `public/` ke `public_html/`
3. Update `public_html/index.php` path ke Laravel bootstrap

### Phase 3: Database Setup
1. Create MySQL database di cPanel
2. Import/migrate data dari SQLite ke MySQL
3. Update .env dengan kredensial MySQL

### Phase 4: Permissions & Links
```bash
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
php artisan storage:link
```

## 🚨 Masalah Potensial & Solusi

### 1. HTTPS SSL Issues
**Masalah**: Force HTTPS di production bisa menyebabkan redirect loop
**Solusi**: Conditional HTTPS forcing berdasarkan environment

### 2. Asset Build Issues  
**Masalah**: Node modules tidak tersedia di cPanel
**Solusi**: Build di local, upload hasil build

### 3. File Permissions
**Masalah**: 500 Internal Server Error karena permission
**Solusi**: Set correct permissions (755 untuk direktori, 644 untuk file)

### 4. Database Connection
**Masalah**: SQLite tidak tersedia di shared hosting  
**Solusi**: Migrate ke MySQL sebelum upload

## 🔄 Backup & Rollback Plan

### Backup Current State (SUDAH DI REPO GITHUB)
```bash
# Repo GitHub: kkn20mekarmukti2-droid/web-desa
# Branch: main  
# Commit terakhir sebelum perubahan: initial commit
```

### Rollback Commands (Jika Diperlukan)
```bash
# Reset ke commit sebelum perubahan
git log --oneline
git reset --hard [commit-hash-awal]

# Atau restore specific files
git checkout [commit-hash] -- app/Providers/AppServiceProvider.php
git checkout [commit-hash] -- resources/views/layout/app.blade.php  
git checkout [commit-hash] -- resources/css/app.css
```

## 🧪 Testing Checklist

### Local Testing
- [x] Navbar muncul dan berfungsi
- [x] Dropdown menu bekerja  
- [x] Mobile navigation responsive
- [x] Article images tampil
- [x] Modal form pengaduan berfungsi

### Production Testing (cPanel)
- [ ] SSL certificate valid
- [ ] All routes accessible
- [ ] Static assets loading (CSS/JS/Images)
- [ ] Database connection working
- [ ] File upload permissions
- [ ] Mobile responsive
- [ ] Cross-browser compatibility

## 📞 Emergency Contacts
- **Developer**: GitHub Copilot
- **Repo**: kkn20mekarmukti2-desa/web-desa
- **Backup Location**: GitHub repository main branch
