<?php

namespace App\Http\Controllers;

use App\Models\Keluarga;
use Illuminate\Http\Request;
use App\Models\KeluargaAnggota;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportController extends Controller
{
    public function exportPDF($id)
    {
        $keluarga = Keluarga::findOrFail($id);
        $anggotas = KeluargaAnggota::where('keluarga_id', $id)
                ->orderBy('hubungan_keluarga_id')->orderBy('tgl_lahir')->get();
        // return view('exports.keluarga-anggota', compact('keluarga', 'anggotas'));
        $pdf = Pdf::loadView('exports.keluarga-anggota', compact('keluarga', 'anggotas'))->setPaper('a4', 'landscape');
        return $pdf->download($keluarga->name . '.pdf');
    }
}
