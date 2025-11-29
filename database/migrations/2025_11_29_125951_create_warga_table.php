<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWargaTable extends Migration
{
    public function up()
    {
        Schema::create('warga', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nik', 32)->nullable()->index();
            $table->string('nama', 191);
            $table->text('alamat')->nullable();
            $table->string('no_rumah', 50)->nullable();
            $table->string('rt', 10)->nullable()->index();
            $table->string('rw', 10)->nullable()->index();
            $table->string('no_hp', 30)->nullable();
            $table->boolean('status_aktif')->default(true)->index();
            $table->date('tanggal_lahir')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('warga');
    }
}
