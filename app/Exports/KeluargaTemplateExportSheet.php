<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KeluargaTemplateExportSheet implements FromCollection, WithTitle, WithHeadings, WithColumnWidths
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Kosongkan atau isi dengan contoh data dummy
        return collect([
            [
                '1',
                'Yohanes Supardi',
                'Jl. Anggrek No.12',
                '001',
                '002',
                'Kalirejo',
                'Ungaran Timur',
                'Kab. Semarang',
                'Jawa Tengah',
                '1'
            ],
            [
                '1',
                'Yohanes Adi',
                'Jl. Mawar No.5',
                '005',
                '006',
                'Gedong',
                'Banyubiru',
                'Semarang',
                'Jawa Tengah',
                '1'

            ],
            [
                '5',
                'Maria Indah',
                'Jl. Anggrek 10',
                '003',
                '009',
                'Blotongan',
                'Sidorejo',
                'Salatiga',
                'Jawa Tengah',
                '1'
            ]
        ]);
    }

    public function headings(): array
    {
        return [
            "Blok/ Pepanthan (kode)",
            "Nama Kepala Keluarga",
            "Alamat Lengkap",
            "RT",
            "RW",
            "Desa/ Kelurahan",
            "Kecamatan",
            "Kabupaten/ Kota",
            "Provinsi",
            "Jarak Dari Rumah Ke Tempat Ibadah (kode)",
        ];
    }

    public function title(): string
    {
        return 'Template Import Keluarga';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 10, 
            'B' => 25, 
            'C' => 35, 
            'D' => 8, 
            'E' => 8, 
            'F' => 20, 
            'G' => 20, 
            'H' => 20, 
            'I' => 20, 
            'J' => 10, 
        ];
    }
}
