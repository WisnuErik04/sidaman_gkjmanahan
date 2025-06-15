<?php

namespace App\Livewire\Admin\Ijazahs;

use App\Models\Ijazah;
use Livewire\Component;
use Livewire\Attributes\Title;
use Masmerise\Toaster\Toaster;

#[Title('Tambah Ijazah | Sidaman')]
class AddIjazah extends Component
{
    public $menuName = 'Ijazah';
    public $name = '';

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ]);

        Ijazah::create([
            'name' => $this->name
        ]);

        $this->reset();

        Toaster::success('Ijazah added successfully!');

        return redirect()->to(route('ijazah.index'));
    }

    public function render()
    {
        return view('livewire.admin.ijazahs.add-ijazah');
    }
}