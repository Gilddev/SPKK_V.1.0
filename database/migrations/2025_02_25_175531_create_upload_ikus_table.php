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
        Schema::create('upload_ikus', function (Blueprint $table) {
            $table->id('upload_iku_id');
            $table->foreignId('id')->constrained('users')->onDelete('cascade'); // Karyawan yang upload
            $table->foreignId('iku_id')->constrained('indikator_kinerja_utamas')->onDelete('cascade'); // Indikator terkait
            $table->string('file_path'); // Simpan path file
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('upload_ikus');
    }
};
