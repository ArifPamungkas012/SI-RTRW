<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KartuKeluarga extends Model
{
    use SoftDeletes;

    protected $table = 'kartu_keluarga';

    protected $fillable = [
        'no_kk',
        'alamat',
        'rt',
        'rw',
        'kepala_keluarga',
        'tanggal_dibuat'
    ];

    public function anggota()
    {
        return $this->hasMany(AnggotaKK::class, 'kk_id');
    }
}
