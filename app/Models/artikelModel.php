<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class artikelModel extends Model
{
    use SoftDeletes;
    protected $table = 'artikel';
    protected $fillable = [
        'judul',
        'header',
        'sampul',
        'deskripsi',
        'kategori',
        'status',
        'created_by',
        'updated_by',
    ];


    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }


    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    public function getKategori(){
        return $this->belongsTo(kategoriModel::class,'kategori');
    }
}
