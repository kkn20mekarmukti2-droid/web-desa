# 👥 User Management & Role System Documentation

## 📊 Current User Accounts

### 🏆 Admin Account
- **Name**: Admin
- **Email**: `admin@webdesa.com` 
- **Password**: `admin123`
- **Role**: 0 (Super Admin)
- **Permissions**: Full access to all content and features

### ✍️ Writer Accounts
- **Name**: Writer Desa
- **Email**: `writer@webdesa.com`
- **Password**: `writer123` 
- **Role**: 1 (Writer/Editor)
- **Permissions**: Can only see own content

- **Name**: Editor Desa
- **Email**: `editor@webdesa.com`
- **Password**: `editor123`
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

1. **Added missing columns**: `role` and `foto` columns added to users table
2. **Set proper roles**: Admin user set to role 0, new users default to role 1
3. **Created test users**: Writer and Editor accounts for testing
4. **Role-based permissions**: Gallery and article access based on user role

## 💡 Usage Tips

1. **Login as Admin** for full system access
2. **Login as Writer/Editor** to test content creation permissions
3. **Role 0** users can see everything, **Role 1** users see only their content
4. **Default password policy**: Simple passwords for development, change in production

---
**Last Updated**: Agustus 2025  
**Total Users**: 3 (1 Admin, 2 Writers)  
**Status**: ✅ Role System Active
