<?php

namespace App\Livewire\Admin\Pekerjaans;

use Livewire\Component;
use App\Models\Pekerjaan;
use Livewire\Attributes\Title;
use Masmerise\Toaster\Toaster;

#[Title('Tambah Pekerjaan | Sidaman')]
class AddPekerjaan extends Component
{
    public $menuName = 'Pekerjaan';
    public $name = '';

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ]);

        Pekerjaan::create([
            'name' => $this->name
        ]);

        $this->reset();

        Toaster::success('Pekerjaan added successfully!');

        return redirect()->to(route('pekerjaan.index'));
    }

    public function render()
    {
        return view('livewire.admin.pekerjaans.add-pekerjaan');
    }
}
