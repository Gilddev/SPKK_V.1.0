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
        Schema::create('upload_ikis', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun');
            $table->integer('bulan');
            $table->foreignId('karyawan_id')->constrained('users')->onDelete('cascade'); // Karyawan yang upload
            $table->foreignId('iki_id')->constrained('ikis')->onDelete('cascade'); // Indikator terkait
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
