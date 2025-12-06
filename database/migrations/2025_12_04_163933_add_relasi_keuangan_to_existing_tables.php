<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        /**
         * IURAN_TEMPLATES
         * tambah kategori_keuangan_id
         */
        if (Schema::hasTable('iuran_templates')) {
            Schema::table('iuran_templates', function (Blueprint $table) {
                if (!Schema::hasColumn('iuran_templates', 'kategori_keuangan_id')) {
                    $table->unsignedBigInteger('kategori_keuangan_id')
                        ->nullable()
                        ->after('keterangan');

                    $table->foreign('kategori_keuangan_id')
                        ->references('id')
                        ->on('kategori_keuangan')
                        ->nullOnDelete();
                }
            });
        }

        /**
         * KAS
         * tambah kategori_id
         */
        if (Schema::hasTable('kas')) {
            Schema::table('kas', function (Blueprint $table) {
                if (!Schema::hasColumn('kas', 'kategori_id')) {
                    $table->unsignedBigInteger('kategori_id')
                        ->nullable()
                        ->after('kategori');

                    $table->foreign('kategori_id')
                        ->references('id')
                        ->on('kategori_keuangan')
                        ->nullOnDelete();
                }
            });
        }

        /**
         * TRANSACTIONS
         * tambah kategori_id
         */
        if (Schema::hasTable('transactions')) {
            Schema::table('transactions', function (Blueprint $table) {
                if (!Schema::hasColumn('transactions', 'kategori_id')) {
                    $table->unsignedBigInteger('kategori_id')
                        ->nullable()
                        ->after('kategori');

                    $table->foreign('kategori_id')
                        ->references('id')
                        ->on('kategori_keuangan')
                        ->nullOnDelete();
                }
            });
        }

        /**
         * PEMBAYARAN
         * tambah metode_id
         */
        if (Schema::hasTable('pembayaran')) {
            Schema::table('pembayaran', function (Blueprint $table) {
                if (!Schema::hasColumn('pembayaran', 'metode_id')) {
                    $table->unsignedBigInteger('metode_id')
                        ->nullable()
                        ->after('metode');

                    $table->foreign('metode_id')
                        ->references('id')
                        ->on('metode_pembayaran')
                        ->nullOnDelete();
                }
            });
        }
    }

    public function down(): void
    {
        /**
         * Rollback FK dan kolom baru
         */

        if (Schema::hasTable('iuran_templates')) {
            Schema::table('iuran_templates', function (Blueprint $table) {
                if (Schema::hasColumn('iuran_templates', 'kategori_keuangan_id')) {
                    $table->dropForeign(['kategori_keuangan_id']);
                    $table->dropColumn('kategori_keuangan_id');
                }
            });
        }

        if (Schema::hasTable('kas')) {
            Schema::table('kas', function (Blueprint $table) {
                if (Schema::hasColumn('kas', 'kategori_id')) {
                    $table->dropForeign(['kategori_id']);
                    $table->dropColumn('kategori_id');
                }
            });
        }

        if (Schema::hasTable('transactions')) {
            Schema::table('transactions', function (Blueprint $table) {
                if (Schema::hasColumn('transactions', 'kategori_id')) {
                    $table->dropForeign(['kategori_id']);
                    $table->dropColumn('kategori_id');
                }
            });
        }

        if (Schema::hasTable('pembayaran')) {
            Schema::table('pembayaran', function (Blueprint $table) {
                if (Schema::hasColumn('pembayaran', 'metode_id')) {
                    $table->dropForeign(['metode_id']);
                    $table->dropColumn('metode_id');
                }
            });
        }
    }
};
