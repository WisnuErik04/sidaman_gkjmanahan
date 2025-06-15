<?php

namespace App\Livewire\Admin\HubunganKeluargas;

use Livewire\Component;
use Livewire\Attributes\Title;
use Masmerise\Toaster\Toaster;
use App\Models\HubunganKeluarga;

#[Title('Edit Hubungan Keluarga | Sidaman')]
class EditHubunganKeluarga extends Component
{
    public $menuName = 'Hubungan Keluarga';
    public $hubungan_keluarga_details;
    public $name = '';
   
    public function mount($id){
        $this->hubungan_keluarga_details = HubunganKeluarga::find($id);
        
        $this->loadEdit($id);
    }

    public function loadEdit($id){
        $this->fill([
            'name' => $this->hubungan_keluarga_details->name,
        ]);
    }

    public function save(){
        $this->validate([
            'name' => 'required|string|max:255'
        ]);

        HubunganKeluarga::find($this->hubungan_keluarga_details->id)->update([
            'name' => $this->name
        ]);

        $this->reset();

        Toaster::success('Hubungan Keluarga updated successfully!');

        return redirect()->to(route('hubungan_keluarga.index'));
    }

    public function render()
    {

        return view('livewire.admin.hubungan-keluargas.edit-hubungan-keluarga');
    }
}