<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class KeluargaTemplateExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new KeluargaTemplateExportSheet(),
            new BlokSheet(),
            new JarakRumahSheet(),
        ];
    }
}
