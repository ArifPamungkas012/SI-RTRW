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
        'type',
        'kategori',
        'reference_table',
        'reference_id',
        'amount',
        'balance_after',
        'recorded_by',
        'description'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
