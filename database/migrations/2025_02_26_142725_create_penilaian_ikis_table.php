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
        Schema::create('penilaian_ikis', function (Blueprint $table) {
            $table->id();

            $table->unsignedSmallInteger('tahun'); // e.g., 2025
            $table->unsignedTinyInteger('bulan');  // e.g., 7

            // Foreign key ke karyawan (yang dinilai)
            $table->foreignId('karyawan_id')->constrained('users')->onDelete('cascade');

            // Foreign key ke validator (yang menilai)
            $table->foreignId('validator_id')->constrained('users')->onDelete('cascade');

            $table->foreignId('upload_iki_id')->constrained('upload_ikis')->onDelete('cascade'); // Indikator Kinerja Individu (IKI)
            $table->enum('status', ['valid', 'tidak valid'])->default('tidak valid');
            $table->text('catatan')->nullable();
            $table->timestamps();

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
