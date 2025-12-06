<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IuranTemplate extends Model
{
    use SoftDeletes;

    protected $table = 'iuran_templates';

    protected $fillable = [
        'nama',
        'jenis',
        'nominal_default',
        'keterangan',
        'kategori_keuangan_id', // FK ke kategori_keuangan
    ];

    public function instances()
    {
        return $this->hasMany(IuranInstance::class, 'template_id');
    }

    public function kategoriKeuangan()
    {
        return $this->belongsTo(KategoriKeuangan::class, 'kategori_keuangan_id');
    }
}
