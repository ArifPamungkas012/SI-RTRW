<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('mutasi_warga', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('warga_id');
            $table->enum('jenis', ['masuk', 'keluar', 'pindah_rt', 'pindah_rw'])->index();
            $table->date('tanggal')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('warga_id')
                ->references('id')
                ->on('warga')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('mutasi_warga', function (Blueprint $table) {
            $table->dropForeign(['warga_id']);
        });

        Schema::dropIfExists('mutasi_warga');
    }
};
