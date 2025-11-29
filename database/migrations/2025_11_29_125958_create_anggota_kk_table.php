<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnggotaKkTable extends Migration
{
    public function up()
    {
        Schema::create('anggota_kk', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('kk_id')->index();
            $table->unsignedBigInteger('warga_id')->nullable()->index();
            $table->string('hubungan', 100)->nullable(); // kepala, anak, istri, dll
            $table->timestamps();

            $table->foreign('kk_id')->references('id')->on('kartu_keluarga')->onDelete('cascade');
            $table->foreign('warga_id')->references('id')->on('warga')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('anggota_kk');
    }
}
