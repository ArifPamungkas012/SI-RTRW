<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $table = 'audit_logs';

    protected $fillable = [
        'table_name',
        'record_id',
        'user_id',
        'action',
        'old_values',
        'new_values'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
