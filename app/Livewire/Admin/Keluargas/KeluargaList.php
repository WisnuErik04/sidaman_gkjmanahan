<?php

namespace App\Livewire\Admin\Keluargas;

use App\Models\Blok;
use App\Models\User;
use Livewire\Component;
use App\Models\Keluarga;
use App\Models\JarakRumah;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Masmerise\Toaster\Toaster;
use App\Models\KeluargaAnggota;

#[Title('Data Keluarga | Sidaman')]
class KeluargaList extends Component
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
            $anggota_details = KeluargaAnggota::where('keluarga_id', $this->idToDelete)->get();
            foreach ($anggota_details as $anggota_detail) {
                if ($anggota_detail->user_id) {
                    User::findOrFail($anggota_detail->user_id)->delete();
                }
            }
            KeluargaAnggota::where('keluarga_id', $this->idToDelete)->delete();
            Keluarga::findOrFail($this->idToDelete)->delete();
            $this->idToDelete = null;
            Toaster::success('Data deleted successfully!');
            $this->dispatch('close-delete-modal');
        }
    }

    // public function delete($id)
    // {
    //     KeluargaAnggota::find('keluarga_id', $id)->delete();
    //     Keluarga::find($id)->delete();
    //     Toaster::success('keluarga deleted successfully!');
    //     return redirect()->route('keluarga.index');
    // }
    
    use WithPagination;
    public $menuName = "Keluarga";
    
    public $bloks = [];
    public $jarakRumahs = [];

    public $searchBlok = '';
    public $searchName = '';
    public $searchAlamat = '';
    public $searchJarak = '';
    
    public $perPage = 10;
    public $sortDirection1 = 'asc';    // Default arah sorting
    public $sortDirection2 = 'asc';    // Default arah sorting
    public $sortField1 = 'blok'; // Default kolom sorting
    public $sortField2 = 'name'; // Default kolom sorting

    public function mount()
    {
        $this->bloks = Blok::all();
        if (auth()->user()->role == 'majelis'){
            $this->bloks = Blok::where('id', auth()->user()->blok_id)->get();
        }
        $this->jarakRumahs = JarakRumah::all();
    }

    public function render()
    {
        $keluargas = $this->loadKeluargas();
        return view('livewire.admin.keluargas.keluarga-list', compact('keluargas'));
        // return view('livewire.teacher.keluargas.keluarga-list',[
        //     'keluargas' => Keluarga::all()
        // ]);
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
            $query->where(function ($q) {
                $q->where('alamat_detail', 'like', '%' . $this->searchAlamat . '%')
                  ->orWhere('alamat_rt', 'like', '%' . $this->searchAlamat . '%')
                  ->orWhere('alamat_rw', 'like', '%' . $this->searchAlamat . '%')
                  ->orWhereRelation('desaKelurahan', 'name', 'like', '%' . $this->searchAlamat . '%')
                  ->orWhereRelation('kecamatan', 'name', 'like', '%' . $this->searchAlamat . '%')
                  ->orWhereRelation('kabKota', 'name', 'like', '%' . $this->searchAlamat . '%')
                  ->orWhereRelation('provinsi', 'name', 'like', '%' . $this->searchAlamat . '%');
            });
        }

        // Filter berdasarkan alamat dan relasi wilayah
        if ($this->searchBlok) {
            $query->whereIn('blok_id', $this->searchBlok);
        }
        if ($this->searchJarak) {
            $query->where('jarak_rumah_id', $this->searchJarak);
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
    

    // Filtering
    public function updatingSearchBlok()
    {
        $this->resetPage();
    }
    public function updatingSearchName()
    {
        $this->resetPage();
    }
    public function updatingSearchAlamat()
    {
        $this->resetPage();
    }
    public function updatingSearchJarak()
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
