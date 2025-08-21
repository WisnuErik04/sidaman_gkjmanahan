<?php

namespace App\Exports;

use App\Models\Jemaat;
use App\Models\Keluarga;
use App\Models\KeluargaAnggota;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class JemaatExport implements FromCollection, WithHeadings, WithColumnWidths
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
        $query = Keluarga::query();
        // $query = KeluargaAnggota::query();

        // Terapkan semua filter dari komponen Livewire
        if (auth()->user()->role == 'majelis') {
            $query->where('blok_id', auth()->user()->blok_id);
        }
        if ($this->filters->searchName) {
            $query->where('keluargas.name', 'like', '%' . $this->filters->searchName . '%');
        }

        if ($this->filters->searchAlamat) {
            $query->where('alamat_detail', 'like', '%' . $this->filters->searchAlamat . '%');
        }

        if ($this->filters->searchAlamatRt) {
            $query->where('alamat_rt', 'like', '%' . $this->filters->searchAlamatRt . '%');
        }

        if ($this->filters->searchAlamatRw) {
            $query->where('alamat_rw', 'like', '%' . $this->filters->searchAlamatRw . '%');
        }

        if ($this->filters->searchDesaKelurahan) {
            $query->where('alamat_desa_kelurahan', 'like', '%' . $this->filters->searchDesaKelurahan . '%');
        }

        if ($this->filters->searchKecamatan) {
            $query->where('alamat_kecamatan', 'like', '%' . $this->filters->searchKecamatan . '%');
        }

        if ($this->filters->searchKabKota) {
            $query->where('alamat_kab_kota', 'like', '%' . $this->filters->searchKabKota . '%');
        }

        if ($this->filters->searchProvinsi) {
            $query->where('alamat_provinsi', 'like', '%' . $this->filters->searchProvinsi . '%');
        }

        if ($this->filters->searchBlok) {
            $query->whereIn('blok_id', $this->filters->searchBlok);
        }

        if ($this->filters->searchJarak) {
            $query->whereIn('jarak_rumah_id', $this->filters->searchJarak);
        }

        // Sorting
        $query->join('bloks', 'keluargas.blok_id', '=', 'bloks.id')
            ->orderBy('bloks.name', 'asc')
            ->select('keluargas.*');
        $query->orderBy('name', 'asc');
        // if ($this->filters->sortField1 === 'blok') {
        //     $query->join('bloks', 'keluargas.blok_id', '=', 'bloks.id')
        //         ->orderBy('bloks.name', $this->filters->sortDirection1)
        //         ->select('keluargas.*');
        // }
        // if ($this->filters->sortField2 === 'name') {
        //     $query->orderBy('name', $this->filters->sortDirection2);
        // }

        // $keluargaIds = $query->pluck('id');
        $keluargaIds = $query->pluck('id')->toArray();
        // Ambil data anggota jemaat berdasarkan keluarga_id
        $anggota = KeluargaAnggota::whereIn('keluarga_id', $keluargaIds)
            ->orderByRaw('FIELD(keluarga_id, ' . implode(',', $keluargaIds) . ')')
            ->orderBy('hubungan_keluarga_id', 'asc')
            ->get();

// $query = KeluargaAnggota::whereIn('keluarga_id', $keluargaIds)
//     // ->orderByRaw('FIELD(keluarga_id, ' . implode(',', $keluargaIds) . ')')
//     ->orderBy('hubungan_keluarga_id', 'asc');

