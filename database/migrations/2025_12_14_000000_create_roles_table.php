<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Slug: admin, ketua_rt
            $table->string('label');          // Readable: Administrator
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Seed default roles
        DB::table('roles')->insert([
            ['name' => 'admin', 'label' => 'Administrator', 'description' => 'Akses penuh sistem', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'ketua_rt', 'label' => 'Ketua RT', 'description' => 'Akses manajemen data warga dan validasi', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'bendahara', 'label' => 'Bendahara', 'description' => 'Akses manajemen keuangan', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'warga', 'label' => 'Warga', 'description' => 'Akses laporan dan informasi', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
