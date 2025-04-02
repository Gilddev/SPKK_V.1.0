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
        Schema::create('indikator_kinerja_individus', function (Blueprint $table) {
            $table->id('indikator_id');
            $table->string('deskripsi_indikator');
            $table->foreignId('unit_id')->constrained('units')->onDelete('cascade');
            $table->foreignId('id')->constrained('users')->onDelete('cascade'); // Menyimpan ID validator dari tabel users
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indikator_kinerja_individus');
    }
};
