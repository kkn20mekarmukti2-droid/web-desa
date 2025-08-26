# 👥 User Management & Role System Documentation

## 📊 Current User Accounts

### 🏆 Admin Account (ID: 4)
- **Name**: Admin
- **Email**: `admin@webdesa.com` 
- **Password**: `admin123`
- **Role**: 0 (Super Admin)
- **Permissions**: Full access to all content and features

### ✍️ Writer Account (ID: 5)
- **Name**: Writer
- **Email**: `writer@webdesa.com`
- **Password**: `writer123` 
- **Role**: 1 (Writer/Editor)
- **Permissions**: Can only see own content

## 🔐 Role System

### Role Values
- **0**: Super Admin - Full access to all content and admin features
- **1**: Writer/Editor - Limited access, can only manage own content

### Permission Logic
```php
// Example from galleryController.php
$artikel = (Auth::user()->role == 0)
    ? galleryModel::all()  // Admin sees all
    : galleryModel::where('created_by', Auth::user()->id)->get(); // Writer sees own only
```

## 🗃️ Database Structure

### Users Table Schema
```sql
CREATE TABLE users (
    id INTEGER PRIMARY KEY,
    name varchar NOT NULL,
    email varchar UNIQUE NOT NULL,
    email_verified_at datetime NULL,
    password varchar NOT NULL,
    remember_token varchar NULL,
    created_at datetime NULL,
    updated_at datetime NULL,
    role INTEGER DEFAULT 1,
    foto TEXT DEFAULT NULL
);
```

## 🛠️ Management Scripts

### Check Users
```bash
php check_database.php
```

### Fix Role System
```bash
php fix_user_roles.php
```

### Create Test Users
```bash
php create_test_users.php
```

## 🔧 Admin Commands

### Reset Admin Password
```bash
php artisan admin:reset-password
```

### Create New Admin
```bash
php artisan admin:reset-password --show-users
```

## 🚀 Features by Role

### Super Admin (Role 0)
- ✅ View all articles from all users
- ✅ Manage all gallery content
- ✅ Full database access
- ✅ User management
- ✅ System configuration

### Writer/Editor (Role 1) 
- ✅ Create and edit own articles
- ✅ Manage own gallery content
- ✅ View own content only
- ❌ Cannot see other users' content
- ❌ No admin panel access

## 🔄 Recent Changes

1. **Database Cleanup**: Removed old users (ID 1-3), created clean setup with specific IDs
2. **User Restructure**: Only 2 users remain - Admin (ID: 4) and Writer (ID: 5)
3. **Role System Active**: Admin has role 0 (full access), Writer has role 1 (limited access)
4. **Auto Increment**: Set to continue from ID 6 for future users

## 🛠️ Management Scripts

### User Cleanup
```bash
php user-cleanup.php
```

### Check Users
```bash
php check_database.php
```

### Create Test Users (Legacy)
```bash
php create_test_users.php
```

---
**Last Updated**: Agustus 2025  
**Total Users**: 2 (1 Admin, 1 Writer)  
**User IDs**: Admin=4, Writer=5  
**Status**: ✅ Clean Database Setup
