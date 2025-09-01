# UMKM Image Fix & Deployment Guide

## Masalah yang Diperbaiki
- Gambar produk UMKM tidak muncul karena path database NULL
- View fallback logic tidak sesuai dengan pola APBDes
- Directory structure belum sesuai standar

## Solusi yang Diterapkan

### 1. Database Update
```bash
# Tambah sample images ke produk UMKM
php add_umkm_images.php
```

### 2. Directory Structure
```
public/
├── img/
│   ├── umkm/           # ✅ NEW: UMKM images (mirror APBDes pattern)
│   ├── apbdes/         # ✅ APBDes images
│   └── other-images...
└── storage/            # ✅ Laravel storage symlink
    └── umkm/           # ✅ Fallback untuk old images
```

### 3. Controller Adaptation (ProdukUmkmController)
- ✅ Store images ke `public/img/umkm/` dengan naming pattern `timestamp_random.ext`
- ✅ Database menyimpan path relatif: `img/umkm/filename.jpg`
- ✅ Delete old image pada update
- ✅ Delete image file pada destroy
- ✅ Helper method `deleteImageIfExists()` untuk cleanup

### 4. View Logic Update
Pattern baru (semua view):
```php
@if($produk->gambar && file_exists(public_path($produk->gambar)))
<img src="{{ asset($produk->gambar) }}" alt="{{ $produk->nama_produk }}">
@elseif($produk->gambar && file_exists(public_path('storage/' . $produk->gambar)))
<img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama_produk }}">
@else
<div class="no-image">
    <i class="fas fa-image"></i>
</div>
@endif
```

## Files Modified
- ✅ `app/Http/Controllers/ProdukUmkmController.php`
- ✅ `resources/views/produk-umkm.blade.php`
- ✅ `resources/views/produk-umkm-show.blade.php`  
- ✅ `resources/views/admin/produk-umkm/index.blade.php`
- ✅ `resources/views/admin/produk-umkm/show.blade.php`
- ✅ `resources/views/admin/produk-umkm/edit.blade.php`

## Debug Tools Created
- `debug_umkm_images.php` - Check database & file paths
- `add_umkm_images.php` - Add sample images to products

## Deployment untuk cPanel

### 1. Upload Files
```bash
# Upload semua perubahan ke cPanel
git pull origin main
```

### 2. Directory Permissions
```bash
chmod 775 public/img/umkm/
chmod 775 storage/app/public/umkm/
```

### 3. Verify Images
```bash
php debug_umkm_images.php
```

### 4. Sample Data (jika diperlukan)
```bash
php add_umkm_images.php
```

## Commit Info
- **Commit ID**: b155112
- **Message**: "Adapt UMKM image handling to mirror APBDes (public/img/umkm + cleanup)"
- **Date**: September 1, 2025

## Testing Checklist
- ✅ Public UMKM listing shows images
- ✅ Public UMKM detail shows images  
- ✅ Admin UMKM listing shows images
- ✅ Admin UMKM detail shows images
- ✅ Admin UMKM edit preview works
- ✅ New image upload saves to correct path
- ✅ Old image deletion works on update
- ✅ Image deletion works on product destroy

## Production Notes
- Images sekarang konsisten dengan pola APBDes
- Path database: `img/umkm/filename.jpg` (relatif dari public/)
- Backward compatible dengan storage disk pattern
- WhatsApp integration tetap berfungsi
- Pagination dan search tetap normal
