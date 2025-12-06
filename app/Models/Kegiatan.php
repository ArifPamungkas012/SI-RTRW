<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kegiatan extends Model
{
    use SoftDeletes;

    protected $table = 'kegiatan';

    protected $fillable = [
        'nama',
        'jenis',
        'tanggal',
        'waktu',
        'lokasi',
        'keterangan',
        'penanggung_jawab_user_id',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function peserta()
    {
        return $this->belongsToMany(Warga::class, 'kegiatan_warga', 'kegiatan_id', 'warga_id')
            ->withPivot('role', 'status')
            ->withTimestamps();
    }

    public function penanggungJawab()
    {
        return $this->belongsTo(User::class, 'penanggung_jawab_user_id');
    }
}
