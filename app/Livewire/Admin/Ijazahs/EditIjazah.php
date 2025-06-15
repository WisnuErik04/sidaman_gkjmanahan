<?php

namespace App\Livewire\Admin\Ijazahs;

use App\Models\Ijazah;
use Livewire\Component;
use Livewire\Attributes\Title;
use Masmerise\Toaster\Toaster;

#[Title('Edit Ijazah | Sidaman')]
class EditIjazah extends Component
{
    public $menuName = 'Ijazah';
    public $ijazah_details;
    public $name = '';
   
    public function mount($id){
        $this->ijazah_details = Ijazah::find($id);
        
        $this->loadEdit($id);
    }

    public function loadEdit($id){
        $this->fill([
            'name' => $this->ijazah_details->name,
        ]);
    }

    public function save(){
        $this->validate([
            'name' => 'required|string|max:255'
        ]);

        Ijazah::find($this->ijazah_details->id)->update([
            'name' => $this->name
        ]);

        $this->reset();

        Toaster::success('Ijazah updated successfully!');

        return redirect()->to(route('ijazah.index'));
    }

    public function render()
    {

        return view('livewire.admin.ijazahs.edit-ijazah');
    }
}
