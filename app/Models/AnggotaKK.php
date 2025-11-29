<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnggotaKK extends Model
{
    protected $table = 'anggota_kk';

    protected $fillable = [
        'kk_id',
        'warga_id',
        'hubungan'
    ];

    public function kk()
    {
        return $this->belongsTo(KartuKeluarga::class, 'kk_id');
    }

    public function warga()
    {
        return $this->belongsTo(Warga::class, 'warga_id');
    }
}
