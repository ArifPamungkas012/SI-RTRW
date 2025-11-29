<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIuranTemplatesTable extends Migration
{
    public function up()
    {
        Schema::create('iuran_templates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama', 191);
            $table->string('jenis', 100)->nullable(); // bulanan, tahunan, event, dll
            $table->decimal('nominal_default', 15, 2)->default(0);
            $table->text('keterangan')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('iuran_templates');
    }
}
