<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('keluarga_anggotas', function (Blueprint $table) {
            // $table->foreignId('status_anggota_id')->constrained('status_anggotas')->onDelete(null);
            $table->foreignId('status_anggota_id')->nullable()->constrained('status_anggotas')->onDelete('set null');
        });

        // ----------------------------------------------------
        // LANGKAH 2: Migrasi Data Lama ke Tabel Pivot
        // ----------------------------------------------------
        $records = DB::table('keluarga_anggotas')
                      ->select('id', 'penyakit_id')
                      ->whereNotNull('penyakit_id')
                      ->get();
        if ($records->isNotEmpty()) {
            foreach ($records as $record) {
                
                // 1. Siapkan data untuk di-insert ke tabel pivot
                $dataToInsert = [
                    'keluarga_anggota_id' => $record->id, 
                    'penyakit_id' => $record->penyakit_id,
                    'created_at' => now(), // Tambahkan timestamp
                    'updated_at' => now(),
                ];  
                $keluargaAnggotaId = $record->id;
                // 2. Insert data dan dapatkan ID baris yang baru dibuat (insertGetId)
                DB::table('keluarga_anggota_penyakits')->insertGetId($dataToInsert);
            }
        }

        $records = DB::table('keluarga_anggotas')
                      ->select('id', 'hobi_id')
                      ->whereNotNull('hobi_id')
                      ->get();
        if ($records->isNotEmpty()) {
            foreach ($records as $record) {
                
                // 1. Siapkan data untuk di-insert ke tabel pivot
                $dataToInsert = [
                    'keluarga_anggota_id' => $record->id, 
                    'hobi_id' => $record->hobi_id,
                    'created_at' => now(), // Tambahkan timestamp
                    'updated_at' => now(),
                ];  
                $keluargaAnggotaId = $record->id;
                // 2. Insert data dan dapatkan ID baris yang baru dibuat (insertGetId)
                DB::table('keluarga_anggota_hobis')->insertGetId($dataToInsert);
            }
        }

      
        // ----------------------------------------------------
        // LANGKAH 3: Hapus Kolom Lama
        // ----------------------------------------------------
        // Schema::table('records', function (Blueprint $table) {
        //     // Hapus foreign key constraint (PENTING)
        //     $table->dropForeign(['penyakit_id']); 
        //     // Hapus kolom
        //     $table->dropColumn('penyakit_id');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('keluarga_anggotas', function (Blueprint $table) {
            $table->dropForeign(['status_anggota_id']); 
            $table->dropColumn('status_anggota_id');
        });
    }
};
