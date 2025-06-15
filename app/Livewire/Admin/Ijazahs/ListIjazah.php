<?php

namespace App\Livewire\Admin\Ijazahs;

use App\Models\Ijazah;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Masmerise\Toaster\Toaster;
use Illuminate\Database\QueryException;

#[Title('Data Ijazah | Sidaman')]
class ListIjazah extends Component
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
            try {
                Ijazah::findOrFail($this->idToDelete)->delete();
                Toaster::success('Data deleted successfully!');
            } catch (QueryException $e) {

                if ($e->getCode() == "23000") {
                    Toaster::error('Data ini masih terkait dengan entitas lain. Hapus data terkait terlebih dahulu.');
                }
            }
            $this->idToDelete = null;
            $this->dispatch('close-delete-modal');
        }
    }

    use WithPagination;
    public $menuName = "Ijazah";
    
    // public $ijazahs = [];

    public $searchName = '';
    
    public $perPage = 10;
    public $sortDirection1 = 'asc';    // Default arah sorting
    public $sortField1 = 'name'; // Default kolom sorting


    public function render()
    {
        $ijazahs = $this->loadIjazahs();
        return view('livewire.admin.ijazahs.list-ijazah', compact('ijazahs'));
    }

    public function loadIjazahs()
    {
        $query = Ijazah::query();
    
        // Filter nama ijazah
        if ($this->searchName) {
            $query->where('name', 'like', '%' . $this->searchName . '%');
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
    

    // Filtering
    public function updatingSearchName()
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
