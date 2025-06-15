<?php

namespace App\Livewire\Admin\TempatBabtises;

use Livewire\Component;
use App\Models\TempatBabtis;
use Livewire\Attributes\Title;
use Masmerise\Toaster\Toaster;


#[Title('Edit Tempat Babtis | Sidaman')]
class EditTempatBabtis extends Component
{
    public $menuName = 'Tempat Babtis';
    public $tempat_babtis_details;
    public $name = '';
   
    public function mount($id){
        $this->tempat_babtis_details = TempatBabtis::find($id);
        
        $this->loadEdit($id);
    }

    public function loadEdit($id){
        $this->fill([
            'name' => $this->tempat_babtis_details->name,
        ]);
    }

    public function save(){
        $this->validate([
            'name' => 'required|string|max:255'
        ]);

        TempatBabtis::find($this->tempat_babtis_details->id)->update([
            'name' => $this->name
        ]);

        $this->reset();

        Toaster::success('Tempat Babtis updated successfully!');

        return redirect()->to(route('tempat_babtis.index'));
    }

    public function render()
    {

        return view('livewire.admin.tempat-babtises.edit-tempat-babtis');
    }
}