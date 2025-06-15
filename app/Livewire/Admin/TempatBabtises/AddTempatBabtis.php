<?php

namespace App\Livewire\Admin\TempatBabtises;

use Livewire\Component;
use App\Models\TempatBabtis;
use Livewire\Attributes\Title;
use Masmerise\Toaster\Toaster;


#[Title('Tambah Tempat Babtis | Sidaman')]
class AddTempatBabtis extends Component
{
    public $menuName = 'Tempat Babtis';
    public $name = '';

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ]);

        TempatBabtis::create([
            'name' => $this->name
        ]);

        $this->reset();

        Toaster::success('Tempat Babtis added successfully!');

        return redirect()->to(route('tempat_babtis.index'));
    }

    public function render()
    {
        return view('livewire.admin.tempat-babtises.add-tempat-babtis');
    }
}
