<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    protected $table = 'transactions';

    protected $fillable = [
        'tanggal',
        'type',              // 'in' / 'out'
        'kategori',
        'kategori_id',
        'reference_table',
        'reference_id',
        'amount',
        'balance_after',
        'recorded_by',
        'description',
    ];

    protected $casts = [
        'tanggal' => 'date',   // bisa 'date' karena kolomnya DATE
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    public function kategoriKeuangan()
    {
        return $this->belongsTo(KategoriKeuangan::class, 'kategori_id');
    }

    public function getTypeLabelAttribute()
    {
        return match ($this->type) {
            'in' => 'Pemasukan',
            'out' => 'Pengeluaran',
            default => 'Tidak diketahui',
        };
    }
}
