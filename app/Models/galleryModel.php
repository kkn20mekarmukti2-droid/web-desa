<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class galleryModel extends Model
{
    use HasFactory;
    protected $table = 'gallery';

    protected $fillable = [
        'judul',
        'url',
        'type',
        'created_by'
    ];
}
