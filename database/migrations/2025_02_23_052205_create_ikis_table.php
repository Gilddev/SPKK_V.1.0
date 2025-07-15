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
        Schema::create('ikis', function (Blueprint $table) {
            $table->id();
            $table->string('deskripsi_indikator');
            $table->string('Indikator_keberhasilan');
            $table->string('parameter');
            $table->json('allow_file_types')->nullable();
            $table->foreignId('unit_id')->constrained('units')->onDelete('cascade');
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
