<?php

namespace App\Livewire\Admin\Perkawinans;

use Livewire\Component;
use App\Models\Perkawinan;
use Livewire\Attributes\Title;
use Masmerise\Toaster\Toaster;

#[Title('Tambah Perkawinan | Sidaman')]
class AddPerkawinan extends Component
{
    public $menuName = 'Perkawinan';
    public $name = '';

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ]);

        Perkawinan::create([
            'name' => $this->name
        ]);

        $this->reset();

        Toaster::success('Perkawinan added successfully!');

        return redirect()->to(route('perkawinan.index'));
    }

    public function render()
    {
        return view('livewire.admin.perkawinans.add-perkawinan');
    }
}
