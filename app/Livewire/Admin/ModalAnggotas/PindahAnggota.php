<?php

namespace App\Livewire\Admin\ModalAnggotas;

use Flux\Flux;
use Livewire\Component;
use App\Models\Keluarga;
use Livewire\Attributes\On;
use Masmerise\Toaster\Toaster;
use App\Models\KeluargaAnggota;

class PindahAnggota extends Component
{
    public $menuName = 'Anggota';
    public $keluarga_id;
    public $keluarga_id_now;

    public $anggota_details;
    public $keluargas = [];


    #[On('livewire.admin.modal-anggotas.pindah-anggota')] 
    public function editAnggota2($anggota_id, $keluarga_id)
    {
        // dd($anggota_id .' - '. $keluarga_id);
        $this->keluarga_id_now = $keluarga_id;
        $this->keluarga_id = $keluarga_id;
        $this->loadEdit($anggota_id);
        Flux::modal('pindah-anggota')->show();
    }

    public function mount()
    {
        $this->keluargas = Keluarga::all();
        // $this->keluargas = Keluarga::limit(5)->get();
    }
    
    public function loadEdit($anggota_id){
        $this->anggota_details = KeluargaAnggota::find($anggota_id);
        $this->fill([
            'keluarga_id' => $this->anggota_details->keluarga_id,
        ]);
    }

    public function saveAnggota()
    {
        $this->validate([
            'keluarga_id' => 'required',
        ]);

     
            KeluargaAnggota::find($this->anggota_details->id)->update([
                'keluarga_id' => $this->keluarga_id,
            ]);
       
        $keluarga_id = $this->keluarga_id_now;
        $this->reset();
        Toaster::success('Anggota Keluarga updated successfully!');
        $this->redirectRoute('keluarga.edit', ['id' => $keluarga_id], navigate: true);
        Flux::modal('pindah-anggota')->close();
    }
    
    public function render()
    {
        $this->dispatch('reinit-hsselect'); // 🔥 Dispatch event ke JS
        return view('livewire.admin.modal-anggotas.pindah-anggota');
    }
}
