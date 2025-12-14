<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('users')->whereNotNull('role')->get()->each(function ($user) {
            $role = DB::table('roles')->where('name', $user->role)->first();
            if ($role) {
                DB::table('users')
                    ->where('id', $user->id)
                    ->update(['role_id' => $role->id]);
            }
        });
    }

    public function down(): void
    {
        // tidak perlu rollback
    }
};
