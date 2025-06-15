<?php

namespace App\Livewire\Admin\GolDarahs;

use Livewire\Component;
use App\Models\GolDarah;
use Livewire\Attributes\Title;
use Masmerise\Toaster\Toaster;

#[Title('Tambah Golongan Darah | Sidaman')]
class AddGolDarah extends Component
{
    public $menuName = 'Golongan Darah';
    public $name = '';

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ]);

        GolDarah::create([
            'name' => $this->name
        ]);

        $this->reset();

        Toaster::success('Golongan Darah added successfully!');

        // return redirect()->route('gol_darah.index');
        return redirect()->to(route('gol_darah.index'));
        // return redirect('/gol_darah-list');
    }

    public function render()
    {
        return view('livewire.admin.gol-darahs.add-gol-darah');
    }
}
