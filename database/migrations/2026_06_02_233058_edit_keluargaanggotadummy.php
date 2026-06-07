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
        Schema::table('keluarga_anggota_dummies', function (Blueprint $table) {
            $table->renameColumn('tgl_wafat', 'tanggal_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('keluarga_anggota_dummies', function (Blueprint $table) {
            $table->renameColumn('tanggal_status', 'tgl_wafat');
            //
        });
    }
};
