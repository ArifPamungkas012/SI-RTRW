<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('tanggal')->nullable()->index();
            $table->enum('type', ['in','out'])->default('in'); // masuk/keluar
            $table->string('kategori', 100)->nullable(); // iuran, belanja, sumbangan
            $table->string('reference_table', 100)->nullable(); // mis. 'pembayaran', 'purchase'
            $table->unsignedBigInteger('reference_id')->nullable()->index(); // id di table reference
            $table->decimal('amount', 15, 2)->default(0);
            $table->decimal('balance_after', 15, 2)->nullable()->index();
            $table->unsignedBigInteger('recorded_by')->nullable()->index();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('recorded_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
