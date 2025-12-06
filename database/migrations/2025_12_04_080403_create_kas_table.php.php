<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('kas', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->enum('tipe', ['masuk', 'keluar']); // kas masuk / keluar
            $table->string('kategori');
            $table->integer('nominal');
            $table->text('keterangan')->nullable();
            $table->unsignedBigInteger('recorded_by')->nullable(); // user pencatat
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('recorded_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kas');
    }
};
