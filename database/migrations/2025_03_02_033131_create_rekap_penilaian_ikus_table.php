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
        Schema::create('rekap_penilaian_ikus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('karyawan_id')->constrained('users')->onDelete('cascade');
            $table->unsignedSmallInteger('tahun'); // e.g., 2025
            $table->unsignedTinyInteger('bulan');  // e.g., 7
            $table->integer('total_iku')->default(0);
            $table->integer('total_iku_valid')->default(0);
            $table->decimal('persentase_iku_valid', 5, 2)->default(0);
            $table->integer('total_iki')->default(0);
            $table->integer('total_iki_valid')->default(0);
            $table->decimal('persentase_iki_valid', 5, 2)->default(0);
            $table->decimal('persentase_kinerja', 5, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekap_penilaian_ikus');
    }
};
