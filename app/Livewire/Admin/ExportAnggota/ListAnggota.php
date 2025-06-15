<?php

namespace App\Livewire\Admin\ExportAnggota;

use Flux\Flux;
use App\Models\Hobi;
use App\Models\Ijazah;
use Livewire\Component;
use App\Models\GolDarah;
use App\Models\Penyakit;
use App\Models\Pekerjaan;
use App\Models\Pendapatan;
use App\Models\Perkawinan;
use App\Models\TempatSidi;
use App\Models\TempatBabtis;
use Livewire\WithPagination;
use App\Exports\JemaatExport;
use App\Exports\AnggotaExport;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Title;
use App\Models\KeluargaAnggota;
use App\Models\HubunganKeluarga;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

#[Title('Data Anggota | Sidaman')]
class ListAnggota extends Component
{
    use WithPagination;
    public $menuName = "Anggota";

    public $searchName = '';
    public $searchNIG = '';
    public $searchKeluarga = '';
    public $searchTglLahir = '';
    public $searchTgl_lahir_awal = '';
    public $searchTgl_lahir_akhir = '';
    public $searchHubunganKeluarga = '';
    public $searchPerkawinan = '';
    public $searchGolDarah = '';
    public $searchIjazah = '';
    public $searchPekerjaan = '';
    public $searchPendapatan = '';
    public $searchTempatBabtis = '';
    public $searchTempatSidi = '';
    public $searchHobi = '';
    public $searchPenyakit = '';
    public $searchTgl_babtis_awal = '';
    public $searchTgl_babtis_akhir = '';
    public $searchTgl_sidi_awal = '';
    public $searchTgl_sidi_akhir = '';
    
    public $hubunganKeluargas;
    public $perkawinans;
    public $golDarahs;
    public $ijazahs;
    public $pekerjaans;
    public $pendapatans;
    public $tempatBabtises;
    public $tempatSidis;
    public $hobis;
    public $penyakits;

    public $perPage = 10;
    public $sortDirection1 = 'asc';    // Default arah sorting
    public $sortField1 = 'name'; // Default kolom sorting

    public function mount()
    {
        Carbon::setLocale('id');
        $this->hubunganKeluargas = HubunganKeluarga::all();
        $this->perkawinans = Perkawinan::all();
        $this->golDarahs = GolDarah::all();
        $this->ijazahs = Ijazah::all();
        $this->pekerjaans = Pekerjaan::all();
        $this->pendapatans = Pendapatan::all();
        $this->tempatBabtises = TempatBabtis::all();
        $this->tempatSidis = TempatSidi::all();
        $this->hobis = Hobi::all();
        $this->penyakits = Penyakit::all();
    }

    public function render()
    {
        $anggotas = $this->loadanggotas();
        return view('livewire.admin.export-anggota.list-anggota', compact('anggotas'));
    }

    public function loadAnggotas()
    {
        $query = KeluargaAnggota::query();

      // Filter nama anggota
        if (auth()->user()->role == 'majelis'){
            $query->whereRelation('keluarga', 'blok_id', auth()->user()->blok_id)->get();
        }
        if ($this->searchName) {
            $query->where('name', 'like', '%' . $this->searchName . '%');
        }
        if ($this->searchNIG) {
            $query->where('nomor_induk_gereja', 'like', '%' . $this->searchNIG . '%');
        }
        
        if ($this->searchHubunganKeluarga) {
            $query->whereIn('hubungan_keluarga_id', $this->searchHubunganKeluarga);
        }
        if ($this->searchPerkawinan) {
            $query->whereIn('perkawinan_id', $this->searchPerkawinan);
        }
        if ($this->searchGolDarah) {
            $query->whereIn('gol_darah_id', $this->searchGolDarah);
        }
        if ($this->searchIjazah) {
            $query->whereIn('ijazah_id', $this->searchIjazah);
        }
        if ($this->searchPekerjaan) {
            $query->whereIn('pekerjaan_id', $this->searchPekerjaan);
        }
        if ($this->searchPendapatan) {
            $query->whereIn('pendapatan_id', $this->searchPendapatan);
        }
        if ($this->searchTempatBabtis) {
            $query->whereIn('tempat_babtis_id', $this->searchTempatBabtis);
        }
        if ($this->searchTempatSidi) {
            $query->whereIn('tempat_sidi_id', $this->searchTempatSidi);
        }
        if ($this->searchHobi) {
            $query->whereIn('hobi_id', $this->searchHobi);
        }
        if ($this->searchPenyakit) {
            $query->whereIn('penyakit_id', $this->searchPenyakit);
        }
    
        // Filter berdasarkan alamat dan relasi wilayah
        if ($this->searchKeluarga) {
            $query->where(function ($q) {
                $q->orWhereRelation('keluarga', 'name', 'like', '%' . $this->searchKeluarga . '%')
                    ->orWhereHas('keluarga.blok', function ($q2) {
                        $q2->where('name', 'like', '%' . $this->searchKeluarga . '%');
                    });
            });
        }

        // Filter berdasarkan alamat dan relasi wilayah
        if ($this->searchTgl_lahir_awal) {
            $query->where('tgl_lahir','>=' , $this->searchTgl_lahir_awal);
        }
        if ($this->searchTgl_lahir_akhir) {
            $query->where('tgl_lahir','<=' , $this->searchTgl_lahir_akhir);
        }
        if ($this->searchTgl_babtis_awal) {
            $query->where('tgl_babtis','>=' , $this->searchTgl_babtis_awal);
        }
        if ($this->searchTgl_babtis_akhir) {
            $query->where('tgl_babtis','<=' , $this->searchTgl_babtis_akhir);
        }
        if ($this->searchTgl_sidi_awal) {
            $query->where('tgl_sidi','>=' , $this->searchTgl_sidi_awal);
        }
        if ($this->searchTgl_sidi_akhir) {
            $query->where('tgl_sidi','<=' , $this->searchTgl_sidi_akhir);
        }
      
        // Sorting
        if ($this->sortField1 === 'name') {
            $query->orderBy('name', $this->sortDirection1);
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
            new AnggotaExport($this),
            'data-anggota.xlsx'
        );
    
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
        } else {
            // Kalau klik field baru, set field dan arah default asc
            $this->sortField1 = $field;
            $this->sortDirection1 = 'asc';
        }

        $this->resetPage(); // reset ke halaman 1 biar hasilnya benar
    }
    public function paginationView()
    {
        return 'vendor.livewire.custom';
    }
}