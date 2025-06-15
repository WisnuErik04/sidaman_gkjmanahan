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
        Schema::create('keluarga_dummies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blok_id')->constrained('bloks')->onDelete(null);
            $table->string('name');
            $table->string('alamat_detail');
            $table->string('alamat_rt');
            $table->string('alamat_rw');
            $table->string('alamat_desa_kelurahan');
            $table->foreign('alamat_desa_kelurahan')->references('kode')->on('wilayahs')->onDelete(null);
            $table->string('alamat_kecamatan');
            $table->foreign('alamat_kecamatan')->references('kode')->on('wilayahs')->onDelete(null);
            $table->string('alamat_kab_kota');
            $table->foreign('alamat_kab_kota')->references('kode')->on('wilayahs')->onDelete(null);
            $table->string('alamat_provinsi');
            $table->foreign('alamat_provinsi')->references('kode')->on('wilayahs')->onDelete(null);
            $table->foreignId('jarak_rumah_id')->constrained('jarak_rumahs')->onDelete(null);

            $table->foreignId('keluarga_id')->nullable()->constrained('keluargas');
            $table->foreignId('user_id_input')->constrained('users')->onDelete(null);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keluarga_dummies');
    }
};
