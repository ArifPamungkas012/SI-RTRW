<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            // gunakan id standar Laravel untuk kompatibilitas
            $table->bigIncrements('id');
            $table->string('username', 100)->unique();
            $table->string('name', 191)->nullable();
            $table->string('email', 191)->nullable()->unique();
            $table->string('password')->nullable();
            $table->string('role', 50)->default('user'); // admin, ketua_rt, bendahara, user, dll
            $table->unsignedBigInteger('warga_id')->nullable()->index();
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('warga_id')->references('id')->on('warga')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('users');
        Schema::enableForeignKeyConstraints();
    }
}
