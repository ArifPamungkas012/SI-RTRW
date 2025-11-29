<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('kegiatan', function (Blueprint $table) {
        $table->string('status', 50)->default('active')->after('keterangan');
    });
}

public function down()
{
    Schema::table('kegiatan', function (Blueprint $table) {
        $table->dropColumn('status');
    });
}

};
