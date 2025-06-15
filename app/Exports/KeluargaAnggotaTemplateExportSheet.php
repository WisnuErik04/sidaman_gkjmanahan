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
            '1980-01-15',              // Tanggal lahir
            'O',                        // Golongan darah (kode)
            '8',                       // Ijasah terakhir (kode)
            '6',                      // Kegiatan/ Pekerjaan (kode)
            '5000000',                 // Pendapatan per bulan (kode)
            '1',                        // Tempat baptis anak (kode)
            '1985-06-01',              // Tanggal baptis anak
            '2',                        // Tempat baptis dewasa/ Sidi (kode)
            '2000-08-20',              // Tanggal baptis dewasa/ Sidi
            '5',                    // Talenta/ Hobi (kode)
            'Paduan Suara',             // Aktivitas pelayanan yg aktif diikuti
            'Y',                        // Memiliki bpjs atau asuransi lainnya (kode)
            '0',                        // Apakah mempunyai penyakit kronis (kode)
            'Y',                        // Domisili di alamat ini (kode)
            '081234567890',            // Nomor WA
        ],
        [
            'Yohanes Adi',
            '1',
            'Alex',
            'L',
            '87654321',
            '2',
            '1',
            '2005-04-12',
            '3',
            '7',
            '3',
            '2',
            '1',
            '2006-05-01',
            '1',
            '1999-04-05',
            '2',
            'Remaja Gereja',
            'Y',
            '0',
            'Y',
            '081298765432',
        ],
        [
            'Maria Indah',
            '5',
            'Josep',
            'L',
            '11223344',
            '1',
            '3',
            '1975-09-20',
            '2',
            '2',
            '4',
            '2',
            '1',
            '1980-07-10',
            '2',
            '1995-10-15',
            '7',
            'Komisi Anak Gereja',
            'N',
            '1',
            'Y',
            '081312345678',
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
        ];
    }
}
