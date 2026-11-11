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
            // PK
            $table->string('id_log', 10)->primary();

            // Waktu aksi (bisnis)
            $table->dateTime('tanggal');

            // Jenis aksi — varchar (bukan enum) agar fleksibel.
            // Validasi di aplikasi via konstanta/array (misal App\Enums\AksiLog).
            // Nilai: TAMBAH_PRODUK, EDIT_PRODUK, HAPUS_PRODUK, TAMBAH_AKUN, HAPUS_AKUN,
            //        TRANSAKSI_MASUK, TRANSAKSI_KELUAR, RETUR,
            //        APPROVE_RETUR, REJECT_RETUR,
            //        TAMBAH_KATEGORI, EDIT_KATEGORI, HAPUS_KATEGORI,
            //        TAMBAH_SUPPLIER, EDIT_SUPPLIER, HAPUS_SUPPLIER,
            //        TAMBAH_CUSTOMER, EDIT_CUSTOMER, HAPUS_CUSTOMER,
            //        LOGIN, LOGOUT
            $table->string('aksi', 50);

            // Nama entitas target (Produk, Akun, TransaksiMasuk, Retur, dll)
            $table->string('entitas', 50);

            // Snapshot referensi (polimorfik — TANPA FK, sengaja)
            $table->string('id_referensi', 10)->nullable();
            $table->string('nama_referensi', 100)->nullable();

            // Konteks tambahan (JSON: before/after, alasan, dll)
            $table->text('detail')->nullable();

            // FK → Akun (pelaku)
            $table->string('id_akun', 10);
            $table->foreign('id_akun')
                  ->references('id_akun')
                  ->on('akun')
                  ->restrictOnDelete()
                  ->cascadeOnUpdate();

            // Index untuk query umum
            $table->index(['id_akun', 'tanggal'], 'idx_log_akun_tanggal');
            $table->index(['entitas', 'id_referensi'], 'idx_log_entitas_ref');
            $table->index(['aksi', 'tanggal'], 'idx_log_aksi_tanggal');

            // TIDAK ada timestamps() — log immutable, tanggal sudah ada.
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