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
        Schema::table('keluarga_anggotas', function (Blueprint $table) {
            // $table->dropColumn('status_anggota_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('keluarga_anggotas', function (Blueprint $table) {
            // $table->foreignId('status_anggota_id')->constrained('status_anggotas')->onDelete('restrict');
        });
    }
};
