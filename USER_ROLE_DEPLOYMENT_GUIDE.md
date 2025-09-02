# USER ROLE SYSTEM DEPLOYMENT GUIDE

## Overview
Panduan lengkap untuk deploy sistem role user yang telah dimodernisasi dari numeric (0,1) ke string ("SuperAdmin", "Admin", dll).

## Pre-Deployment Checklist

### ✅ Local Development Completed
- [x] Hero Images system (exact UMKM replica)
- [x] User role migration script tested
- [x] Modern Manage User interface
- [x] Route parameter fixes
- [x] Dashboard modal improvements

### ✅ Files Ready for Deployment
```
📁 Updated Files:
├── resources/views/admin/akun/
│   ├── manage-modern.blade.php (NEW)
│   └── add-modern.blade.php (NEW)
├── app/Http/Controllers/authController.php (UPDATED)
├── cpanel-update-user-roles.php (NEW)
└── cpanel-update-user-roles.sh (NEW - Optional)
```

## Deployment Methods

### Method 1: PHP Script (Recommended for cPanel)
```bash
# Upload script to root directory
Upload: cpanel-update-user-roles.php

# Run via browser
Visit: http://yourdomain.com/cpanel-update-user-roles.php

# Or run via terminal
php cpanel-update-user-roles.php
```

### Method 2: Bash Script (If shell access available)
```bash
# Upload and run
chmod +x cpanel-update-user-roles.sh
./cpanel-update-user-roles.sh
```

## Step-by-Step Deployment

### Step 1: Backup Database
```sql
-- Create backup
mysqldump -u username -p database_name > backup_before_role_update.sql
```

### Step 2: Upload Files
Upload semua file yang telah diupdate:
- `resources/views/admin/akun/manage-modern.blade.php`
- `resources/views/admin/akun/add-modern.blade.php`
- `app/Http/Controllers/authController.php`
- `cpanel-update-user-roles.php`

### Step 3: Run Role Update Script
Execute script dan verifikasi output:
```
=== EXPECTED OUTPUT ===
📋 Checking current users and roles...
✅ Numeric 1 → SuperAdmin: 1 users
🎉 Successfully updated 1 user roles!
✅ Caches cleared successfully!
✅ UPDATE COMPLETED!
```

### Step 4: Verify Deployment
1. **Test Admin Login**: Login ke `/admin`
2. **Check Manage Users**: Visit `/admin/manage-akun`
3. **Verify Role Dropdown**: Ensure roles show: SuperAdmin, Admin, Writer, Editor
4. **Test CRUD Operations**: Add, edit, delete users

### Step 5: Cleanup
```bash
# Delete deployment scripts for security
rm cpanel-update-user-roles.php
rm cpanel-update-user-roles.sh
```

## Role System Mapping

### Before (Numeric)
```
0 = Super Admin
1 = Admin
2 = Writer
3 = Editor
```

### After (String)
```
"SuperAdmin" = Full access
"Admin" = Administrative access
"Writer" = Content creation
"Editor" = Content editing
```

## Troubleshooting

### Issue: Script Fails to Load Laravel
```php
// Solution: Check paths
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
```

### Issue: Users Not Updated
```php
// Check current roles first
SELECT id, name, email, role FROM users;

// Manual update if needed
UPDATE users SET role = 'SuperAdmin' WHERE role = '1' OR role = 1;
```

### Issue: Manage User Page Not Loading
1. Check route: `Route::get('/admin/manage-akun', [authController::class, 'index'])`
2. Verify controller method exists: `authController::index()`
3. Check view path: `resources/views/admin/akun/manage-modern.blade.php`

### Issue: Role Dropdown Not Working
```php
// Verify in authController::updateRole()
$validRoles = ['SuperAdmin', 'Admin', 'Writer', 'Editor'];
if (!in_array($request->role, $validRoles)) {
    return response()->json(['error' => 'Invalid role']);
}
```

## Security Considerations

### 1. Script Cleanup
```bash
# Always delete scripts after use
rm cpanel-update-user-roles.php
rm update_user_roles.php
```

### 2. Role Validation
```php
// Ensure only valid roles
$allowedRoles = ['SuperAdmin', 'Admin', 'Writer', 'Editor'];
$request->validate(['role' => 'in:' . implode(',', $allowedRoles)]);
```

### 3. Permission Checks
```php
// Add middleware for role-based access
Route::middleware(['auth', 'role:SuperAdmin'])->group(function () {
    Route::resource('admin/manage-akun', authController::class);
});
```

## Testing Checklist

### ✅ User Management Tests
- [ ] Login with updated role works
- [ ] Manage User page loads correctly
- [ ] User list displays with string roles
- [ ] Role dropdown shows all options
- [ ] Add new user with role selection
- [ ] Edit user role (change dropdown)
- [ ] Delete user with confirmation
- [ ] Password reset functionality
- [ ] User details modal

### ✅ Role System Tests
- [ ] SuperAdmin can access all features
- [ ] Admin has appropriate permissions
- [ ] Writer/Editor roles work as expected
- [ ] Invalid roles are rejected

## Production Checklist

### Before Go-Live
- [ ] Database backup completed
- [ ] All files uploaded correctly
- [ ] Role update script executed successfully
- [ ] Manual testing completed
- [ ] Cleanup scripts removed

### After Go-Live
- [ ] Monitor for any role-related errors
- [ ] Verify all user logins work
- [ ] Check admin functionality
- [ ] Confirm no broken permissions

## Support Information

### Log Locations
```
- Laravel logs: storage/logs/laravel.log
- Web server logs: /var/log/apache2/error.log (or nginx)
- Database logs: Check MySQL/SQLite logs
```

### Common Errors
```
1. "Role not found" → Check role string format
2. "Permission denied" → Verify role permissions
3. "Page not found" → Check route definitions
4. "Database error" → Verify table structure
```

## Rollback Plan

### If Issues Occur:
```sql
-- Restore database
mysql -u username -p database_name < backup_before_role_update.sql

-- Or manual rollback
UPDATE users SET role = '1' WHERE role = 'SuperAdmin';
UPDATE users SET role = '0' WHERE role = 'Admin';
```

### Restore Old Files:
- Revert `authController.php` changes
- Use old manage user views if needed

## Success Metrics

### Deployment Successful When:
- ✅ All users can login normally
- ✅ Role dropdown shows string values
- ✅ User management CRUD works
- ✅ No permission errors
- ✅ Dashboard and all admin features functional

---

**Created:** December 2024  
**Version:** 1.0  
**Status:** Ready for Production Deployment
