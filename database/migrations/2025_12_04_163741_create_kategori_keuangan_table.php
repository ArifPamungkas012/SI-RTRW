<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kategori_keuangan', function (Blueprint $table) {
            $table->id();
            $table->string('nama'); // contoh: Iuran Kebersihan, Operasional
            $table->enum('tipe', ['masuk', 'keluar']); // tipe kas
            $table->string('kode', 20)->nullable(); // IK, OP, dll (opsional)
            $table->text('deskripsi')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kategori_keuangan');
    }
};
