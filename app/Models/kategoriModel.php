<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kategoriModel extends Model
{
    use HasFactory;
    protected $table = 'kategori';
    protected $fillable = [
        'judul',
    ];

    public function artikel()
    {
        return $this->hasMany(artikelModel::class, 'kategori', 'id');
    }
}
