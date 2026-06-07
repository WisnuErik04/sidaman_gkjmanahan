<?php

namespace App\Http\Controllers;

use App\Models\KeluargaAnggota;
use App\Models\KeluargaAnggotaStatusRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatusMigrationController extends Controller
{
    public function migrate(Request $request)
    {
        $created = 0;
        $skipped = 0;

        DB::transaction(function () use (&$created, &$skipped) {
            KeluargaAnggota::query()
                ->whereNotNull('status_anggota_id')
                ->chunkById(200, function ($anggotas) use (&$created, &$skipped) {
                    $records = [];

                    foreach ($anggotas as $anggota) {
                        $statusId = $anggota->status_anggota_id;
                        $tanggalStatus = $anggota->tgl_wafat??now(); // Gunakan tgl_wafat jika ada, jika tidak gunakan tanggal saat ini

                        if (!$statusId) {
                            $skipped++;
                            continue;
                        }

                        $exists = KeluargaAnggotaStatusRecord::where('keluarga_anggota_id', $anggota->id)
                            ->where('status_anggota_id', $statusId)
                            ->where('tanggal_status', $tanggalStatus)
                            ->exists();

                        if ($exists) {
                            $skipped++;
                            continue;
                        }

                        $records[] = [
                            'keluarga_anggota_id' => $anggota->id,
                            'status_anggota_id' => $statusId,
                            'tanggal_status' => $tanggalStatus,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }

                    if (!empty($records)) {
                        KeluargaAnggotaStatusRecord::insert($records);
                        $created += count($records);
                    }
                });

            KeluargaAnggota::query()
                ->where('status_anggota_id', 6)
                // ->where(function ($query) {
                //     $query->where('is_wafat', '<>', 1)->orWhereNull('is_wafat');
                // })
                ->update(['is_wafat' => 1]);
        });

        return response()->json([
            'message' => 'Status migration completed.',
            'created_records' => $created,
            'skipped_records' => $skipped,
        ]);
    }
}
