<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditLogsTable extends Migration
{
    public function up()
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('table_name', 100)->nullable();
            $table->unsignedBigInteger('record_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('action', 50)->nullable(); // created, updated, deleted, restored
            $table->text('old_values')->nullable(); // JSON encoded
            $table->text('new_values')->nullable(); // JSON encoded
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->index(['table_name','record_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('audit_logs');
    }
}
