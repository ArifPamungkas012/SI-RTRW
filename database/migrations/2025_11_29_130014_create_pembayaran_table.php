<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembayaranTable extends Migration
{
    public function up()
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('iuran_instance_id')->index(); // mengacu ke iuran_instances
            $table->unsignedBigInteger('warga_id')->index();
            $table->date('tanggal_bayar')->nullable()->index();
            $table->decimal('amount', 15, 2)->default(0);
            $table->string('metode', 100)->nullable(); // tunai, transfer, e-wallet
            $table->string('status_verifikasi', 50)->default('pending'); // pending, verified, rejected
            $table->string('receipt_no', 100)->nullable()->index();
            $table->string('proof_path')->nullable(); // path file bukti
            $table->unsignedBigInteger('recorded_by')->nullable()->index();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('iuran_instance_id')->references('id')->on('iuran_instances')->onDelete('cascade');
            $table->foreign('warga_id')->references('id')->on('warga')->onDelete('cascade');
            $table->foreign('recorded_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pembayaran');
    }
}
