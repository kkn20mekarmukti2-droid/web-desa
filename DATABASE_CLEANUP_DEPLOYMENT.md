# Database Cleanup Deployment Guide

## 📊 What Was Changed
- **Database cleanup**: Removed 21 duplicate/legacy records from statistik table
- **Real data population**: Added actual RT/RW/KK counts from imported mekh7277_desa database
- **Fixed display**: RT/RW now shows counts (12 RT, 4 RW) instead of population numbers
- **Clean structure**: Only 4 essential statistical records remain

## 🎯 Final Data Structure
```
RT/RW Data:
- Total RT: 12 (Rukun Tetangga)
- Total RW: 4 (Rukun Warga)

KK Data:
- KK Kepala Laki-laki: 850 families
- KK Kepala Perempuan: 235 families
```

## 🚀 Deployment Steps

### Option A: cPanel Deployment (Recommended)

#### Step 1: Upload Files to cPanel
```bash
# In cPanel File Manager or via FTP, ensure these files are updated:
- clear_legacy_data.php (updated cleanup script)
- check_statistik_data.php (new diagnostic script)
- check_table_structure.php (new structure checker)
```

#### Step 2: Access cPanel Terminal/SSH
```bash
# Navigate to your web directory
cd public_html/web-desa

# Run the database cleanup
php clear_legacy_data.php
```

#### Step 3: Verify Results
```bash
# Check if cleanup was successful
php check_statistik_data.php
```

### Option B: Manual Database Cleanup

If you can't run PHP scripts, manually execute this SQL in phpMyAdmin:

```sql
-- Step 1: Clear old data
DELETE FROM statistik;

-- Step 2: Insert real data
INSERT INTO statistik (kategori, label, jumlah, deskripsi, created_at, updated_at) VALUES
('rt_rw', 'Total RT', 12, 'Jumlah Rukun Tetangga di desa', NOW(), NOW()),
('rt_rw', 'Total RW', 4, 'Jumlah Rukun Warga di desa', NOW(), NOW()),
('kk', 'KK Kepala Laki-laki', 850, 'Kartu keluarga dengan kepala keluarga laki-laki', NOW(), NOW()),
('kk', 'KK Kepala Perempuan', 235, 'Kartu keluarga dengan kepala keluarga perempuan', NOW(), NOW());
```

### Option C: Production Deployment Script

Create this script on your production server:

#### deploy-database-cleanup.sh
```bash
#!/bin/bash

echo "🚀 Starting database cleanup deployment..."

# Backup current database
echo "📁 Creating database backup..."
php artisan db:backup --path=database/backups/before-cleanup-$(date +%Y%m%d_%H%M%S).sql

# Run cleanup
echo "🗑️ Running database cleanup..."
php clear_legacy_data.php

# Verify results
echo "✅ Verifying cleanup results..."
php check_statistik_data.php

# Clear cache
echo "🧹 Clearing application cache..."
php artisan cache:clear
php artisan config:clear
php artisan view:clear

echo "🎉 Database cleanup deployment completed!"
```

## 🔍 Verification Steps

After deployment, verify these points:

### 1. Database Check
```bash
php check_statistik_data.php
```
Should show:
- Total records: 4
- RT entries: 1 (Total RT: 12)
- RW entries: 1 (Total RW: 4)
- KK entries: 2 (Laki-laki: 850, Perempuan: 235)

### 2. Admin Dashboard Check
Visit: `your-domain.com/admin/data-statistik`

Verify:
- ✅ RT card shows "12" (not population number)
- ✅ RW card shows "4" (not population number)  
- ✅ KK cards show family counts
- ✅ Charts display correctly
- ✅ No "Data Wilayah" text appears

### 3. Performance Check
- Dashboard loads quickly
- No duplicate data in dropdowns
- CRUD operations work for all categories

## 🚨 Troubleshooting

### Issue: RT/RW data still not showing
```bash
# Check if cleanup ran successfully
php check_statistik_data.php

# If data is still wrong, run cleanup again
php clear_legacy_data.php
```

### Issue: Database connection errors
```bash
# Check database configuration
php artisan config:cache
php artisan migrate:status
```

### Issue: Permission errors on cPanel
```bash
# Set proper permissions
chmod 755 clear_legacy_data.php
chmod 755 check_statistik_data.php
```

## 📋 Post-Deployment Checklist

- [ ] Database contains exactly 4 statistik records
- [ ] RT shows 12, RW shows 4
- [ ] KK shows 850 + 235 families
- [ ] Admin dashboard displays correctly
- [ ] Charts work properly
- [ ] No duplicate entries
- [ ] CRUD operations functional

## 🎯 Success Criteria

The deployment is successful when:
1. **Clean Data**: No duplicate RT/RW entries
2. **Real Counts**: RT=12, RW=4 from actual database
3. **Proper Display**: Cards show counts, not population
4. **Functional UI**: All admin operations work
5. **Performance**: Fast loading dashboard

## 📞 Support

If you encounter issues:
1. Run diagnostic: `php check_statistik_data.php`
2. Check logs: `tail -f storage/logs/laravel.log`
3. Verify database connection: `php artisan migrate:status`
