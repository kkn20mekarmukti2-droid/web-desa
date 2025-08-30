<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Pengaduan extends Model {
    protected $table = 'pengaduan';
    protected $fillable = [
        'nama', 'no_hp', 'alamat_lengkap', 'isi'
    ];
}
