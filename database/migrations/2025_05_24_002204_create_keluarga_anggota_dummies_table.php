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
        Schema::create('keluarga_anggota_dummies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('keluarga_id')->constrained('keluargas')->onDelete(null);
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete(null);
            $table->string('name');
            $table->enum('jns_kelamin',['L','P'])->default('L');
            $table->string('nomor_induk_gereja');
            $table->foreignId('hubungan_keluarga_id')->constrained('hubungan_keluargas')->onDelete(null);
            $table->foreignId('perkawinan_id')->constrained('perkawinans')->onDelete(null);
            $table->date('tgl_lahir');
            $table->foreignId('gol_darah_id')->constrained('gol_darahs')->onDelete(null);
            $table->foreignId('ijazah_id')->constrained('ijazahs')->onDelete(null);
            $table->foreignId('pekerjaan_id')->constrained('pekerjaans')->onDelete(null);
            $table->foreignId('pendapatan_id')->nullable_id()->constrained('pendapatans')->onDelete(null);
            
            $table->foreignId('tempat_babtis_id')->constrained('tempat_babtises')->onDelete(null);
            $table->date('tgl_babtis');
            $table->foreignId('tempat_sidi_id')->constrained('tempat_sidis')->onDelete(null);
            $table->date('tgl_sidi');
            $table->foreignId('hobi_id')->constrained('hobis')->onDelete(null);
            $table->string('aktifitas_pelayanan');
            $table->enum('memiliki_bpjs_asuransi',['1','2'])->default('1'); // 1 = Ya, 2 = Tidak
            $table->foreignId('penyakit_id')->constrained('penyakits')->onDelete(null);
            $table->enum('domisili_alamat',['1','2'])->default('1'); // 1 = Ya, 2 = Tidak
            $table->string('nomor_wa')->nullable();

            
            $table->foreignId('keluarga_anggota_id')->nullable()->constrained('keluarga_anggotas');
            $table->foreignId('user_id_input')->constrained('users')->onDelete(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keluarga_anggota_dummies');
    }
};
