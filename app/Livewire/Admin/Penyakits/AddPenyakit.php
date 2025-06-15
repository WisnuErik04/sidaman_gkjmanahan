<?php

namespace App\Livewire\Admin\Penyakits;

use Livewire\Component;
use App\Models\Penyakit;
use Livewire\Attributes\Title;
use Masmerise\Toaster\Toaster;

#[Title('Tambah Penyakit | Sidaman')]
class AddPenyakit extends Component
{
    public $menuName = 'Penyakit';
    public $name = '';

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ]);

        Penyakit::create([
            'name' => $this->name
        ]);

        $this->reset();

        Toaster::success('Penyakit added successfully!');

        return redirect()->to(route('penyakit.index'));
    }

    public function render()
    {
        return view('livewire.admin.penyakits.add-penyakit');
    }
}
