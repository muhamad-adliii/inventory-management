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
        Schema::create('detail_transaksi_keluar', function (Blueprint $table) {
            // PK — varchar(10)
            $table->string('id_detail_keluar', 10)->primary();

            // FK → TransaksiKeluar (header nota)
            $table->string('id_transaksi_keluar', 10);
            $table->foreign('id_transaksi_keluar')
                  ->references('id_transaksi_keluar')
                  ->on('transaksi_keluar')
                  ->cascadeOnDelete()      // detail ikut terhapus kalau header dihapus
                  ->cascadeOnUpdate();

            // FK → Produk
            $table->string('id_produk', 10);
            $table->foreign('id_produk')
                  ->references('id_produk')
                  ->on('produk')
                  ->restrictOnDelete()     // produk tidak boleh dihapus kalau dipakai transaksi
                  ->cascadeOnUpdate();

            // Atribut transaksi (snapshot)
            $table->unsignedInteger('jumlah_barang');
            $table->decimal('harga_satuan', 12, 2);
            $table->decimal('total_harga', 14, 2);

            // Index untuk laporan & join
            $table->index('id_transaksi_keluar', 'idx_detail_keluar_nota');
            $table->index('id_produk', 'idx_detail_keluar_produk');

            // Opsional: cegah produk sama dobel di satu nota
            // $table->unique(['id_transaksi_keluar', 'id_produk'], 'uq_detail_keluar_nota_produk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_transaksi_keluar');
    }
};