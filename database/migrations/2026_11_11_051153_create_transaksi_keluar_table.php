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
            $table->string('id_transaksi_keluar', 10)->primary();
            $table->dateTime('tanggal');

            $table->string('id_produk', 10);
            $table->unsignedInteger('jumlah_satuan');
            $table->decimal('harga_satuan', 14, 2);
            $table->decimal('total_harga', 14, 2)->default(0);

            $table->string('id_customer', 10);
            $table->string('id_akun', 10);

            $table->foreign('id_produk')->references('id_produk')->on('produk')->restrictOnDelete();
            $table->foreign('id_customer')->references('id_customer')->on('customer')->restrictOnDelete();
            $table->foreign('id_akun')->references('id_akun')->on('akun')->restrictOnDelete();

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
