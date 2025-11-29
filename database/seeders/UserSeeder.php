<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'name'      => 'Bapak Ahmad',
                'username'  => 'admin',
                'email'     => 'admin@example.com',
                'role'      => 'ketua_rt',
                'password'  => Hash::make('admin123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name'      => 'Sekretaris RT',
                'username'  => 'sekretaris',
                'email'     => 'sekretaris@example.com',
                'role'      => 'sekretaris',
                'password'  => Hash::make('sekretaris123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name'      => 'Bendahara RT',
                'username'  => 'bendahara',
                'email'     => 'bendahara@example.com',
                'role'      => 'bendahara',
                'password'  => Hash::make('bendahara123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
