<?php

namespace App\Livewire\Admin\Anggotas;

use App\Models\Blok;
use App\Models\anggota;
use Livewire\Component;
use App\Models\JarakRumah;
use Livewire\WithPagination;
use App\Models\anggotaAnggota;
use Livewire\Attributes\Title;
use Masmerise\Toaster\Toaster;
use App\Models\KeluargaAnggota;
use App\Models\User;
use Carbon\Carbon;

#[Title('Data Anggota Keluarga | Sidaman')]
class AnggotaList extends Component
{

    public ?int $idToDelete = null;

    public function confirmDelete(int $id): void
    {
        $this->idToDelete = $id;
        $this->dispatch('show-delete-modal');
    }

    public function deleteConfirmed(): void
    {
        if ($this->idToDelete) {
            $anggota_details = KeluargaAnggota::find($this->idToDelete);
            if ($anggota_details->user_id) {
                User::findOrFail($anggota_details->user_id)->delete();
            }
            KeluargaAnggota::findOrFail($this->idToDelete)->delete();
            $this->idToDelete = null;
            Toaster::success('Data deleted successfully!');
            $this->dispatch('close-delete-modal');
        }
    }

    use WithPagination;
    public $menuName = "Anggota Keluarga";

    public $bloks = [];
    public $searchName = '';
    public $searchNIG = '';
    public $searchKeluarga = '';
    public $searchTglLahir = '';
    public $searchTgl_lahir_awal = '';
    public $searchTgl_lahir_akhir = '';
    public $searchBlok = '';

    public $perPage = 10;
    public $sortDirection1 = 'asc';    // Default arah sorting
    public $sortField1 = 'name'; // Default kolom sorting

    public function mount()
    {
        Carbon::setLocale('id');
        $this->bloks = Blok::all();
        if (auth()->user()->role == 'majelis') {
            $this->bloks = Blok::where('id', auth()->user()->blok_id)->get();
        }
    }

    public function render()
    {
        $anggotas = $this->loadanggotas();
        return view('livewire.admin.anggotas.anggota-list', compact('anggotas'));
        // return view('livewire.teacher.anggotas.anggota-list',[
        //     'anggotas' => KeluargaAnggota::all()
        // ]);
    }

    public function loadanggotas()
    {
        $query = KeluargaAnggota::query();

        // Filter nama anggota
        if (auth()->user()->role == 'majelis') {
            $query->whereRelation('keluarga', 'blok_id', auth()->user()->blok_id)->get();
        }
        if ($this->searchName) {
            $query->where('name', 'like', '%' . $this->searchName . '%');
        }
        if ($this->searchNIG) {
            $query->where('nomor_induk_gereja', 'like', '%' . $this->searchNIG . '%');
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
        if ($this->searchBlok) {
            $query->whereHas('keluarga.blok', function ($q) {
                $q->whereIn('id', $this->searchBlok);
            });
        }

        // Filter berdasarkan alamat dan relasi wilayah
        if ($this->searchTgl_lahir_awal) {
            $query->where('tgl_lahir', '>=', $this->searchTgl_lahir_awal);
        }

        if ($this->searchTgl_lahir_akhir) {
            $query->where('tgl_lahir', '<=', $this->searchTgl_lahir_akhir);
        }

        // Sorting
        if ($this->sortField1 === 'name') {
            $query->orderBy('name', $this->sortDirection1);
        }
        $this->dispatch('reinit-hsselect'); // 🔥 Dispatch event ke JS

        // Pagination
        return $query->paginate($this->perPage);
    }


    // Filtering
    public function searchTgl_lahir_awal()
    {
        $this->resetPage();
    }
    public function searchTgl_lahir_akhir()
    {
        $this->resetPage();
    }
    public function updatingSearchName()
    {
        $this->resetPage();
    }
    public function updatingSearchKeluarga()
    {
        $this->resetPage();
    }
    public function searchNIG()
    {
        $this->resetPage();
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
