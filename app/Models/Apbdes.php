<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Apbdes extends Model
{
    protected $table = 'apbdes';
    
    protected $fillable = [
        'title',
        'image_path', 
        'description',
        'tahun',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'tahun' => 'integer'
    ];

    // Get active APBDes with pagination
    public static function getActive()
    {
        return self::where('is_active', true)
                   ->orderBy('tahun', 'desc')
                   ->paginate(9); // 9 items per page for 3x3 grid
    }

    // Get latest APBDes
    public static function getLatest()
    {
        return self::where('is_active', true)
                   ->orderBy('tahun', 'desc')
                   ->first();
    }
}
