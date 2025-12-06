<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Kas extends Model
{
    use SoftDeletes;

    protected $table = 'kas';

    protected $fillable = [
        'tanggal',
        'tipe',            // masuk / keluar
        'kategori',        // teks bebas (legacy)
        'kategori_id',     // FK ke kategori_keuangan (struktur baru)
        'nominal',
        'keterangan',
        'recorded_by',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    /**
     * RELATIONS
     */

    public function pencatat()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    public function kategoriKeuangan()
    {
        return $this->belongsTo(KategoriKeuangan::class, 'kategori_id');
    }

    /**
     * ACCESSORS
     */

    public function getTanggalFormattedAttribute()
    {
        return $this->tanggal
            ? Carbon::parse($this->tanggal)->format('d M Y')
            : null;
    }

    public function getNominalFormattedAttribute()
    {
        return 'Rp ' . number_format($this->nominal, 0, ',', '.');
    }

    public function getTipeLabelAttribute()
    {
        return $this->tipe === 'masuk' ? 'Kas Masuk' : 'Kas Keluar';
    }
}
