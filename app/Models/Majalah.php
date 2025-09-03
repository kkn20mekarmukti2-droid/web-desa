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
        'deskripsi', 
        'cover_image',
        'is_active',
        'tanggal_terbit'
    ];

    protected $casts = [
        'tanggal_terbit' => 'date',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relationship dengan halaman majalah
    public function pages()
    {
        return $this->hasMany(MajalahPage::class, 'majalah_id')->orderBy('page_number');
    }

    // Helper untuk mendapatkan total halaman
    public function getTotalPagesAttribute()
    {
        return $this->pages()->count();
    }
}
