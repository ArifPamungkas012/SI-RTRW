<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKegiatanWargaTable extends Migration
{
    public function up()
    {
        Schema::create('kegiatan_warga', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('kegiatan_id')->index();
            $table->unsignedBigInteger('warga_id')->index();
            $table->string('role', 100)->nullable(); // panitia, peserta, tamu
            $table->string('status', 50)->default('invited'); // invited, confirmed, hadir, tidak_hadir
            $table->timestamps();

            $table->foreign('kegiatan_id')->references('id')->on('kegiatan')->onDelete('cascade');
            $table->foreign('warga_id')->references('id')->on('warga')->onDelete('cascade');

            $table->unique(['kegiatan_id','warga_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('kegiatan_warga');
    }
}
