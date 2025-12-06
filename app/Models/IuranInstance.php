<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class IuranInstance extends Model
{
    use SoftDeletes;

    protected $table = 'iuran_instances';

    protected $fillable = [
        'template_id',
        'periode',
        'due_date',
        'nominal',
        'status',
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    public function template()
    {
        return $this->belongsTo(IuranTemplate::class, 'template_id');
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'iuran_instance_id');
    }

    // Akses cepat format periode (misal: Jan 2025)
    public function getPeriodeLabelAttribute()
    {
        return $this->periode;
    }

    public function getDueDateFormattedAttribute()
    {
        return $this->due_date
            ? Carbon::parse($this->due_date)->format('d M Y')
            : null;
    }
}
