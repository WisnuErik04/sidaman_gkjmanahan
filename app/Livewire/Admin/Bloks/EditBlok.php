<?php

namespace App\Livewire\Admin\Bloks;

use App\Models\Blok;
use Livewire\Component;
use Livewire\Attributes\Title;
use Masmerise\Toaster\Toaster;

#[Title('Edit Blok | Sidaman')]
class EditBlok extends Component
{
    public $menuName = 'Blok';
    public $blok_details;
    public $name = '';
   
    public function mount($id){
        $this->blok_details = Blok::find($id);
        
        $this->loadEdit($id);
    }

    public function loadEdit($id){
        $this->fill([
            'name' => $this->blok_details->name,
        ]);
    }

    public function save(){
        $this->validate([
            'name' => 'required|string|max:255'
        ]);

        Blok::find($this->blok_details->id)->update([
            'name' => $this->name
        ]);

        $this->reset();

        Toaster::success('Blok updated successfully!');

        // return redirect()->route('blok.index');
        return redirect()->to(route('blok.index'));
        // return redirect('/blok-list');
    }

    public function render()
    {

        return view('livewire.admin.bloks.edit-blok');
        // return view('livewire.admin.bloks.edit-blok', compact('bloks', 'jarakRumahs', 'kabupatenKotas', 'kecamatans', 'desaKelurahans'));
    }
}
