<?php

namespace App\Livewire\Admin\Pendapatans;

use Livewire\Component;
use App\Models\Pendapatan;
use Livewire\Attributes\Title;
use Masmerise\Toaster\Toaster;

#[Title('Edit Pendapatan | Sidaman')]
class EditPendapatan extends Component
{
    public $menuName = 'Pendapatan';
    public $pendapatan_details;
    public $name = '';
   
    public function mount($id){
        $this->pendapatan_details = Pendapatan::find($id);
        
        $this->loadEdit($id);
    }

    public function loadEdit($id){
        $this->fill([
            'name' => $this->pendapatan_details->name,
        ]);
    }

    public function save(){
        $this->validate([
            'name' => 'required|string|max:255'
        ]);

        Pendapatan::find($this->pendapatan_details->id)->update([
            'name' => $this->name
        ]);

        $this->reset();

        Toaster::success('Pendapatan updated successfully!');

        return redirect()->to(route('pendapatan.index'));
    }

    public function render()
    {

        return view('livewire.admin.pendapatans.edit-pendapatan');
    }
}
