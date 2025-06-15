<?php

namespace App\Livewire\Admin\ModalAnggotas;

use Flux\Flux;
use Livewire\Component;
use App\Models\Keluarga;
use Livewire\Attributes\On;
use Masmerise\Toaster\Toaster;
use App\Models\KeluargaAnggota;

class WafatAnggota extends Component
{
    public $menuName = 'Anggota';
    public $anggota_details, $keluarga_id, $anggota_id;

    public $is_wafat, $tgl_wafat;


    #[On('livewire.admin.modal-anggotas.wafat-anggota')] 
    public function editAnggota2($anggota_id, $keluarga_id)
    {
        $this->keluarga_id = $keluarga_id;
        $this->loadEdit($anggota_id);
        Flux::modal('wafat-anggota')->show();
    }
    
    public function loadEdit($anggota_id){
        $this->anggota_details = KeluargaAnggota::find($anggota_id);
        $this->fill([
            'tgl_wafat' => $this->anggota_details->tgl_wafat,
        ]);
    }

    public function saveAnggota()
    {
        $this->validate([
            'tgl_wafat' => 'required|date',
        ]);

        KeluargaAnggota::find($this->anggota_details->id)->update([
            'is_wafat' => '1',
            'tgl_wafat' => $this->tgl_wafat,
        ]);
    
        $keluarga_id = $this->keluarga_id;
        $this->reset();
        Toaster::success('Anggota Keluarga updated successfully!');
        $this->redirectRoute('keluarga.edit', ['id' => $keluarga_id], navigate: true);
        Flux::modal('wafat-anggota')->close();
    }
    
    public function render()
    {
        $this->dispatch('reinit-hsselect'); // 🔥 Dispatch event ke JS
        return view('livewire.admin.modal-anggotas.wafat-anggota');
    }
}
