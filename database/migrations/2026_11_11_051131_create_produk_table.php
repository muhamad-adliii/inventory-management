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
        Schema::create('produk', function (Blueprint $table) {
            $table->string('id_produk', 10)->primary();
            $table->string('nama_produk', 100);
            $table->decimal('harga', 12, 2);
            $table->unsignedInteger('stok')->default(0);
            $table->enum('satuan', ['pcs', 'unit', 'karton'])->default('pcs');
            $table->text('deskripsi')->nullable();
            $table->string('path_gambar', 255)->nullable();
            $table->string('lokasi_rak', 50)->nullable();

            $table->string('id_kategori', 10);
            $table->string('id_supplier', 10);

            $table->foreign('id_kategori')
                ->references('id_kategori')
                ->on('kategori')
                ->restrictOnDelete();

            $table->foreign('id_supplier')
                ->references('id_supplier')
                ->on('supplier')
                ->restrictOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
