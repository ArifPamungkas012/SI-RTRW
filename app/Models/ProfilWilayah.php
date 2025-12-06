<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProfilWilayah extends Model
{
    use SoftDeletes;

    protected $table = 'profil_wilayah';

    protected $fillable = [
        'nama_rt_rw',          // contoh: "RT 05 / RW 03"
        'alamat_sekretariat',
        'kontak',              // telp/wa
        'logo_path',           // path file logo
        'deskripsi',
    ];
}
