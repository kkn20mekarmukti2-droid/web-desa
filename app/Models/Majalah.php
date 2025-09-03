<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
        'is_active' => 'boolean',
        'tanggal_terbit' => 'date'
    ];

    // Relationship dengan halaman majalah
    public function pages()
    {
        return $this->hasMany(MajalahPage::class)->orderBy('page_number');
    }

    // Scope untuk majalah aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Accessor untuk format tanggal terbit
    public function getTanggalTerbitFormattedAttribute()
    {
        return Carbon::parse($this->tanggal_terbit)->format('F Y');
    }

    // Accessor untuk total halaman
    public function getTotalPagesAttribute()
    {
        return $this->pages()->count();
    }
}
