<?php

namespace App\Livewire\Admin\GolDarahs;

use Livewire\Component;
use App\Models\GolDarah;
use Livewire\Attributes\Title;
use Masmerise\Toaster\Toaster;

#[Title('Edit Golongan Darah | Sidaman')]
class EditGolDarah extends Component
{
    public $menuName = 'Golongan Darah';
    public $gol_darah_details;
    public $name = '';
   
    public function mount($id){
        $this->gol_darah_details = GolDarah::find($id);
        
        $this->loadEdit($id);
    }

    public function loadEdit($id){
        $this->fill([
            'name' => $this->gol_darah_details->name,
        ]);
    }

    public function save(){
        $this->validate([
            'name' => 'required|string|max:255'
        ]);

        GolDarah::find($this->gol_darah_details->id)->update([
            'name' => $this->name
        ]);

        $this->reset();

        Toaster::success('Golongan Darah updated successfully!');

        // return redirect()->route('gol_darah.index');
        return redirect()->to(route('gol_darah.index'));
        // return redirect('/gol_darah-list');
    }

    public function render()
    {

        return view('livewire.admin.gol-darahs.edit-gol-darah');
    }
}
