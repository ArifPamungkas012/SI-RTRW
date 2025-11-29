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
        'keterangan'
    ];

    public function instances()
    {
        return $this->hasMany(IuranInstance::class, 'template_id');
    }
}
