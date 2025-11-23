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
            $table->foreignId('status_anggota_id')->nullable()->constrained('status_anggotas')->onDelete('set null');
            $table->dropForeign(['user_id']);

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            if (Schema::hasColumn('keluarga_anggota_dummies', 'hobi_id')) {
                $table->dropForeign(['hobi_id']);
                $table->dropColumn('hobi_id');
            }

            if (Schema::hasColumn('keluarga_anggota_dummies', 'penyakit_id')) {
                $table->dropForeign(['penyakit_id']);
                $table->dropColumn('penyakit_id');
            }

            // Tambahkan kolom JSON
            $table->json('hobi_id')->nullable();
            $table->json('penyakit_id')->nullable();
            $table->date('tgl_wafat')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('keluarga_anggota_dummies', function (Blueprint $table) {
            $table->dropForeign(['status_anggota_id']);
            $table->dropColumn('status_anggota_id');
            $table->dropForeign(['user_id']);

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            // Drop kolom JSON
            if (Schema::hasColumn('keluarga_anggota_dummies', 'hobi_id')) {
                $table->dropColumn('hobi_id');
            }
            if (Schema::hasColumn('keluarga_anggota_dummies', 'penyakit_id')) {
                $table->dropColumn('penyakit_id');
            }

            // Kembalikan kolom lama
            $table->unsignedBigInteger('hobi_id')->nullable();
            $table->unsignedBigInteger('penyakit_id')->nullable();

            // Kembalikan FK lama
            $table->foreign('hobi_id')->references('id')->on('hobis')->onDelete('set null');
            $table->foreign('penyakit_id')->references('id')->on('penyakits')->onDelete('set null');
            $table->dropColumn('tgl_wafat');
        });
    }
};
