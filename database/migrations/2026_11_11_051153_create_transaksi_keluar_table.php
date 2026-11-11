<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksi_keluar', function (Blueprint $table) {
            // PK
            $table->string('id_transaksi_keluar', 10)->primary();

            // Identitas dokumen
            $table->dateTime('tanggal');
            $table->string('no_invoice', 50)->nullable();

            // FK → Customer (satu nota = satu customer)
            $table->string('id_customer', 10);
            $table->foreign('id_customer')
                  ->references('id_customer')
                  ->on('customer')
                  ->restrictOnDelete()
                  ->cascadeOnUpdate();

            // FK → Akun (admin yang input)
            $table->string('id_akun', 10);
            $table->foreign('id_akun')
                  ->references('id_akun')
                  ->on('akun')
                  ->restrictOnDelete()
                  ->cascadeOnUpdate();

            // Index untuk laporan per customer & tanggal
            $table->index(['id_customer', 'tanggal'], 'idx_keluar_customer_tanggal');

            // Metadata sistem (bukan tanggal transaksi)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_keluar');
    }
};