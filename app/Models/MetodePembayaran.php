<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetodePembayaran extends Model
{
    protected $table = 'metode_pembayaran';

    protected $fillable = [
        'nama',       // Cash, Transfer BCA, Transfer BRI, dll
        'deskripsi',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'metode_id');
    }
}
