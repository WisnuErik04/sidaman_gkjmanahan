<?php

namespace App\Livewire\Admin\JarakRumahs;

use Livewire\Component;
use App\Models\JarakRumah;
use Livewire\Attributes\Title;
use Masmerise\Toaster\Toaster;

#[Title('Tambah Jarak Rumah | Sidaman')]
class AddJarakRumah extends Component
{
    public $menuName = 'Jarak Rumah';
    public $name = '';

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ]);

        JarakRumah::create([
            'name' => $this->name
        ]);

        $this->reset();

        Toaster::success('Jarak Rumah added successfully!');

        return redirect()->to(route('jarak_rumah.index'));
    }

    public function render()
    {
        return view('livewire.admin.jarak-rumahs.add-jarak-rumah');
    }
}
