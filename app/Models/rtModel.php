<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rtModel extends Model
{
    use HasFactory;
    protected $table = 'rt';

    protected $fillable = [
        'nama',
        'kontak',
        'foto',
        'rt',
        'rw'
    ];

    public function rw()
    {
        return $this->belongsTo(rwModel::class, 'rw','rw');
    }
}
