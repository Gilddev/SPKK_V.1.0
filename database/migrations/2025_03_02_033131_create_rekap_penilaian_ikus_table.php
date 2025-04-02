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
            $table->id('rekap_penilaian_iku_id');
            $table->foreignId('id')->constrained('users')->onDelete('cascade');
            $table->integer('total_iku')->default(0);
            $table->integer('total_iki')->default(0);
            $table->integer('jumlah_valid')->default(0);
            $table->decimal('persentase_valid', 5, 2)->default(0);
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
