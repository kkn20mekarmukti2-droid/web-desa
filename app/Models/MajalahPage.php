<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MajalahPage extends Model
{
    use HasFactory;

    protected $table = 'majalah_pages';
    
    protected $fillable = [
        'majalah_id',
        'page_number',
        'image_path',
        'title',
        'description'
    ];

    // Relationship dengan majalah
    public function majalah()
    {
        return $this->belongsTo(Majalah::class);
    }

    // Accessor untuk URL gambar
    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->image_path);
    }
}
