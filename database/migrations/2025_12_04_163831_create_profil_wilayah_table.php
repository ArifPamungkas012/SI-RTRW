<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('profil_wilayah', function (Blueprint $table) {
            $table->id();
            $table->string('nama_rt_rw'); // contoh: RT 05 / RW 03
            $table->string('alamat_sekretariat')->nullable();
            $table->string('kontak')->nullable(); // no HP / WA
            $table->string('logo_path')->nullable(); // path logo
            $table->text('deskripsi')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profil_wilayah');
    }
};
