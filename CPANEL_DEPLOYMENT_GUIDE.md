# 🚀 Panduan Deployment ke cPanel Production

## 📋 Ringkasan Perubahan
Kami telah melakukan update besar-besaran pada website desa:
- ✅ Rebuild UI/UX dengan desain premium
- ✅ Mobile navigation slide-in panel
- ✅ System image fallback yang canggih
- ✅ Update artikel dengan judul dan gambar yang benar
- ✅ Enhanced typography dan animasi

## 🎯 Langkah Deployment di cPanel

### 1. Pull Changes dari Repository
```bash
cd /home/[username]/public_html/web-desa
git pull origin main
```

### 2. Clear All Caches
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
php artisan optimize:clear
```

### 3. Update Database Articles (PENTING!)
Jalankan script khusus untuk update artikel:
```bash
php cpanel-update-articles.php
```

### 4. Verify Images
Pastikan gambar artikel sudah ada di folder `public/img/`:
- ✅ `Penyaluran BLT DD.jpg`
- ✅ `Penetapan RKPDes.jpg` 
- ✅ `PENYULUHAN IVA TES.jpg`

### 5. Set Permissions (jika diperlukan)
```bash
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
```

## 🛠️ Troubleshooting

### Jika Perubahan Tidak Muncul:

#### A. Force Pull
```bash
git fetch --all
git reset --hard origin/main
```

#### B. Manual Cache Clear
```bash
rm -rf storage/framework/cache/data/*
rm -rf storage/framework/views/*
rm -rf bootstrap/cache/*.php
```

#### C. Manual Database Update
```bash
# Login ke database dan jalankan:
UPDATE artikel SET 
    judul = 'Penyaluran BLT DD Tahun Anggaran 2024',
    sampul = 'Penyaluran BLT DD.jpg'
WHERE id = (SELECT id FROM artikel ORDER BY created_at DESC LIMIT 1);

UPDATE artikel SET 
    judul = 'Musyawarah Desa Mekarmukti Bahas Penetapan RKPDes TA 2025',
    sampul = 'Penetapan RKPDes.jpg'
WHERE id = (SELECT id FROM artikel ORDER BY created_at DESC LIMIT 1 OFFSET 1);

UPDATE artikel SET 
    judul = 'Penyuluhan IVA & TES Pelayanan KB PKK DESA MEKARMUKTI',
    sampul = 'PENYULUHAN IVA TES.jpg'
WHERE id = (SELECT id FROM artikel ORDER BY created_at DESC LIMIT 1 OFFSET 2);
```

## 🔍 Verifikasi Deployment

### Check Git Status
```bash
git log --oneline -3
# Should show: DEPLOY: Add cPanel deployment scripts for article updates
```

### Check Database
```bash
php -r "
$pdo = new PDO('sqlite:database/database.sqlite');
$stmt = $pdo->query('SELECT judul, sampul FROM artikel ORDER BY created_at DESC LIMIT 3');
while (\$row = \$stmt->fetch(PDO::FETCH_ASSOC)) {
    echo 'Judul: ' . \$row['judul'] . ' | Sampul: ' . \$row['sampul'] . PHP_EOL;
}
"
```

### Check Website
1. Buka homepage - pastikan 3 artikel terbaru muncul dengan judul yang benar
2. Test mobile navigation - hamburger menu harus buka slide panel
3. Pastikan gambar artikel muncul (bukan placeholder)

## 📱 Fitur Baru yang Harus Berfungsi

### Mobile Navigation
- Hamburger menu membuka slide panel dari kanan
- Panel dengan glass morphism effect
- Navigation links berfungsi sempurna

### Image System  
- Gambar artikel otomatis fallback ke placeholder jika tidak ada
- Placeholder dengan warna tema yang sesuai
- Aspect ratio terjaga di semua device

### Article Display
- Homepage menampilkan 3 artikel terbaru dengan benar:
  1. **Penyaluran BLT DD Tahun Anggaran 2024**
  2. **Musyawarah Desa Mekarmukti Bahas Penetapan RKPDes TA 2025**  
  3. **Penyuluhan IVA & TES Pelayanan KB PKK DESA MEKARMUKTI**

## ⚠️ Important Notes

1. **Database SQLite**: Pastikan file `database/database.sqlite` memiliki permission yang benar
2. **Images**: Upload manual gambar artikel jika belum ada di `public/img/`
3. **Cache**: Selalu clear cache setelah pull changes
4. **PHP Version**: Pastikan menggunakan PHP 8.1+ untuk Laravel 11

## 🆘 Jika Masih Bermasalah

Jalankan script deployment otomatis:
```bash
bash deploy-real-data.sh
```

Atau hubungi developer untuk debugging lebih lanjut.

---
**Last Updated**: Agustus 2025  
**Version**: Production v2.0  
**Status**: ✅ Ready for Deployment
