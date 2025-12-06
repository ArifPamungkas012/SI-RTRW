<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pembayaran extends Model
{
    use SoftDeletes;

    protected $table = 'pembayaran';

    protected $fillable = [
        'iuran_instance_id',
        'warga_id',
        'tanggal_bayar',
        'amount',
        'metode',          // legacy (teks)
        'metode_id',       // FK ke metode_pembayaran (baru)
        'status_verifikasi',
        'receipt_no',
        'proof_path',
        'recorded_by',
    ];

    protected $casts = [
        'tanggal_bayar' => 'datetime',
    ];

    public function instance()
    {
        return $this->belongsTo(IuranInstance::class, 'iuran_instance_id');
    }

    public function warga()
    {
        return $this->belongsTo(Warga::class, 'warga_id');
    }

    public function pencatat()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    public function metodePembayaran()
    {
        return $this->belongsTo(MetodePembayaran::class, 'metode_id');
    }
}
