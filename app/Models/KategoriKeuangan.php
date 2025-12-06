<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KategoriKeuangan extends Model
{
    use SoftDeletes;

    protected $table = 'kategori_keuangan';

    protected $fillable = [
        'nama',       // contoh: Iuran Kebersihan, Operasional, Donasi
        'tipe',       // masuk / keluar
        'kode',       // IK, OP, DN, dll (opsional)
        'deskripsi',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function kas()
    {
        return $this->hasMany(Kas::class, 'kategori_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'kategori_id');
    }

    public function iuranTemplates()
    {
        return $this->hasMany(IuranTemplate::class, 'kategori_keuangan_id');
    }
}
