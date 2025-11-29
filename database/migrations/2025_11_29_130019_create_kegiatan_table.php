<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKegiatanTable extends Migration
{
    public function up()
    {
        Schema::create('kegiatan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama', 191);
            $table->string('jenis', 100)->nullable();
            $table->date('tanggal')->nullable()->index();
            $table->string('waktu', 50)->nullable();
            $table->string('lokasi', 191)->nullable();
            $table->text('keterangan')->nullable();
            $table->unsignedBigInteger('penanggung_jawab_user_id')->nullable()->index();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('penanggung_jawab_user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('kegiatan');
    }
}
