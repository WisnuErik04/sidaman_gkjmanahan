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
            $table->softDeletes(); // Tambahkan kolom deleted_at
            $table->enum('is_wafat',['0','1'])->default('0'); // 0 = tidak
            $table->date('tgl_wafat')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('keluarga_anggotas', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn('is_wafat');
            $table->dropColumn('tgl_wafat');
        });
    }
};
