<?php

namespace App\Livewire\Admin\JarakRumahs;

use Livewire\Component;
use App\Models\JarakRumah;
use Livewire\Attributes\Title;
use Masmerise\Toaster\Toaster;

#[Title('Edit Jarak Rumah | Sidaman')]
class EditJarakRumah extends Component
{
    public $menuName = 'Jarak Rumah';
    public $jarak_rumah_details;
    public $name = '';
   
    public function mount($id){
        $this->jarak_rumah_details = JarakRumah::find($id);
        
        $this->loadEdit($id);
    }

    public function loadEdit($id){
        $this->fill([
            'name' => $this->jarak_rumah_details->name,
        ]);
    }

    public function save(){
        $this->validate([
            'name' => 'required|string|max:255'
        ]);

        JarakRumah::find($this->jarak_rumah_details->id)->update([
            'name' => $this->name
        ]);

        $this->reset();

        Toaster::success('Jarak Rumah updated successfully!');

        return redirect()->to(route('jarak_rumah.index'));
    }

    public function render()
    {

        return view('livewire.admin.jarak-rumahs.edit-jarak-rumah');
    }
}