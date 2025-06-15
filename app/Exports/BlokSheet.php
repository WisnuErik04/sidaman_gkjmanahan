<?php

namespace App\Exports;

use App\Models\Blok;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class BlokSheet implements FromCollection, WithTitle, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Ambil hanya kolom yang dibutuhkan: kode dan nama
        return Blok::select('id', 'name')->orderBy('name')->get()
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
        return 'Referensi Blok';
    }
}
