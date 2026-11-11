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
            $table->string('id_retur', 10)->primary();
            $table->dateTime('tanggal');

            $table->enum('status_retur', [
                'pending',
                'approved',
                'rejected'
            ])->default('pending');

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
        Schema::dropIfExists('retur');
    }
};
