<?php

namespace App\Exports;

use App\Models\Jemaat;
use App\Models\Keluarga;
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

        // Terapkan semua filter dari komponen Livewire
        if (auth()->user()->role == 'majelis'){
            $query->where('blok_id', auth()->user()->blok_id);
        }
        if ($this->filters->searchName) {
            $query->where('name', 'like', '%' . $this->filters->searchName . '%');
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
        if ($this->filters->sortField1 === 'blok') {
            $query->join('bloks', 'keluargas.blok_id', '=', 'bloks.id')
                ->orderBy('bloks.name', $this->filters->sortDirection1)
                ->select('keluargas.*');
        }
        if ($this->filters->sortField2 === 'name') {
            $query->orderBy('name', $this->filters->sortDirection2);
        }

        return $query->get()->map(function ($item) {
            return [
                'Blok / Pepanthan' => $item->blok?->name ?? '-',
                'Nama Kepala Keluarga' => $item->name,
                'Alamat Lengkap' => $item->alamat_detail,
                'RT' => $item->alamat_rt,
                'RW' => $item->alamat_rw,
                'Desa / Kelurahan' => $item->desaKelurahan?->name ?? '-',
                'Kecamatan' => $item->kecamatan?->name ?? '-',
                'Kabupaten / Kota' => $item->kabKota?->name ?? '-',
                'Provinsi' => $item->provinsi?->name ?? '-',
                // 'Alamat Lengkap' => $item->alamat_detail.", RT ".$item->alamat_rt."/ RW ".$item->alamat_rw.", ".
                // $item->desaKelurahan?->name.", ".$item->kecamatan?->name.", ".$item->kabKota?->name.", ".$item->provinsi?->name,
                'Jarak Dari Rumah Ke Tempat Ibadah' => $item->jarakRumah?->name ?? '-',
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
        ];
    }
}
