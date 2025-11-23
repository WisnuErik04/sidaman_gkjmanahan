<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class KeluargaAnggotaTemplateExportSheet implements FromCollection, WithTitle, WithHeadings, WithColumnWidths
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Kosongkan atau isi dengan contoh data dummy
        return collect([
            [
            'Yohanes Supardi',                        // Keluarga
            '1',                      // Blok (kode)
            'Mario',         // Nama anggota keluarga
            'L',                        // Jenis kelamin (kode)
            '12345678',                // Nomor Induk Gereja
            '1',                        // Hubungan keluarga (kode)
            '2',                        // Status perkawinan (kode)
            '15-01-1980',              // Tanggal lahir
            '1',                        // Golongan darah (kode)
            '8',                       // Ijasah terakhir (kode)
            '6',                      // Kegiatan/ Pekerjaan (kode)
            '1',                 // Pendapatan per bulan (kode)
            '1',                        // Tempat baptis anak (kode)
            '01-06-1985',              // Tanggal baptis anak
            '2',                        // Tempat baptis dewasa/ Sidi (kode)
            '20-08-2000',              // Tanggal baptis dewasa/ Sidi
            '5, 3,4',                    // Talenta/ Hobi (kode)
            'Paduan Suara',             // Aktivitas pelayanan yg aktif diikuti
            'Y',                        // Memiliki bpjs atau asuransi lainnya (kode)
            '0',                        // Apakah mempunyai penyakit kronis (kode)
            'Y',                        // Domisili di alamat ini (kode)
            '081234567890',            // Nomor WA
            '3',                        // Status
            '',                         // Tanggal wafat
        ],
        [
            'Yohanes Adi',
            '1',
            'Alex',
            'L',
            '87654321',
            '2',
            '1',
            '12-04-2005',
            '3',
            '7',
            '3',
            '2',
            '1',
            '01-05-2006',
            '1',
            '05-04-1999',
            '2',
            'Remaja Gereja',
            'Y',
            '0',
            'Y',
            '081298765432',
            '1',
            '',
        ],
        [
            'Maria Indah',
            '5',
            'Josep',
            'L',
            '11223344',
            '1',
            '3',
            '20-09-1975',
            '2',
            '2',
            '4',
            '2',
            '1',
            '10-07-1980',
            '2',
            '15-10-1995',
            '7',
            'Komisi Anak Gereja',
            'N',
            '1',
            'Y',
            '081312345678',
            '6',
            '15-10-2005',
        ]
        ]);
    }

    public function headings(): array
    {
        return [
            'Kepala Keluarga',
            'Blok (kode)',
            'Nama anggota keluarga',
            'Jenis kelamin (L/P)',
            'Nomor Induk Gereja',
            'Hubungan keluarga (kode)',
            'Status perkawinan (kode)',
            'Tanggal lahir',
            'Golongan darah (kode)',
            'Ijasah terakhir (kode)',
            'Kegiatan/ Pekerjaan (kode)',
            'Pendapatan per bulan (kode)',
            'Tempat baptis anak (kode)',
            'Tanggal baptis anak',
            'Tempat baptis dewasa/ Sidi (kode)',
            'Tanggal baptis dewasa/ Sidi',
            'Talenta/ Hobi (kode)',
            'Aktivitas pelayanan yg aktif diikuti',
            'Memiliki bpjs atau asuransi lainnya (Y/N)',
            'Apakah mempunyai penyakit kronis (kode)',
            'Domisili di alamat ini (Y/N)',
            'Nomor WA',
            'Status (kode)',
            'Tanggal wafat',
        ];
    }

    public function title(): string
    {
        return 'Template Import Anggota Keluarga';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 25,
            'B' => 10,
            'C' => 25,
            'D' => 10,
            'E' => 25,
            'F' => 10,
            'G' => 10,
            'H' => 10,
            'I' => 10,
            'J' => 10,
            'K' => 10,
            'L' => 10,
            'M' => 10,
            'N' => 10,
            'O' => 10,
            'P' => 10,
            'Q' => 10,
            'R' => 25,
            'S' => 10,
            'T' => 10,
            'U' => 10,
            'V' => 25,
            'W' => 10,
            'x' => 25,
        ];
    }
}
