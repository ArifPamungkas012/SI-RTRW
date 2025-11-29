<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IuranInstance extends Model
{
    use SoftDeletes;

    protected $table = 'iuran_instances';

    protected $fillable = [
        'template_id',
        'periode',
        'due_date',
        'nominal',
        'status'
    ];

    public function template()
    {
        return $this->belongsTo(IuranTemplate::class, 'template_id');
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'iuran_instance_id');
    }
}
