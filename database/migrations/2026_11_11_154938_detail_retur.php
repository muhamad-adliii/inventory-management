<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('detail_retur', function (Blueprint $table) {
            // PK — varchar(10)
            $table->string('id_detail_retur', 10)->primary();

            // FK → Retur (header nota retur)
            $table->string('id_retur', 10);
            $table->foreign('id_retur')
                  ->references('id_retur')
                  ->on('retur')
                  ->cascadeOnDelete()      // detail ikut terhapus kalau header dihapus
                  ->cascadeOnUpdate();

            // FK → Produk
            $table->string('id_produk', 10);
            $table->foreign('id_produk')
                  ->references('id_produk')
                  ->on('produk')
                  ->restrictOnDelete()     // produk tidak boleh dihapus kalau dipakai retur
                  ->cascadeOnUpdate();

            // FK → TransaksiMasuk (batch asal — traceability)
            $table->string('id_transaksi_masuk', 10);
            $table->foreign('id_transaksi_masuk')
                  ->references('id_transaksi_masuk')
                  ->on('transaksi_masuk')
                  ->restrictOnDelete()     // batch masuk tidak boleh dihapus kalau sudah diretur
                  ->cascadeOnUpdate();

            // Jumlah unit yang diretur (per baris)
            $table->unsignedInteger('jumlah_retur');

            // Index untuk laporan & validasi "sisa batch"
            $table->index('id_retur', 'idx_detail_retur_header');
            $table->index('id_produk', 'idx_detail_retur_produk');
            $table->index(['id_produk', 'id_transaksi_masuk'], 'idx_detail_retur_validasi');

            // Opsional: cegah produk + batch sama dobel di satu retur
            // $table->unique(['id_retur', 'id_produk', 'id_transaksi_masuk'], 'uq_detail_retur_baris');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_retur');
    }
};