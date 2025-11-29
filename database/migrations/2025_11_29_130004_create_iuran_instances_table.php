<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIuranInstancesTable extends Migration
{
    public function up()
    {
        Schema::create('iuran_instances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('template_id')->index();
            $table->string('periode', 32)->nullable()->index(); // e.g. "2025-11" or "Nov 2025"
            $table->date('due_date')->nullable();
            $table->decimal('nominal', 15, 2)->default(0);
            $table->string('status', 50)->default('open'); // open, closed, canceled
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('template_id')->references('id')->on('iuran_templates')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('iuran_instances');
    }
}
