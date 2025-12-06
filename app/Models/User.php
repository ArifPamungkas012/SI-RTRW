<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
        'role',
        'warga_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function warga()
    {
        return $this->belongsTo(Warga::class, 'warga_id');
    }

    public function kasDicatat()
    {
        return $this->hasMany(Kas::class, 'recorded_by');
    }

    public function transaksiDicatat()
    {
        return $this->hasMany(Transaction::class, 'recorded_by');
    }

    public function kegiatanTanggungJawab()
    {
        return $this->hasMany(Kegiatan::class, 'penanggung_jawab_user_id');
    }

    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class, 'user_id');
    }
}
