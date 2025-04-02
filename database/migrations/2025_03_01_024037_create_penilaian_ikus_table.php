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
        Schema::create('penilaian_ikus', function (Blueprint $table) {
            $table->id('penilaian_iku_id');
            $table->unsignedBigInteger('id'); // Validator yang menilai
            $table->unsignedBigInteger('iku_id'); // Indikator yang dinilai
            $table->enum('status', ['valid', 'tidak valid'])->default('valid'); // Status validasi
            $table->timestamps();

            // Foreign key
            $table->foreign('id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('iku_id')->references('iku_id')->on('indikator_kinerja_utamas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian_ikus');
    }
};
