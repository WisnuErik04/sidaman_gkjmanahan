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
        Schema::create('keluarga_anggota_hobis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('keluarga_anggota_id')->constrained('keluarga_anggotas')->onDelete('cascade');
            $table->foreignId('hobi_id')->constrained('hobis')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keluarga_anggota_hobis');
    }
};
