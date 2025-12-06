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
        'kepala_keluarga',   // saat ini masih nama / teks
        'tanggal_dibuat',
    ];

    protected $casts = [
        'tanggal_dibuat' => 'date',
    ];

    public function anggota()
    {
        return $this->hasMany(AnggotaKK::class, 'kk_id');
    }

    // Kalau suatu saat kepala_keluarga jadi FK ke Warga:
    // public function kepalaKeluargaWarga()
    // {
    //     return $this->belongsTo(Warga::class, 'kepala_keluarga_id');
    // }
}
