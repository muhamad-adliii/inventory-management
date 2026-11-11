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
        Schema::create('transaksi_masuk', function (Blueprint $table) {
            // PK
            $table->string('id_transaksi_masuk', 10)->primary();

            // Identitas dokumen
            $table->dateTime('tanggal');
            $table->string('no_invoice', 50)->nullable();

            // FK → Supplier (satu nota = satu supplier)
            $table->string('id_supplier', 10);
            $table->foreign('id_supplier')
                  ->references('id_supplier')
                  ->on('supplier')
                  ->restrictOnDelete()
                  ->cascadeOnUpdate();

            // FK → Akun (admin yang input)
            $table->string('id_akun', 10);
            $table->foreign('id_akun')
                  ->references('id_akun')
                  ->on('akun')
                  ->restrictOnDelete()
                  ->cascadeOnUpdate();

            // Index untuk laporan per supplier & tanggal
            $table->index(['id_supplier', 'tanggal'], 'idx_masuk_supplier_tanggal');

            // Metadata sistem (bukan tanggal transaksi)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_masuk');
    }
};