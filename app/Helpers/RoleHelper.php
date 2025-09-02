<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class RoleHelper
{
    /**
     * Check if current user is SuperAdmin
     */
    public static function isSuperAdmin(): bool
    {
        return Auth::check() && Auth::user()->role === 'SuperAdmin';
    }

    /**
     * Check if current user is Admin or SuperAdmin
     */
    public static function isAdmin(): bool
    {
        return Auth::check() && in_array(Auth::user()->role, ['Admin', 'SuperAdmin']);
    }

    /**
     * Check if current user is Writer
     */
    public static function isWriter(): bool
    {
        return Auth::check() && Auth::user()->role === 'Writer';
    }

    /**
     * Check if current user is Editor
     */
    public static function isEditor(): bool
    {
        return Auth::check() && Auth::user()->role === 'Editor';
    }

    /**
     * Check if current user can manage users
     */
    public static function canManageUsers(): bool
    {
        return self::isAdmin();
    }

    /**
     * Check if current user can manage specific user
     */
    public static function canManageUser($targetUser): bool
    {
        if (!Auth::check()) return false;
        
        $currentUser = Auth::user();
        
        // SuperAdmin can manage everyone except themselves for role changes
        if ($currentUser->role === 'SuperAdmin') {
            return true;
        }
        
        // Admin can manage everyone except SuperAdmin and themselves
        if ($currentUser->role === 'Admin') {
            return $targetUser->role !== 'SuperAdmin' && $targetUser->id !== $currentUser->id;
        }
        
        // Writer and Editor cannot manage users
        return false;
    }

    /**
     * Check if current user can edit content
     */
    public static function canEditContent(): bool
    {
        return Auth::check() && in_array(Auth::user()->role, ['SuperAdmin', 'Admin', 'Writer', 'Editor']);
    }

    /**
     * Check if current user can publish content
     */
    public static function canPublishContent(): bool
    {
        return Auth::check() && in_array(Auth::user()->role, ['SuperAdmin', 'Admin', 'Editor']);
    }

    /**
     * Check if current user can manage APBDES
     */
    public static function canManageAPBDES(): bool
    {
        return self::isAdmin();
    }

    /**
     * Check if current user can manage UMKM
     */
    public static function canManageUMKM(): bool
    {
        return Auth::check() && in_array(Auth::user()->role, ['SuperAdmin', 'Admin', 'Writer']);
    }

    /**
     * Check if current user can manage struktur pemerintahan
     */
    public static function canManageStruktur(): bool
    {
        return self::isAdmin();
    }

    /**
     * Check if current user can manage hero images
     */
    public static function canManageHeroImages(): bool
    {
        return self::isAdmin();
    }

    /**
     * Check if current user can view statistics
     */
    public static function canViewStatistics(): bool
    {
        return self::isAdmin();
    }

    /**
     * Check if current user can manage RT/RW
     */
    public static function canManageRTRW(): bool
    {
        return self::isAdmin();
    }

    /**
     * Get user role display name
     */
    public static function getRoleDisplayName($role): string
    {
        $roles = [
            'SuperAdmin' => 'Super Administrator',
            'Admin' => 'Administrator',
            'Writer' => 'Penulis Konten',
            'Editor' => 'Editor Konten'
        ];

        return $roles[$role] ?? $role;
    }

    /**
     * Get available roles for current user when creating/editing users
     */
    public static function getAvailableRoles(): array
    {
        if (!Auth::check()) return [];
        
        $currentRole = Auth::user()->role;
        
        if ($currentRole === 'SuperAdmin') {
            return ['SuperAdmin', 'Admin', 'Writer', 'Editor'];
        }
        
        if ($currentRole === 'Admin') {
            return ['Admin', 'Writer', 'Editor'];
        }
        
        return [];
    }

    /**
     * Get navigation menu items based on role
     */
    public static function getNavigationItems(): array
    {
        if (!Auth::check()) return [];
        
        $items = [
            'dashboard' => [
                'title' => 'Dashboard',
                'url' => route('dashboard'),
                'icon' => 'fas fa-tachometer-alt',
                'roles' => ['SuperAdmin', 'Admin', 'Writer', 'Editor']
            ]
        ];

        // Content Management
        if (self::canEditContent()) {
            $items['content'] = [
                'title' => 'Kelola Konten',
                'url' => route('content.manage.modern'),
                'icon' => 'fas fa-edit',
                'roles' => ['SuperAdmin', 'Admin', 'Writer', 'Editor']
            ];
        }

        // UMKM Management
        if (self::canManageUMKM()) {
            $items['umkm'] = [
                'title' => 'Produk UMKM',
                'url' => route('admin.produk-umkm.index'),
                'icon' => 'fas fa-store',
                'roles' => ['SuperAdmin', 'Admin', 'Writer']
            ];
        }

        // Admin-only features
        if (self::isAdmin()) {
            $items = array_merge($items, [
                'users' => [
                    'title' => 'Manajemen User',
                    'url' => route('akun.manage'),
                    'icon' => 'fas fa-users',
                    'roles' => ['SuperAdmin', 'Admin']
                ],
                'apbdes' => [
                    'title' => 'APBDES',
                    'url' => route('admin.apbdes.index'),
                    'icon' => 'fas fa-chart-pie',
                    'roles' => ['SuperAdmin', 'Admin']
                ],
                'struktur' => [
                    'title' => 'Struktur Pemerintahan',
                    'url' => route('admin.struktur-pemerintahan.index'),
                    'icon' => 'fas fa-sitemap',
                    'roles' => ['SuperAdmin', 'Admin']
                ],
                'hero_images' => [
                    'title' => 'Gambar Hero',
                    'url' => route('admin.hero-images.index'),
                    'icon' => 'fas fa-images',
                    'roles' => ['SuperAdmin', 'Admin']
                ],
                'statistics' => [
                    'title' => 'Data Statistik',
                    'url' => route('admin.statistik.index'),
                    'icon' => 'fas fa-chart-bar',
                    'roles' => ['SuperAdmin', 'Admin']
                ],
                'rtrw' => [
                    'title' => 'RT/RW',
                    'url' => route('rtrw.manage.modern'),
                    'icon' => 'fas fa-map-marked-alt',
                    'roles' => ['SuperAdmin', 'Admin']
                ]
            ]);
        }

        return $items;
    }
}
