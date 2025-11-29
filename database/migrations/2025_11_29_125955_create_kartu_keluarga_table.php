<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKartuKeluargaTable extends Migration
{
    public function up()
    {
        Schema::create('kartu_keluarga', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('no_kk', 64)->unique();
            $table->text('alamat')->nullable();
            $table->string('rt', 10)->nullable()->index();
            $table->string('rw', 10)->nullable()->index();
            $table->string('kepala_keluarga', 191)->nullable();
            $table->date('tanggal_dibuat')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kartu_keluarga');
    }
}
