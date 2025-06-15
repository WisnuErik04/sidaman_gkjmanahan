<?php

namespace App\Livewire\Admin\Bloks;

use App\Models\Blok;
use Livewire\Component;
use Livewire\Attributes\Title;
use Masmerise\Toaster\Toaster;

#[Title('Tambah Blok | Sidaman')]
class AddBlok extends Component
{
    public $menuName = 'Blok';
    public $name = '';

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ]);

        Blok::create([
            'name' => $this->name
        ]);

        $this->reset();

        Toaster::success('Blok added successfully!');

        // return redirect()->route('blok.index');
        return redirect()->to(route('blok.index'));
        // return redirect('/blok-list');
    }

    public function render()
    {
        return view('livewire.admin.bloks.add-blok');
        // return view('livewire.admin.bloks.add-blok', compact('bloks', 'jarakRumahs', 'kabupatenKotas', 'kecamatans', 'desaKelurahans'));
    }
}
