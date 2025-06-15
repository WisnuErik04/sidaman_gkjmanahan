<?php

namespace App\Exports;

use App\Models\Perkawinan;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class PerkawinanSheet implements FromCollection, WithTitle, WithHeadings
{
    public function collection()
    {
        // Ambil hanya kolom yang dibutuhkan: kode dan nama
        return Perkawinan::select('id', 'name')->orderBy('id')->get()
        ->map(function ($item) {
            return [
                'id' => (string) $item->id,    // casting ke string
                'name' => $item->name,
            ];
        });
    }

    public function headings(): array
    {
        return ['Kode', 'Nama'];
    }

    public function title(): string
    {
        return 'Referensi Perkawinan';
    }
}
