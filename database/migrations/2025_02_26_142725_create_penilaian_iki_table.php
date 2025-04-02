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
        Schema::create('penilaian_iki', function (Blueprint $table) {
            $table->id('penilaian_iki_id');
            $table->unsignedBigInteger('validator_id'); // User yang memvalidasi (role: validator/admin)
            $table->unsignedBigInteger('karyawan_id'); // User yang dinilai (role: karyawan)
            $table->unsignedBigInteger('iki_id'); // Indikator Kinerja Individu (IKI)
            $table->enum('status', ['valid', 'tidak valid'])->default('tidak valid');
            $table->text('catatan')->nullable();
            $table->timestamps();

            // Relasi ke users
            $table->foreign('validator_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('karyawan_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('iki_id')->references('iki_id')->on('indikator_kinerja_individus')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian_iki');
    }
};
