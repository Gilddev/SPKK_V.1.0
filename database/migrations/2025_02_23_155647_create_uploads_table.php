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
        Schema::create('uploads', function (Blueprint $table) {
            $table->id('upload_id');
            $table->foreignId('id')->constrained('users')->onDelete('cascade'); // Karyawan yang upload
            $table->foreignId('indikator_id')->constrained('indikator_kinerja_individus')->onDelete('cascade'); // Indikator terkait
            $table->string('file_path'); // Simpan path file
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uploads');
    }
};
