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
        Schema::create('audit_log', function (Blueprint $table) {
            $table->string('id_log', 10)->primary();
            $table->dateTime('tanggal');
            $table->enum('aksi', [
                'tambah_produk',
                'edit_produk',
                'hapus_produk',
                'tambah_akun',
                'hapus_akun',
                'barang_masuk',
                'barang_keluar',
                'retur',
            ]);
            $table->string('entitas', 50);

            $table->string('id_referensi', 10)->nullable();
            $table->string('nama_referensi', 100)->nullable();

            $table->string('id_akun', 10);

            $table->foreign('id_akun')
                ->references('id_akun')
                ->on('akun')
                ->restrictOnDelete();

            $table->index(['id_akun', 'tanggal']);
            $table->index(['entitas', 'id_referensi']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_log');
    }
};