// // Lihat query mentah
// dd($query->toSql(), $query->getBindings());

        // return $query->get()->map(function ($item) {
        //     return [
        //         'Blok / Pepanthan' => $item->blok?->name ?? '-',
        //         'Nama Kepala Keluarga' => $item->name,
        //         'Alamat Lengkap' => $item->alamat_detail,
        //         'RT' => $item->alamat_rt,
        //         'RW' => $item->alamat_rw,
        //         'Desa / Kelurahan' => $item->desaKelurahan?->name ?? '-',
        //         'Kecamatan' => $item->kecamatan?->name ?? '-',
        //         'Kabupaten / Kota' => $item->kabKota?->name ?? '-',
        //         'Provinsi' => $item->provinsi?->name ?? '-',
        //         // 'Alamat Lengkap' => $item->alamat_detail.", RT ".$item->alamat_rt."/ RW ".$item->alamat_rw.", ".
        //         // $item->desaKelurahan?->name.", ".$item->kecamatan?->name.", ".$item->kabKota?->name.", ".$item->provinsi?->name,
        //         'Jarak Dari Rumah Ke Tempat Ibadah' => $item->jarakRumah?->name ?? '-',
        //     ];
        // });

        // return $anggota->get()->map(function ($item) {
        return $anggota->map(function ($item) {
            return [
                'Blok / Pepanthan' => $item->keluarga?->blok?->name ?? '-',
                'Nama Kepala Keluarga' => $item->keluarga?->name,
                'Alamat Lengkap' => $item->keluarga?->alamat_detail,
                'RT' => $item->keluarga?->alamat_rt,
                'RW' => $item->keluarga?->alamat_rw,
                'Desa / Kelurahan' => $item->keluarga?->desaKelurahan?->name ?? '-',
                'Kecamatan' => $item->keluarga?->kecamatan?->name ?? '-',
                'Kabupaten / Kota' => $item->keluarga?->kabKota?->name ?? '-',
                'Provinsi' => $item->keluarga?->provinsi?->name ?? '-',
                // 'Alamat Lengkap' => $item->keluarga?->alamat_detail.", RT ".$item->keluarga?->alamat_rt."/ RW ".$item->keluarga?->alamat_rw.", ".
                // $item->keluarga?->desaKelurahan?->name.", ".$item->keluarga?->kecamatan?->name.", ".$item->keluarga?->kabKota?->name.", ".$item->keluarga?->provinsi?->name,
                'Jarak Dari Rumah Ke Tempat Ibadah' => $item->keluarga?->jarakRumah?->name ?? '-',
                // 'Keluarga' => $item->keluarga?->name ?? '-',
                // 'Blok' => $item->keluarga?->blok?->name ?? '-',
                
                'Nama anggota keluarga' => $item->name,
                'Jenis kelamin' => ($item->jns_kelamin == 'L') ? 'Laki - laki' : 'Perempuan',
                'Nomor Induk Gereja' => $item->nomor_induk_gereja,
                'Hubungan keluarga' => $item->hubunganKeluarga?->name ?? '-',
                'Status perkawinan' => $item->perkawinan?->name ?? '-',
                // 'Tanggal lahir' => $item->tgl_lahir,
                'Tanggal lahir' => \Carbon\Carbon::parse($item->tgl_lahir)->format('d-m-Y'),
                'Golongan darah' => $item->golDarah?->name ?? '-',
                'Ijasah terakhir' => $item->ijazah?->name ?? '-',
                'Kegiatan/ Pekerjaan' => $item->pekerjaan?->name ?? '-',
                'RPendapatan per bulan' => $item->pendapatan?->name ?? '-',
                'Tempat baptis anak' => $item->tempatBabtis?->name ?? '-',
                // 'Tanggal baptis anak' => $item->tgl_babtis,
                'Tanggal baptis anak' => \Carbon\Carbon::parse($item->tgl_babtis)->format('d-m-Y'),
                'Tempat baptis dewasa/ Sidi' => $item->tempatSidi?->name ?? '-',
                // 'Tanggal baptis dewasa/ Sidi' => $item->tgl_sidi,
                'Tanggal baptis dewasa' => \Carbon\Carbon::parse($item->tgl_sidi)->format('d-m-Y'),
                'Talenta/ Hobi' => $item->hobi?->name ?? '-',
                'Aktivitas pelayanan yg aktif diikuti' => $item->aktifitas_pelayanan,
                'Memiliki bpjs atau asuransi lainnya' => ($item->memiliki_bpjs_asuransi == '1') ? 'Ya' : 'Tidak',
                'Apakah mempunyai penyakit kronis' => $item->penyakit?->name ?? '-',
                'Domisili di alamat ini' => ($item->domisili_alamat == '1') ? 'Ya' : 'Tidak',
                'Nomor WA' => $item->nomor_wa,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Blok / Pepanthan',
            'Nama Kepala Keluarga',
            'Alamat Lengkap',
            'RT',
            'RW',
            'Desa / Kelurahan',
            'Kecamatan',
            'Kabupaten / Kota',
            'Provinsi',
            // 'Alamat Lengkap',
            'Jarak Dari Rumah Ke Tempat Ibadah',

            // 'Keluarga',
            // 'Blok',
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
            'K' => 25,
            'L' => 25,
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
            'W' => 10,
            'X' => 10,
            'Y' => 10,
            'Z' => 10,
            'AA' => 10,
            'AB' => 10,
            'AC' => 10,
            'AD' => 10,
            'AE' => 10,
            'AF' => 10,
        ];
    }
}
