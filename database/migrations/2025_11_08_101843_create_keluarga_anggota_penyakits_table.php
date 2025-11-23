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
        Schema::create('keluarga_anggota_penyakits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('keluarga_anggota_id')->constrained('keluarga_anggotas')->onDelete('cascade');
            $table->foreignId('penyakit_id')->constrained('penyakits')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keluarga_anggota_penyakits');
    }
};
