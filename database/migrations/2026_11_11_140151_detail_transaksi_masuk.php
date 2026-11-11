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
        Schema::create('detail_transaksi_masuk', function (Blueprint $table) {
            // PK — varchar(10)
            $table->string('id_detail_masuk', 10)->primary();

            // FK → TransaksiMasuk
            $table->string('id_transaksi_masuk', 10);
            $table->foreign('id_transaksi_masuk')
                  ->references('id_transaksi_masuk')
                  ->on('transaksi_masuk')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            // FK → Produk
            $table->string('id_produk', 10);
            $table->foreign('id_produk')
                  ->references('id_produk')
                  ->on('produk')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');

            // Atribut transaksi (snapshot)
            $table->integer('jumlah_barang');
            $table->decimal('harga_satuan', 12, 2);
            $table->decimal('total_harga', 14, 2);

            // Index untuk laporan & join (opsional, tapi disarankan)
            $table->index('id_transaksi_masuk');
            $table->index('id_produk');

            // Opsional: cegah produk sama dobel di satu nota
            // $table->unique(['id_transaksi_masuk', 'id_produk'], 'uq_detail_masuk_nota_produk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_transaksi_masuk');
    }
};