<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Majalah extends Model
{
    use HasFactory;

    protected $table = 'majalah';

    protected $fillable = [
        'judul',
        'cover_image', // Change from 'url' to 'cover_image'  
        'deskripsi',
        'is_active',
        'tanggal_terbit',
        'created_by'
    ];

    protected $casts = [
        'tanggal_terbit' => 'date',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Accessor for URL field (for backward compatibility with views)
    public function getUrlAttribute()
    {
        return $this->cover_image;
    }

    // Mutator for URL field (for backward compatibility with forms)
    public function setUrlAttribute($value)
    {
        $this->attributes['cover_image'] = $value;
    }

    // Add type attribute for gallery compatibility
    public function getTypeAttribute()
    {
        return 'cover';
    }

    // Add created_by for compatibility
    public function getCreatedByAttribute()
    {
        return 'Admin Desa';
    }
}
