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

            $table->string('nomor_induk_gereja')->nullable()->change();
            $table->string('aktifitas_pelayanan')->nullable()->change();
            $table->date('tgl_babtis')->nullable()->change();
            $table->date('tgl_sidi')->nullable()->change();
            $table->string('nomor_wa')->nullable()->change();

            $table->unsignedBigInteger('gol_darah_id')->nullable()->change();
            $table->unsignedBigInteger('pendapatan_id')->nullable()->change();
            $table->unsignedBigInteger('tempat_babtis_id')->nullable()->change();
            $table->unsignedBigInteger('tempat_sidi_id')->nullable()->change();
            $table->unsignedBigInteger('hobi_id')->nullable()->change();
            $table->unsignedBigInteger('penyakit_id')->nullable()->change();
        });

        // tambahkan foreign key baru (tanpa drop)
        // Schema::table('keluarga_anggota_dummies', function (Blueprint $table) {
        //     $table->foreign('gol_darah_id')->references('id')->on('gol_darahs')->nullOnDelete();
        //     $table->foreign('pendapatan_id')->references('id')->on('pendapatans')->nullOnDelete();
        //     $table->foreign('tempat_babtis_id')->references('id')->on('tempat_babtises')->nullOnDelete();
        //     $table->foreign('tempat_sidi_id')->references('id')->on('tempat_sidis')->nullOnDelete();
        //     $table->foreign('hobi_id')->references('id')->on('hobis')->nullOnDelete();
        //     $table->foreign('penyakit_id')->references('id')->on('penyakits')->nullOnDelete();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('keluarga_anggota_dummies', function (Blueprint $table) {
            // kalau rollback, buat not nullable lagi
            $table->string('nomor_induk_gereja')->nullable(false)->change();
            $table->string('aktifitas_pelayanan')->nullable(false)->change();
            $table->date('tgl_babtis')->nullable(false)->change();
            $table->date('tgl_sidi')->nullable(false)->change();

            $table->unsignedBigInteger('gol_darah_id')->nullable(false)->change();
            $table->unsignedBigInteger('pendapatan_id')->nullable(false)->change();
            $table->unsignedBigInteger('tempat_babtis_id')->nullable(false)->change();
            $table->unsignedBigInteger('tempat_sidi_id')->nullable(false)->change();
            $table->unsignedBigInteger('hobi_id')->nullable(false)->change();
            $table->unsignedBigInteger('penyakit_id')->nullable(false)->change();
        });
    }
};
