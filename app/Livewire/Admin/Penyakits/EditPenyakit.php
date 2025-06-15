<?php

namespace App\Livewire\Admin\Penyakits;

use Livewire\Component;
use App\Models\Penyakit;
use Livewire\Attributes\Title;
use Masmerise\Toaster\Toaster;


#[Title('Edit Penyakit | Sidaman')]
class EditPenyakit extends Component
{
    public $menuName = 'Penyakit';
    public $penyakit_details;
    public $name = '';
   
    public function mount($id){
        $this->penyakit_details = Penyakit::find($id);
        
        $this->loadEdit($id);
    }

    public function loadEdit($id){
        $this->fill([
            'name' => $this->penyakit_details->name,
        ]);
    }

    public function save(){
        $this->validate([
            'name' => 'required|string|max:255'
        ]);

        Penyakit::find($this->penyakit_details->id)->update([
            'name' => $this->name
        ]);

        $this->reset();

        Toaster::success('Penyakit updated successfully!');

        return redirect()->to(route('penyakit.index'));
    }

    public function render()
    {

        return view('livewire.admin.penyakits.edit-penyakit');
    }
}
