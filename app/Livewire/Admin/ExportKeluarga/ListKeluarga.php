<?php

namespace App\Livewire\Admin\ExportKeluarga;

use Flux\Flux;
use App\Models\Blok;
use App\Models\Wilayah;
use Livewire\Component;
use App\Models\Keluarga;
use App\Models\JarakRumah;
use Livewire\WithPagination;
use App\Exports\JemaatExport;
use Livewire\Attributes\Title;
use App\Models\KeluargaAnggota;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

#[Title('Data Keluarga | Sidaman')]
class ListKeluarga extends Component
{
    use WithPagination;
    public $menuName = "Keluarga";

    public $searchBlok = '';
    public $searchName = '';
    public $searchAlamat = '';
    public $searchAlamatRt = '';
    public $searchAlamatRw = '';
    public $searchDesaKelurahan = '';
    public $searchKecamatan = '';
    public $searchKabKota = '';
    public $searchProvinsi = '';
    public $searchJarak = '';

    public $provinsis = [];
    public $bloks = [];
    public $jarakRumahs = [];

    public $perPage = 10;
    public $sortDirection1 = 'asc';    // Default arah sorting
    public $sortDirection2 = 'asc';    // Default arah sorting
    public $sortField1 = 'blok'; // Default kolom sorting
    public $sortField2 = 'name'; // Default kolom sorting

    public function mount()
    {
        $this->provinsis = Wilayah::whereRaw('CHAR_LENGTH(kode) = 2')->orderBy('name', 'ASC')->get();
        $this->bloks = Blok::all();
        if (auth()->user()->role == 'majelis'){
            $this->bloks = Blok::where('id', auth()->user()->blok_id)->get();
        }
        $this->jarakRumahs = JarakRumah::all();
    }

    public function render()
    {
        $keluargas = $this->loadKeluargas();
        $kabupatenKotas = $this->searchProvinsi
            ? Wilayah::whereRaw('CHAR_LENGTH(kode) = 5')->where('kode', 'like', $this->searchProvinsi . '.%')->orderBy('name', 'ASC')->get()
            : collect();
        $kecamatans = $this->searchKabKota
            ? Wilayah::whereRaw('CHAR_LENGTH(kode) = 8')->where('kode', 'like', $this->searchKabKota . '.%')->orderBy('name', 'ASC')->get()
            : collect();
        $desaKelurahans = $this->searchKecamatan
            ? Wilayah::whereRaw('CHAR_LENGTH(kode) = 13')->where('kode', 'like', $this->searchKecamatan . '.%')->orderBy('name', 'ASC')->get()
            : collect();
        return view('livewire.admin.export-keluarga.list-keluarga', compact('keluargas', 'kabupatenKotas', 'kecamatans', 'desaKelurahans'));
    }

    public function loadKeluargas()
    {
        $query = Keluarga::query();

        // Filter nama keluarga
        if (auth()->user()->role == 'majelis'){
            $query->where('blok_id', auth()->user()->blok_id);
        }
        if ($this->searchName) {
            $query->where('keluargas.name', 'like', '%' . $this->searchName . '%');
        }

        // Filter berdasarkan alamat dan relasi wilayah
        if ($this->searchAlamat) {
            $query->where('alamat_detail', 'like', '%' . $this->searchAlamatRt . '%');
        }
        if ($this->searchAlamatRt) {
            $query->where('alamat_rt', 'like', '%' . $this->searchAlamatRt . '%');
        }
        if ($this->searchAlamatRw) {
            $query->where('alamat_rw', 'like', '%' . $this->searchAlamatRw . '%');
        }
        if ($this->searchDesaKelurahan) {
            $query->where('alamat_desa_kelurahan', 'like', '%' . $this->searchDesaKelurahan . '%');
        }
        if ($this->searchKecamatan) {
            $query->where('alamat_kecamatan', 'like', '%' . $this->searchKecamatan . '%');
        }
        if ($this->searchKabKota) {
            $query->where('alamat_kab_kota', 'like', '%' . $this->searchKabKota . '%');
        }
        if ($this->searchProvinsi) {
            $query->where('alamat_provinsi', 'like', '%' . $this->searchProvinsi . '%');
        }

        // Filter berdasarkan alamat dan relasi wilayah
        if ($this->searchBlok) {
            $query->whereIn('blok_id', $this->searchBlok);
        }
        if ($this->searchJarak) {
            $query->whereIn('jarak_rumah_id', $this->searchJarak);
        }

        // Sorting
        if ($this->sortField1 === 'blok') {
            $query->join('bloks', 'keluargas.blok_id', '=', 'bloks.id')
                ->orderBy('bloks.name', $this->sortDirection1)
                ->select('keluargas.*');
        }
        if ($this->sortField2 === 'name') {
            $query->orderBy('name', $this->sortDirection2);
        }

        // Trigger frontend reactivity
        $this->dispatch('reinit-hsselect');

        // Pagination
        return $query->paginate($this->perPage);
    }

    public function resetFilter()
    {
        $this->reset();
        $this->resetPage();
    }

    public function cariFilter()
    {
        $this->resetPage();
        // $this->render();
        // Flux::modal('filter')->close();
    }

    public function export(): BinaryFileResponse
    {
        return Excel::download(
            new JemaatExport($this),
            'data-keluarga.xlsx'
        );
    
    }

    public function exportPDF($id)
    {
        $this->redirect(route('export_keluarga_anggota_pdf.index', $id));
    }

    public function updatedSearchProvinsi()
    {
        $this->searchKabKota = $this->searchKecamatan = $this->searchDesaKelurahan = '';
    }

    public function updatedSearchKabKota()
    {
        $this->searchKecamatan = $this->searchDesaKelurahan = '';
    }

    public function updatedSearchKecamatan()
    {
        $this->searchDesaKelurahan = '';
    }


    public function updatedSearchAlamatRt($value)
    {
        // Hanya angka
        $numeric = preg_replace('/\D/', '', $value);
        $realNumber = substr(ltrim($numeric, '0'), 0);
        // Pad jadi 3 digit
        $this->searchAlamatRt =  str_pad(substr($realNumber, 0, 3), 3, '0', STR_PAD_LEFT);
    }

    public function updatedSearchAlamatRw($value)
    {
        // Hanya angka
        $numeric = preg_replace('/\D/', '', $value);
        $realNumber = substr(ltrim($numeric, '0'), 0);
        // Pad jadi 3 digit
        $this->searchAlamatRw =  str_pad(substr($realNumber, 0, 3), 3, '0', STR_PAD_LEFT);
    }

    // Pagination
    public function setPerPage($number)
    {
        $this->perPage = $number;
        $this->resetPage();
    }
    public function sortBy($field)
    {
        if ($this->sortField1 === $field) {
            // Kalau klik field yang sama, toggle arah
            $this->sortDirection1 = $this->sortDirection1 === 'asc' ? 'desc' : 'asc';
        } else if ($this->sortField2 === $field) {
            // Kalau klik field yang sama, toggle arah
            $this->sortDirection2 = $this->sortDirection2 === 'asc' ? 'desc' : 'asc';
        } else {
            // Kalau klik field baru, set field dan arah default asc
            $this->sortField1 = $field;
            $this->sortDirection1 = 'asc';
            $this->sortField2 = $field;
            $this->sortDirection2 = 'asc';
        }

        $this->resetPage(); // reset ke halaman 1 biar hasilnya benar
    }
    public function paginationView()
    {
        return 'vendor.livewire.custom';
    }
}
