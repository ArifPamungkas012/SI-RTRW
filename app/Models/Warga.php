<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warga extends Model
{
    use SoftDeletes;

    protected $table = 'warga';

    protected $fillable = [
        'nik',
        'nama',
        'alamat',
        'no_rumah',
        'rt',
        'rw',
        'no_hp',
        'tanggal_lahir',
        'status_aktif',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function anggotaKK()
    {
        return $this->hasMany(AnggotaKK::class, 'warga_id');
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'warga_id');
    }

    public function kegiatan()
    {
        return $this->belongsToMany(Kegiatan::class, 'kegiatan_warga', 'warga_id', 'kegiatan_id')
            ->withPivot('role', 'status')
            ->withTimestamps();
    }

    public function userAccount()
    {
        return $this->hasOne(User::class, 'warga_id');
    }

    public function mutasi()
    {
        return $this->hasMany(MutasiWarga::class, 'warga_id');
    }
}
