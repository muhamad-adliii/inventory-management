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
            $table->string('id_transaksi_masuk', 10)->primary();
            $table->dateTime('tanggal');
            $table->decimal('total_harga', 14, 2)->default(0);
            $table->unsignedInteger('jumlah_satuan');
            $table->decimal('harga_satuan', 14, 2);

            $table->string('id_akun', 10);

            $table->foreign('id_akun')
                ->references('id_akun')
                ->on('akun')
                ->restrictOnDelete();

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
