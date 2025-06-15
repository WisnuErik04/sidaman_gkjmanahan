<?php

namespace App\Livewire\Admin\TempatSidis;

use Livewire\Component;
use App\Models\TempatSidi;
use Livewire\Attributes\Title;
use Masmerise\Toaster\Toaster;


#[Title('Edit Tempat Sidi | Sidaman')]
class EditTempatSidi extends Component
{
    public $menuName = 'Tempat Sidi';
    public $tempat_sidi_details;
    public $name = '';
   
    public function mount($id){
        $this->tempat_sidi_details = TempatSidi::find($id);
        
        $this->loadEdit($id);
    }

    public function loadEdit($id){
        $this->fill([
            'name' => $this->tempat_sidi_details->name,
        ]);
    }

    public function save(){
        $this->validate([
            'name' => 'required|string|max:255'
        ]);

        TempatSidi::find($this->tempat_sidi_details->id)->update([
            'name' => $this->name
        ]);

        $this->reset();

        Toaster::success('Tempat Sidi updated successfully!');

        return redirect()->to(route('tempat_sidi.index'));
    }

    public function render()
    {

        return view('livewire.admin.tempat-sidis.edit-tempat-sidi');
    }
}