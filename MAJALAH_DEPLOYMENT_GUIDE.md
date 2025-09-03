# 📚 Dokumentasi Deployment Sistem Majalah Digital

## 🎯 Overview
Sistem Majalah Digital untuk Website Desa Mekarmukti dengan fitur flipbook interaktif dan admin management yang lengkap.

## 🗂️ File Deployment

### 1. **majalah-tables-deployment.sql**
Script SQL lengkap untuk membuat tabel database dengan sample data.

### 2. **cpanel-deploy-majalah.sh** 
Script bash untuk deployment otomatis di server Linux/cPanel.

### 3. **deploy-majalah.php**
Script PHP web-based untuk deployment via browser (recommended untuk cPanel).

## 🚀 Metode Deployment

### **Metode 1: Web Deployment (Recommended untuk cPanel)**

1. **Upload files** ke server:
   ```
   - majalah-tables-deployment.sql
   - deploy-majalah.php
   ```

2. **Akses via browser**:
   ```
   https://yoursite.com/deploy-majalah.php
   ```

3. **Klik tombol deploy** dan ikuti instruksi

4. **Hapus file deploy** setelah selesai untuk keamanan

### **Metode 2: Manual Database Import**

1. **Buka phpMyAdmin** atau database manager

2. **Import SQL file**:
   ```sql
   -- Import majalah-tables-deployment.sql
   ```

3. **Buat direktori storage**:
   ```bash
   mkdir -p storage/app/public/majalah
   mkdir -p storage/app/public/majalah/pages
   chmod -R 755 storage/
   ```

4. **Create symbolic link**:
   ```bash
   php artisan storage:link
   ```

### **Metode 3: SSH/Terminal (Linux Server)**

1. **Upload script**:
   ```bash
   chmod +x cpanel-deploy-majalah.sh
   ```

2. **Set environment variables**:
   ```bash
   export DB_USER=your_db_user
   export DB_PASS=your_db_password
   export DB_NAME=your_db_name
   ```

3. **Run deployment**:
   ```bash
   ./cpanel-deploy-majalah.sh
   ```

## 📋 Database Schema

### **Table: majalah**
```sql
- id (PRIMARY KEY)
- judul (VARCHAR 255)
- deskripsi (TEXT)
- cover_image (VARCHAR 255)
- tanggal_terbit (DATE)
- is_active (BOOLEAN)
- created_at, updated_at (TIMESTAMPS)
```

### **Table: majalah_pages**
```sql
- id (PRIMARY KEY)
- majalah_id (FOREIGN KEY → majalah.id)
- page_number (INTEGER)
- image_path (VARCHAR 255)
- title (VARCHAR 255, nullable)
- description (TEXT, nullable)
- created_at, updated_at (TIMESTAMPS)
```

## 📁 Directory Structure

```
storage/app/public/
├── majalah/
│   ├── sample-cover.jpg
│   ├── sample-cover-2.jpg
│   └── pages/
│       ├── 1/
│       │   ├── page-1.jpg
│       │   ├── page-2.jpg
│       │   └── ...
│       └── 2/
│           ├── page-1.jpg
│           └── ...
```

## 🔧 Post-Deployment Setup

### **1. Upload Sample Images**
Untuk testing, upload gambar sample ke:
- `storage/app/public/majalah/sample-cover.jpg`
- `storage/app/public/majalah/pages/1/page-1.jpg` (dst.)

### **2. Test Access Points**

**Admin Panel:**
```
https://yoursite.com/admin/majalah
```

**Public View:**
```
https://yoursite.com/majalah-desa
```

**API Endpoint:**
```
https://yoursite.com/api/majalah/{id}/pages
```

### **3. Verify Navigation**

**Admin Sidebar:**
- Menu "Majalah Desa" harus muncul di sidebar admin

**Public Navbar:**
- Menu "Majalah Desa" di dropdown "Informasi Desa"

**Homepage:**
- Section majalah teaser setelah berita

## ✅ Testing Checklist

### **Admin Features:**
- [ ] Login ke admin panel
- [ ] Akses `/admin/majalah`
- [ ] Create new magazine
- [ ] Upload cover image
- [ ] Upload multiple pages
- [ ] Edit magazine content
- [ ] Toggle magazine status
- [ ] Delete magazine
- [ ] View magazine detail

### **Public Features:**
- [ ] Akses `/majalah-desa`
- [ ] View magazine grid
- [ ] Click "Baca Sekarang"
- [ ] Test flipbook navigation
- [ ] Test on mobile device
- [ ] Check homepage teaser

### **Integration:**
- [ ] Navigation menus working
- [ ] Image uploads successful
- [ ] API endpoints responding
- [ ] File permissions correct
- [ ] Database relationships intact

## 🛠️ Troubleshooting

### **Database Issues:**
```sql
-- Check tables exist
SHOW TABLES LIKE 'majalah%';

-- Check sample data
SELECT * FROM majalah;
SELECT * FROM majalah_pages;
```

### **Storage Issues:**
```bash
# Check permissions
ls -la storage/app/public/

# Fix permissions
chmod -R 755 storage/
chown -R www-data:www-data storage/

# Recreate symlink
rm public/storage
php artisan storage:link
```

### **Image Upload Issues:**
```php
// Check PHP upload settings
echo ini_get('upload_max_filesize');
echo ini_get('post_max_size');
echo ini_get('max_file_uploads');
```

### **Turn.js Issues:**
```javascript
// Check console for errors
console.log('Turn.js loaded:', typeof $.fn.turn);

// Verify CDN
https://cdn.jsdelivr.net/npm/turn.js@3.0.2/turn.min.js
```

## 🔐 Security Notes

1. **Delete deployment files** after use:
   - `deploy-majalah.php`
   - `cpanel-deploy-majalah.sh`

2. **Set proper permissions**:
   ```bash
   find storage -type f -exec chmod 644 {} \;
   find storage -type d -exec chmod 755 {} \;
   ```

3. **Environment variables**:
   - Ensure `.env` has secure database credentials
   - Never expose database passwords

## 📞 Support

Jika mengalami masalah deployment:

1. **Check Laravel logs**: `storage/logs/laravel.log`
2. **Check web server logs**: Apache/Nginx error logs
3. **Verify PHP version**: Minimum PHP 8.1
4. **Check database connection**: Test via tinker or phpMyAdmin

## 🎉 Success Indicators

✅ **Admin panel accessible**
✅ **Magazine CRUD working**
✅ **File uploads successful**
✅ **Public flipbook functional**
✅ **Navigation menus updated**
✅ **Homepage teaser displayed**
✅ **Mobile responsive**
✅ **No console errors**

---

**🚀 Happy Publishing!** 
*Sistem Majalah Digital Desa Mekarmukti*
