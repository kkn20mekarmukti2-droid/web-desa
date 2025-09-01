<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StrukturPemerintahan extends Model
{
    protected $fillable = [
        'nama',
        'jabatan', 
        'foto',
        'urutan',
        'kategori',
        'pendidikan',
        'tugas_pokok',
        'no_sk',
        'tgl_sk',
        'is_active'
    ];

    protected $casts = [
        'tgl_sk' => 'date',
        'is_active' => 'boolean'
    ];

    // Scope untuk mengambil yang aktif saja
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope untuk mengurutkan berdasarkan hierarki
    public function scopeOrdered($query)
    {
        return $query->orderBy('urutan')->orderBy('nama');
    }

    // Method untuk mendapatkan struktur berdasarkan kategori
    public static function getByCategory($kategori)
    {
        return self::active()->where('kategori', $kategori)->ordered()->get();
    }

    // Method untuk mendapatkan semua struktur yang diurutkan
    public static function getAllOrdered()
    {
        return self::active()->ordered()->get();
    }
}
