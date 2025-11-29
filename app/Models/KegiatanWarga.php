<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KegiatanWarga extends Model
{
    protected $table = 'kegiatan_warga';

    protected $fillable = [
        'kegiatan_id',
        'warga_id',
        'role',
        'status'
    ];
}
