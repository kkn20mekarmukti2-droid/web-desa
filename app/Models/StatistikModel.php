<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatistikModel extends Model
{
    protected $table = 'statistik';
    
    protected $fillable = [
        'kategori',
        'label',
        'jumlah',
        'deskripsi'
    ];
    
    // Kategori yang tersedia
    public static function getKategoriOptions()
    {
        return [
            'jenis_kelamin' => 'Data Penduduk berdasarkan Jenis Kelamin',
            'agama' => 'Data Penduduk berdasarkan Agama',
            'pekerjaan' => 'Data Penduduk berdasarkan Pekerjaan',
            'kk' => 'Data Kartu Keluarga',
            'pendidikan' => 'Data Pendidikan',
            'kesehatan' => 'Data Kesehatan',
            'siswa' => 'Data Siswa',
            'klub' => 'Data Klub Olahraga',
            'kesenian' => 'Data Grup Kesenian',
            'sumberair' => 'Data Sumber Air'
        ];
    }
    
    // Get data by category for charts
    public static function getDataByKategori($kategori)
    {
        return self::where('kategori', $kategori)
                  ->orderBy('label')
                  ->get();
    }
}
