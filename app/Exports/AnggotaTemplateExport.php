<?php

namespace App\Exports;
 
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class AnggotaTemplateExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new KeluargaAnggotaTemplateExportSheet(),
            new BlokSheet(),
            new HubunganKeluargaSheet(),
            new PerkawinanSheet(),
            new GolDarahSheet(),
            new IjazahSheet(),
            new PekerjaanSheet(),
            new PendapatanSheet(),
            new TempatBabtisSheet(),
            new TempatSidiSheet(),
            new HobiSheet(),
            new PenyakitSheet(),
        ];
    }
}
