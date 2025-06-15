<?php

namespace App\Livewire\Admin\Hobis;

use App\Models\Hobi;
use Livewire\Component;
use Livewire\Attributes\Title;
use Masmerise\Toaster\Toaster;

#[Title('Edit Hobi | Sidaman')]
class EditHobi extends Component
{
    public $menuName = 'Hobi';
    public $hobi_details;
    public $name = '';
   
    public function mount($id){
        $this->hobi_details = Hobi::find($id);
        
        $this->loadEdit($id);
    }

    public function loadEdit($id){
        $this->fill([
            'name' => $this->hobi_details->name,
        ]);
    }

    public function save(){
        $this->validate([
            'name' => 'required|string|max:255'
        ]);

        Hobi::find($this->hobi_details->id)->update([
            'name' => $this->name
        ]);

        $this->reset();

        Toaster::success('Hobi updated successfully!');

        // return redirect()->route('hobi.index');
        return redirect()->to(route('hobi.index'));
        // return redirect('/hobi-list');
    }

    public function render()
    {

        return view('livewire.admin.hobis.edit-hobi');
    }
}
