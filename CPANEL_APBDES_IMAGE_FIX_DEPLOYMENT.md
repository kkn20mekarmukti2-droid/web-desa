# cPanel APBDes Image Display Fix - Complete Deployment Guide

## Issue Analysis
APBDes transparency page data displays correctly but images don't show. Files exist in `/public/images/apbdes/` but Laravel's `asset()` helper generates malformed URLs like `https://:/images/apbdes/...` (missing domain).

## Root Cause
Laravel APP_URL configuration issue causing `asset()` helper to generate incomplete URLs.

## Deployment Steps

### Step 1: Deploy New Files via cPanel File Manager
1. Upload these files to your main directory:
   - `fix-laravel-env.php` (Laravel environment diagnostics)
   - `debug-web-access.php` (comprehensive web access testing)
   - `serve-image.php` (PHP image serving bypass)

### Step 2: Run Laravel Environment Fix
```
https://your-domain.com/fix-laravel-env.php
```

This will:
- ✅ Check current APP_URL configuration
- ✅ Detect your actual domain automatically
- ✅ Test APBDes image asset() URLs
- ✅ Provide corrected .env configuration
- ✅ Show before/after comparison

### Step 3: Update .env File
Based on fix-laravel-env.php results, update your `.env` file:
```env
APP_URL=https://your-actual-domain.com
```

### Step 4: Clear Laravel Cache
Run in cPanel Terminal or create a cache clearing script:
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Step 5: Verify Fix
1. Check APBDes transparency page: `https://your-domain.com/transparansi-anggaran`
2. Right-click → Inspect Element on broken images
3. Verify URLs now show: `https://your-domain.com/images/apbdes/filename.jpg`

## Troubleshooting Tools

### If Images Still Don't Display:

#### Option A: Test Web Server Access
```
https://your-domain.com/debug-web-access.php
```
Tests:
- Direct file URLs
- Directory permissions
- Server configuration
- .htaccess interference

#### Option B: Use PHP Image Serving
```
https://your-domain.com/serve-image.php?img=filename.jpg
```
Bypasses server restrictions by serving images through PHP.

#### Option C: Manual Image URL Test
Direct test: `https://your-domain.com/images/apbdes/9OdAq4f094fCgaHf6nwdi5JpIZyBRiVbOD6yAmje.jpg`

## Expected Results

### Before Fix:
- ❌ Image URLs: `https://:/images/apbdes/filename.jpg`
- ❌ Browser console: Failed to load resource
- ❌ Images show as broken

### After Fix:
- ✅ Image URLs: `https://your-domain.com/images/apbdes/filename.jpg`
- ✅ Images load properly
- ✅ APBDes transparency page fully functional

## File Locations Verified:
- ✅ Images copied to: `/public/images/apbdes/`
- ✅ File permissions: 0644
- ✅ File size confirmed: 255,928 bytes
- ✅ Path pattern matches working systems (berita, struktur)

## Quick Deployment Commands

### Upload via cPanel File Manager:
1. Go to cPanel → File Manager
2. Navigate to `public_html` or main directory
3. Upload: `fix-laravel-env.php`, `debug-web-access.php`, `serve-image.php`
4. Set file permissions to 644

### Test Sequence:
```
1. https://your-domain.com/fix-laravel-env.php
2. Update .env with correct APP_URL
3. Clear Laravel cache
4. Test: https://your-domain.com/transparansi-anggaran
5. If still broken: https://your-domain.com/debug-web-access.php
```

## Success Indicators:
- APBDes page loads with visible images
- Browser console shows no 404 errors
- Image URLs contain proper domain name
- Document thumbnails display correctly

This comprehensive fix addresses the Laravel environment configuration issue that's preventing APBDes images from displaying correctly.
