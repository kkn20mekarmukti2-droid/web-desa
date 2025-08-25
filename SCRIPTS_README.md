# 🛠️ SHELL SCRIPTS DOCUMENTATION

## 📁 Active Scripts (Ready to Use)

### 1. `cpanel-deploy.sh` 
**Purpose:** Main deployment script for cPanel hosting
**Usage:** 
```bash
bash cpanel-deploy.sh
```
**Features:**
- Git pull latest changes
- Composer install with production optimizations
- Cache clearing and optimization
- Storage link fixes for cPanel
- Environment setup

### 2. `simple-cleanup.sh`
**Purpose:** User account cleanup tool (FIXED VERSION)
**Usage:**
```bash
bash simple-cleanup.sh
```
**Features:**
- Delete duplicate Rasyid accounts
- Create single admin@webdesa.com account
- Show current users
- Safe article migration
- Uses correct database columns (created_by/updated_by)

### 3. `fix-storage-link.sh`
**Purpose:** Fix storage link issues in cPanel (symlink function disabled)
**Usage:**
```bash
bash fix-storage-link.sh
```
**Features:**
- Copy files instead of creating symlinks
- Works around cPanel symlink restrictions
- Fixes image and asset access issues

---

## 🗑️ Removed Scripts (No Longer Needed)

The following scripts have been removed as they were redundant, outdated, or had bugs:

- ❌ `user-cleanup.sh` - Old version with database column bugs
- ❌ `cpanel-user-cleanup.sh` - Complex version replaced by simple-cleanup.sh
- ❌ `production-admin-fix.sh` - Admin authentication issues resolved
- ❌ `deploy.sh` - Generic version, replaced by cpanel-specific
- ❌ `deploy-to-cpanel.sh` - Redundant with cpanel-deploy.sh
- ❌ `safe-deployment.sh` - Features merged into main deployment
- ❌ `cpanel-debug.sh` - Debugging completed, no longer needed
- ❌ `cpanel-pre-check.sh` - Pre-checks completed, issues resolved

---

## 🎯 Quick Reference for Production

### Deploy to cPanel:
```bash
cd /home/mekh7277/web-desa
bash cpanel-deploy.sh
```

### Clean up duplicate users:
```bash
bash simple-cleanup.sh
# Choose option 1 or 2 as needed
```

### Fix storage/image issues:
```bash
bash fix-storage-link.sh
```

---

**Last Updated:** August 25, 2025
**Project:** Web Desa Mekarmukti  
**Repository:** kkn20mekarmukti2-droid/web-desa
