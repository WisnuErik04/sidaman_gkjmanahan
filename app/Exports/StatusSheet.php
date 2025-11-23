<?php

namespace App\Exports;

use App\Models\StatusAnggota;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class StatusSheet implements FromCollection, WithTitle, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return StatusAnggota::select('id', 'name')->orderBy('id')->get()
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
        return 'Referensi Status Anggota';
    }
}
