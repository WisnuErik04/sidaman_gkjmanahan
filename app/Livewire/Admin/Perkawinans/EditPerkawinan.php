<?php

namespace App\Livewire\Admin\Perkawinans;

use Livewire\Component;
use App\Models\Perkawinan;
use Livewire\Attributes\Title;
use Masmerise\Toaster\Toaster;


#[Title('Edit Perkawinan | Sidaman')]
class EditPerkawinan extends Component
{
    public $menuName = 'Perkawinan';
    public $Perkawinan_details;
    public $name = '';
   
    public function mount($id){
        $this->Perkawinan_details = Perkawinan::find($id);
        
        $this->loadEdit($id);
    }

    public function loadEdit($id){
        $this->fill([
            'name' => $this->Perkawinan_details->name,
        ]);
    }

    public function save(){
        $this->validate([
            'name' => 'required|string|max:255'
        ]);

        Perkawinan::find($this->Perkawinan_details->id)->update([
            'name' => $this->name
        ]);

        $this->reset();

        Toaster::success('Perkawinan updated successfully!');

        return redirect()->to(route('Perkawinan.index'));
    }

    public function render()
    {

        return view('livewire.admin.Perkawinans.edit-Perkawinan');
    }
}
