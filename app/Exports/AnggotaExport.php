<?php

namespace App\Exports;

use App\Models\KeluargaAnggota;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class AnggotaExport implements FromCollection, WithHeadings, WithColumnWidths
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = KeluargaAnggota::query();

        // Terapkan semua filter dari komponen Livewire
        if (auth()->user()->role == 'majelis'){
            $query->whereRelation('keluarga', 'blok_id', auth()->user()->blok_id)->get();
        }
        if ($this->filters->searchName) {
            $query->where('name', 'like', '%' . $this->filters->searchName . '%');
        }
        if ($this->filters->searchNIG) {
            $query->where('nomor_induk_gereja', 'like', '%' . $this->filters->searchNIG . '%');
        }

        if ($this->filters->searchHubunganKeluarga) {
            $query->whereIn('hubungan_keluarga_id', $this->filters->searchHubunganKeluarga);
        }
        if ($this->filters->searchPerkawinan) {
            $query->whereIn('perkawinan_id', $this->filters->searchPerkawinan);
        }
        if ($this->filters->searchGolDarah) {
            $query->whereIn('gol_darah_id', $this->filters->searchGolDarah);
        }
        if ($this->filters->searchIjazah) {
            $query->whereIn('ijazah_id', $this->filters->searchIjazah);
        }
        if ($this->filters->searchPekerjaan) {
            $query->whereIn('pekerjaan_id', $this->filters->searchPekerjaan);
        }
        if ($this->filters->searchPendapatan) {
            $query->whereIn('pendapatan_id', $this->filters->searchPendapatan);
        }
        if ($this->filters->searchTempatBabtis) {
            $query->whereIn('tempat_babtis_id', $this->filters->searchTempatBabtis);
        }
        if ($this->filters->searchTempatSidi) {
            $query->whereIn('tempat_sidi_id', $this->filters->searchTempatSidi);
        }
        if ($this->filters->searchHobi) {
            $query->whereIn('hobi_id', $this->filters->searchHobi);
        }
        if ($this->filters->searchPenyakit) {
            $query->whereIn('penyakit_id', $this->filters->searchPenyakit);
        }

        // Filter berdasarkan alamat dan relasi wilayah
        if ($this->filters->searchKeluarga) {
            $query->where(function ($q) {
                $q->orWhereRelation('keluarga', 'name', 'like', '%' . $this->filters->searchKeluarga . '%')
                    ->orWhereHas('keluarga.blok', function ($q2) {
                        $q2->where('name', 'like', '%' . $this->filters->searchKeluarga . '%');
                    });
            });
        }

        // Filter berdasarkan alamat dan relasi wilayah
        if ($this->filters->searchTgl_lahir_awal) {
            $query->where('tgl_lahir', '>=', $this->filters->searchTgl_lahir_awal);
        }
        if ($this->filters->searchTgl_lahir_akhir) {
            $query->where('tgl_lahir', '<=', $this->filters->searchTgl_lahir_akhir);
        }
        if ($this->filters->searchTgl_babtis_awal) {
            $query->where('tgl_babtis', '>=', $this->filters->searchTgl_babtis_awal);
        }
        if ($this->filters->searchTgl_babtis_akhir) {
            $query->where('tgl_babtis', '<=', $this->filters->searchTgl_babtis_akhir);
        }
        if ($this->filters->searchTgl_sidi_awal) {
            $query->where('tgl_sidi', '>=', $this->filters->searchTgl_sidi_awal);
        }
        if ($this->filters->searchTgl_sidi_akhir) {
            $query->where('tgl_sidi', '<=', $this->filters->searchTgl_sidi_akhir);
        }

        // Sorting
        if ($this->filters->sortField1 === 'name') {
            $query->orderBy('name', $this->filters->sortDirection1);
        }

        return $query->get()->map(function ($item) {
            return [
                'Keluarga' => $item->keluarga?->name ?? '-',
                'Blok' => $item->keluarga?->blok?->name ?? '-',
                'Nama anggota keluarga' => $item->name,
                'Jenis kelamin' => ($item->jns_kelamin == 'L') ? 'Laki - laki' : 'Perempuan',
                'Nomor Induk Gereja' => $item->nomor_induk_gereja,
                'Hubungan keluarga' => $item->hubunganKeluarga?->name ?? '-',
                'Status perkawinan' => $item->perkawinan?->name ?? '-',
                'Tanggal lahir' => $item->tgl_lahir,
                'Golongan darah' => $item->golDarah?->name ?? '-',
                'Ijasah terakhir' => $item->ijazah?->name ?? '-',
                'Kegiatan/ Pekerjaan' => $item->pekerjaan?->name ?? '-',
                'RPendapatan per bulan' => $item->pendapatan?->name ?? '-',
                'Tempat baptis anak' => $item->tempatBabtis?->name ?? '-',
                'Tanggal baptis anak' => $item->tgl_babtis,
                'Tempat baptis dewasa/ Sidi' => $item->tempatSidi?->name ?? '-',
                'Tanggal baptis dewasa/ Sidi' => $item->tgl_sidi,
                'Talenta/ Hobi' => $item->hobi?->name ?? '-',
                'Aktivitas pelayanan yg aktif diikuti' => $item->aktifitas_pelayanan,
                'Memiliki bpjs atau asuransi lainnya' => ($item->memiliki_bpjs_asuransi == '1')? 'Ya' : 'Tidak',
                'Apakah mempunyai penyakit kronis' => $item->penyakit?->name ?? '-',
                'Domisili di alamat ini' => ($item->domisili_alamat == '1')? 'Ya' : 'Tidak',
                'Nomor WA' => $item->nomor_wa,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Keluarga',
            'Blok',
            'Nama anggota keluarga',
            'Jenis kelamin',
            'Nomor Induk Gereja',
            'Hubungan keluarga',
            'Status perkawinan',
            'Tanggal lahir',
            'Golongan darah',
            'Ijasah terakhir',
            'Kegiatan/ Pekerjaan',
            'Pendapatan per bulan',
            'Tempat baptis anak',
            'Tanggal baptis anak',
            'Tempat baptis dewasa/ Sidi',
            'Tanggal baptis dewasa/ Sidi',
            'Talenta/ Hobi',
            'Aktivitas pelayanan yg aktif diikuti',
            'Memiliki bpjs atau asuransi lainnya',
            'Apakah mempunyai penyakit kronis',
            'Domisili di alamat ini',
            'Nomor WA',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 25,
            'B' => 25,
            'C' => 10,
            'D' => 10,
            'E' => 10,
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
            'R' => 10,
            'S' => 10,
            'T' => 10,
            'U' => 10,
            'V' => 10,
        ];
    }
}
