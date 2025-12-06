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
        'status',
    ];

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class, 'kegiatan_id');
    }

    public function warga()
    {
        return $this->belongsTo(Warga::class, 'warga_id');
    }
}
