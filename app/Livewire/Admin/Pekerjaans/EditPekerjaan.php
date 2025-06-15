<?php

namespace App\Livewire\Admin\Pekerjaans;

use Livewire\Component;
use App\Models\Pekerjaan;
use Livewire\Attributes\Title;
use Masmerise\Toaster\Toaster;

#[Title('Edit Pekerjaan | Sidaman')]
class EditPekerjaan extends Component
{
    public $menuName = 'Pekerjaan';
    public $pekerjaan_details;
    public $name = '';
   
    public function mount($id){
        $this->pekerjaan_details = Pekerjaan::find($id);
        
        $this->loadEdit($id);
    }

    public function loadEdit($id){
        $this->fill([
            'name' => $this->pekerjaan_details->name,
        ]);
    }

    public function save(){
        $this->validate([
            'name' => 'required|string|max:255'
        ]);

        Pekerjaan::find($this->pekerjaan_details->id)->update([
            'name' => $this->name
        ]);

        $this->reset();

        Toaster::success('Pekerjaan updated successfully!');

        return redirect()->to(route('pekerjaan.index'));
    }

    public function render()
    {

        return view('livewire.admin.pekerjaans.edit-pekerjaan');
    }
}
