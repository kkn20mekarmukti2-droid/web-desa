<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukUmkm extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_produk',
        'deskripsi',
        'gambar',
        'nomor_telepon',
    ];
}
