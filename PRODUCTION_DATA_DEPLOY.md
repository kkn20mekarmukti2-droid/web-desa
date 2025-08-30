# Production Deployment Instructions - Data Statistik Fix

## Problem
The Data Statistik page at https://mekarmukti.id/admin/data-management shows error:
```
SQLSTATE[42S02]: Base table or view not found: 1146 Table 'mekh7277_desa.data' doesn't exist
```

## Solution
The production MySQL database is missing the `data` table that exists in local SQLite. We need to create the table and populate it with sample data.

## Deployment Steps

### Option 1: Using simple-deploy-data.php (Recommended)

1. **Update Database Credentials**
   - Open `simple-deploy-data.php`
   - Update these lines with your actual cPanel database credentials:
   ```php
   $host = 'localhost';              // Usually localhost for cPanel
   $dbname = 'mekh7277_desa';        // Your database name
   $username = 'mekh7277_desa';      // Your database username
   $password = '';                   // Your database password
   ```

2. **Upload and Run Script**
   - Upload `simple-deploy-data.php` to your cPanel file manager
   - Access it via browser: `https://mekarmukti.id/simple-deploy-data.php`
   - Or run via cPanel Terminal: `php simple-deploy-data.php`

3. **Verify Results**
   - The script will show progress and confirmation
   - Should create the `data` table with 28 statistical records
   - Test the Data Statistik page: https://mekarmukti.id/admin/data-management

### Option 2: Manual Database Setup

If you prefer to use cPanel phpMyAdmin:

1. **Create Table**
   ```sql
   CREATE TABLE `data` (
       `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
       `data` varchar(255) NOT NULL,
       `label` varchar(255) NOT NULL,
       `total` int(11) NOT NULL,
       `created_at` timestamp NULL DEFAULT NULL,
       `updated_at` timestamp NULL DEFAULT NULL,
       PRIMARY KEY (`id`)
   ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
   ```

2. **Insert Sample Data**
   - Run the INSERT queries from the deployment script
   - Or use the data seeder if Laravel artisan is available

## Expected Results

After deployment, the Data Statistik page should display:
- **Pendidikan**: 6 categories (Tidak Tamat SD, Tamat SD, etc.)
- **Pekerjaan**: 7 categories (Petani, Buruh, Pedagang, etc.)
- **Usia**: 4 age groups (0-5, 6-17, 18-59, 60+)
- **Agama**: 5 religions (Islam, Kristen, Katolik, Hindu, Buddha)
- **Status Kawin**: 4 statuses (Belum Kawin, Kawin, etc.)
- **Jenis Kelamin**: 2 categories (Laki-laki, Perempuan)

Total: 28 statistical records across 6 categories

## Troubleshooting

1. **Database Connection Error**
   - Check database credentials in the script
   - Verify database exists in cPanel
   - Check database user permissions

2. **Permission Error**
   - Ensure the database user has CREATE and INSERT permissions
   - Check cPanel database user privileges

3. **Still Getting Table Not Found**
   - Clear Laravel cache: run `php artisan cache:clear` if possible
   - Check if the correct database is being used
   - Verify table was created successfully in phpMyAdmin

## Clean Up
After successful deployment, you can delete the deployment script:
- `simple-deploy-data.php`
- `production-deploy-data.php`

## Files Modified in this Fix
- ✅ `app/Http/Controllers/rtRwController.php` - Fixed duplicate methods
- ✅ `routes/web.php` - Updated route namespaces  
- ✅ `database/seeders/DataStatistikSeeder.php` - Created sample data
- ✅ `simple-deploy-data.php` - Production deployment script
