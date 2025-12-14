<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    protected $fillable = [
        'name',         // e.g. admin, ketua_rt, bendahara, warga
        'label',        // e.g. Administrator, Ketua RT
        'description',
    ];
}
