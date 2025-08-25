<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rwModel extends Model
{
    use HasFactory;
    protected $table = 'rw';

    protected $fillable = [
        'rw',
        'nama',
        'kontak',
        'foto'
    ];

    public function rts()
    {
        return $this->hasMany(rtModel::class, 'rw','rw');
    }
}
