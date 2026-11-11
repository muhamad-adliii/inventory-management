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
        Schema::create('retur', function (Blueprint $table) {
            // PK
            $table->string('id_retur', 10)->primary();

            // Identitas dokumen
            $table->dateTime('tanggal');
            $table->string('alasan', 255);                    // NOT NULL
            $table->string('dokumentasi_path', 255)->nullable();

            // Status approval (state machine: pending → approved/rejected)
            // Setiap perubahan status WAJIB dicatat di AuditLog (atomik)
            $table->enum('status_retur', [
                'pending',
                'approved',
                'rejected'
            ])->default('pending');

            // FK → Akun (admin yang ajukan)
            $table->string('id_akun', 10);
            $table->foreign('id_akun')
                  ->references('id_akun')
                  ->on('akun')
                  ->restrictOnDelete()
                  ->cascadeOnUpdate();

            // Index untuk antrian approval & laporan retur per periode
            $table->index('status_retur', 'idx_retur_status');
            $table->index('tanggal', 'idx_retur_tanggal');

            // Metadata sistem (bukan tanggal transaksi)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('retur');
    }
};