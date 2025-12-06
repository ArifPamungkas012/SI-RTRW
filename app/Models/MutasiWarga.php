<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class MutasiWarga extends Model
{
    use SoftDeletes;

    protected $table = 'mutasi_warga';

    protected $fillable = [
        'warga_id',
        'jenis',        // masuk, keluar, pindah_rt, pindah_rw, dll
        'tanggal',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function warga()
    {
        return $this->belongsTo(Warga::class, 'warga_id');
    }

    public function getTanggalFormattedAttribute()
    {
        return $this->tanggal
            ? Carbon::parse($this->tanggal)->format('d M Y')
            : null;
    }
}
